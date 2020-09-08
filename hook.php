<?php

/**
 * Install hook
 *
 * @return boolean
 */
function plugin_autoremove_install()
{
    //do some stuff like instanciating databases, default values, ...
    createADbTable("set_global_scheduler_glpi_plugin_autoremove",
        "SET GLOBAL event_scheduler = ON;");

    createADbTable("glpi_plugin_autoremove_remove", "CREATE EVENT glpi_plugin_autoremove_remove
    ON SCHEDULE EVERY 1440 MINUTE DO
        UPDATE glpi_softwares
        SET is_deleted = 1
        WHERE glpi_softwares.id IN (SELECT id FROM (SELECT DISTINCT `glpi_softwares`.`id` AS id, 'glpi' AS currentuser, `glpi_softwares`.`entities_id`, `glpi_softwares`.`is_recursive`, `glpi_softwares`.`name` AS `ITEM_Software_1`, `glpi_softwares`.`id` AS `ITEM_Software_1_id`, `glpi_manufacturers`.`name` AS `ITEM_Software_23`, GROUP_CONCAT(DISTINCT CONCAT(IFNULL(`glpi_softwareversions`.`name`, '__NULL__'), '$#$',`glpi_softwareversions`.`id`)
        ORDER BY `glpi_operatingsystems_0a35c270152be19b5c8a485502badcd7`.`id` SEPARATOR '$$##$$') AS `ITEM_Software_4`, COUNT(DISTINCT `glpi_computers_softwareversions_dfb0ea52269e2c3215f034c26bee9fbf`.`id`) AS `NUMBERUSE`, FLOOR(SUM(`glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619`.`number`) * COUNT(DISTINCT `glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619`.`id`) / COUNT(`glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619`.`id`)) AS `ITEM_Software_163`, MIN(`glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619`.`number`) AS `ITEM_Software_163_min`
        FROM `glpi_softwares`
        LEFT JOIN `glpi_manufacturers` ON (`glpi_softwares`.`manufacturers_id` = `glpi_manufacturers`.`id` )
        LEFT JOIN `glpi_softwareversions` ON (`glpi_softwares`.`id` = `glpi_softwareversions`.`softwares_id` )
        LEFT JOIN `glpi_operatingsystems` AS `glpi_operatingsystems_0a35c270152be19b5c8a485502badcd7` ON (`glpi_softwareversions`.`operatingsystems_id` = `glpi_operatingsystems_0a35c270152be19b5c8a485502badcd7`.`id` )
        LEFT JOIN `glpi_computers_softwareversions` AS `glpi_computers_softwareversions_dfb0ea52269e2c3215f034c26bee9fbf` ON (`glpi_softwareversions`.`id` = `glpi_computers_softwareversions_dfb0ea52269e2c3215f034c26bee9fbf`.`softwareversions_id` AND `glpi_computers_softwareversions_dfb0ea52269e2c3215f034c26bee9fbf`.`is_deleted_computer` = 0 AND `glpi_computers_softwareversions_dfb0ea52269e2c3215f034c26bee9fbf`.`is_deleted` = 0 AND `glpi_computers_softwareversions_dfb0ea52269e2c3215f034c26bee9fbf`.`is_template_computer` = 0 )
        LEFT JOIN `glpi_softwarelicenses` AS `glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619` ON (`glpi_softwares`.`id` = `glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619`.`softwares_id` AND `glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619`.`is_template` = 0 AND (`glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619`.`expire` IS NULL OR `glpi_softwarelicenses_daf59b6b5fae84097745ab089c081619`.`expire` > NOW()) )
        WHERE `glpi_softwares`.`is_deleted` = 0 AND `glpi_softwares`.`is_template` = 0 GROUP BY `glpi_softwares`.`id`
        ORDER BY NUMBERUSE ASC LIMIT 0, 5000) sub WHERE NUMBERUSE = 0)");


    return true;
}

/**
 * Uninstall hook
 *
 * @return boolean
 */
function plugin_autoremove_uninstall()
{
    //to some stuff, like removing tables, generated files, ...
    global $DB;

    $tablename = 'glpi_plugin_autoremove_remove';
    //Create table only if it does not exists yet!

    $DB->queryOrDie(
        "DROP EVENT `$tablename`",
        $DB->error()
    );

    return true;
}

function createADbTable ($name, $request) {
    global $DB;

    //instanciate migration with version
    $migration = new Migration(100);

    //Create table only if it does not exists yet!
    if (!$DB->tableExists($name)) {
        //table creation query
        $query = $request;
        $DB->queryOrDie($query, $DB->error());
    }

    //execute the whole migration
    $migration->executeMigration();
}