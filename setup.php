<?php
function plugin_version_autoremove() {
    return array(
        'name'           => "Autoremove",
        'version'        => '0.0.1',
        'author'         => 'Tom Marti',
        'license'        => 'GPLv3',
        'homepage'       => 'https://github.com/TomMarti/autoremove',
        'minGlpiVersion' => '0.84'
    );// For compatibility / no install in version < 0.80
}

function plugin_autoremove_check_prerequisites() {
    if (version_compare(GLPI_VERSION,'0.84','lt') || version_compare(GLPI_VERSION,'0.85','gt')) {
        echo "This plugin requires GLPI >= 0.84 and GLPI < 0.85";
        return false;
    }
    return true;
}

function plugin_autoremove_check_config($verbose=false) {
    if (true) { // Your configuration check
        return true;
    }

    if ($verbose) {
        echo 'Installed / not configured';
    }
    return false;
}

function plugin_init_autoremove() {
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['autoremove'] = true;
    Plugin::registerClass('PluginAutoremoveProfile');
    Plugin::registerClass('PluginAutoremoveProfile', array('addtabon' => array('Profile')));
}