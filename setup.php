<?php

define('AUTOREMOVE_VERSION', '0.1');

/**
 * Init the hooks of the plugins - Needed
 *
 * @return void
 */
function plugin_init_autoremove() {
    global $PLUGIN_HOOKS;

    //required!
    $PLUGIN_HOOKS['csrf_compliant']['autoremove'] = true;

    //some code here, like call to Plugin::registerClass(), populating PLUGIN_HOOKS, ...
}

/**
 * Get the name and the version of the plugin - Needed
 *
 * @return array
 */
function plugin_version_autoremove() {
    return [
        'name'           => 'Autoremove',
        'version'        => AUTOREMOVE_VERSION,
        'author'         => 'Tom Marti',
        'license'        => 'GPLv3',
        'homepage'       => 'https://github.com/TomMarti/autoremove',
        'requirements'   => [
            'glpi'   => [
                'min' => '9.1'
            ]
        ]
    ];
}

/**
 * Optional : check prerequisites before install : may print errors or add to message after redirect
 *
 * @return boolean
 */
function plugin_autoremove_check_prerequisites() {
    //do what the checks you want
    return true;
}

/**
 * Check configuration process for plugin : need to return true if succeeded
 * Can display a message only if failure and $verbose is true
 *
 * @param boolean $verbose Enable verbosity. Default to false
 *
 * @return boolean
 */
function plugin_autoremove_check_config($verbose = false) {
    if (true) { // Your configuration check
        return true;
    }

    if ($verbose) {
        echo "Installed, but not configured";
    }
    return false;
}