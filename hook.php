<?php
function plugin_autoremove_install() {
    global $DB;

    $migration = new Migration(100);

    // Création de la table uniquement lors de la première installation
    if (!TableExists("glpi_plugin_autoremove_profiles")) {

        // requete de création de la table
        $query = "CREATE TABLE `glpi_plugin_autoremove_profiles` (
               `id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
               `right` char(1) collate utf8_unicode_ci default NULL,
               PRIMARY KEY  (`id`)
             ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

        $DB->queryOrDie($query, $DB->error());

        $migration->executeMigration();

        //creation du premier accès nécessaire lors de l'installation du plugin
        include_once(GLPI_ROOT."/plugins/autoremove/inc/profile.php");
        PluginAutoremoveProfile::createAdminAccess($_SESSION['glpiactiveprofile']['id']);
    }

    return true;
}

function plugin_autoremove_uninstall() {
    global $DB;

    $tables = array("glpi_plugin_autoremove_profiles");

    foreach($tables as $table) {
        $DB->query("DROP TABLE IF EXISTS `$table`;");
    }

    return true;
}