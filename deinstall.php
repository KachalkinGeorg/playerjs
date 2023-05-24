<?php
// Protect against hack attempts
if (!defined('NGCMS')) die ('HAL');

loadPluginLang('playerjs', 'config', '', '', ':');

$db_update = array(
	array(
		'table'  => 'news',
		'action' => 'modify',
		'fields' => array(
			array('action' => 'drop', 'name' => 'playerjs'),
		)
	)
);

if ($_REQUEST['action'] == 'commit') {
	if (fixdb_plugin_install('playerjs', $db_update, 'deinstall')) {
		plugin_mark_deinstalled('playerjs');
	}
} else {
	generate_install_page('playerjs', $lang['playerjs:deinstall'], 'deinstall');
}