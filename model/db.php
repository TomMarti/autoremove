<?php


namespace model;


class db
{
    function notes () {
        $dbRequest = "(SELECT id, name, nbrofuse FROM (SELECT glpi.glpi_softwares.id as id ,glpi.glpi_softwares.name as name, count(glpi.glpi_softwares.id) as nbrofuse FROM glpi_softwares
                                                                                                                                                           INNER JOIN glpi.glpi_computers_softwareversions
                                                                                                                                                                      ON glpi_softwares.id = glpi.glpi_computers_softwareversions.softwareversions_id
                                 GROUP BY glpi.glpi_softwares.id) sub
 WHERE nbrofuse = 1)";
    }
}