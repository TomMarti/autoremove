<?php


class PluginAutoremoveProfile extends CommonDBTM
{
    static function canCreate() {

        if (isset($_SESSION["glpi_plugin_devplugin_profile"])) {
            return ($_SESSION["glpi_plugin_devplugin_profile"]['devplugin'] == 'w');
        }
        return false;
    }

    static function canView() {

        if (isset($_SESSION["glpi_plugin_devplugin_profile"])) {
            return ($_SESSION["glpi_plugin_devplugin_profile"]['devplugin'] == 'w'
                || $_SESSION["glpi_plugin_devplugin_profile"]['devplugin'] == 'r');
        }
        return false;
    }

    static function createAdminAccess($ID) {

        $myProf = new self();
        // si le profile n'existe pas déjà dans la table profile de mon plugin
        if (!$myProf->getFromDB($ID)) {
            // ajouter un champ dans la table comprenant l'ID du profil d la personne connecté et le droit d'écriture
            $myProf->add(array('id' => $ID,
                'right'       => 'w'));
        }
    }

    function showForm($id, $options=array()) {

        $target = $this->getFormURL();
        if (isset($options['target'])) {
            $target = $options['target'];
        }

        if (!Session::haveRight("profile","r")) {
            return false;
        }

        $canedit = Session::haveRight("profile", "w");
        $prof = new Profile();
        if ($id){
            $this->getFromDB($id);
            $prof->getFromDB($id);
        }

        echo "<form action='".$target."' method='post'>";
        echo "<table class='tab_cadre_fixe'>";
        echo "<tr><th colspan='2' class='center b'>".sprintf(__('%1$s %2$s'), ('gestion des droits :'),
                Dropdown::getDropdownName("glpi_profiles",
                    $this->fields["id"]));
        echo "</th></tr>";

        echo "<tr class='tab_bg_2'>";
        echo "<td>Utiliser Mon Plugin</td><td>";
        Profile::dropdownNoneReadWrite("right", $this->fields["right"], 1, 1, 1);
        echo "</td></tr>";

        if ($canedit) {
            echo "<tr class='tab_bg_1'>";
            echo "<td class='center' colspan='2'>";
            echo "<input type='hidden' name='id' value=$id>";
            echo "<input type='submit' name='update_user_profile' value='Mettre à jour'
                class='submit'>";
            echo "</td></tr>";
        }
        echo "</table>";
        Html::closeForm();
    }

    function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {

        if ($item->getType() == 'Profile') {
            return "Autoremove";
        }
        return '';
    }

    static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

        if ($item->getType() == 'Profile') {
            $prof = new self();
            $ID = $item->getField('id');
            // j'affiche le formulaire
            $prof->showForm($ID);
        }
        return true;
    }
}