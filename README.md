# autoremove
A GLPI plugin for removing automatically the unused softwares of your IT parc 

# how it work
The plugin will add a cleaning task into the database

# installation
1. Download the github repo
2. Unzip the repo folder into the plugins folder. It must look something like this (/glpi/plugins/autoremove/thefiles).
3. Go on configuration -> plugins on the GLPI panel
4. Click on install
5. Active it

# check the event
1. Connect to the database
2. Execute "SHOW EVENTS"
3. The event "glpi_plugin_autoremove_remove" have to appear
