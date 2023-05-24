<?php
if (!defined('NGCMS'))
{
	die ('HAL');
}

function plugin_playerjs_install($action) {
	global $lang;
	
	if ($action != 'autoapply')
		loadPluginLang('playerjs', 'config', '', '', ':');
	
	$db_update = array(
		array(
			'table' => 'news',
			'action' => 'modify',
			'key' => 'primary key (`id`)',
			'fields' => array(
				array('action' => 'cmodify', 'name' => 'playerjs', 'type' => 'text', 'params' => 'NOT NULL')
			)
		)
	);
	
	switch ($action) {
		case 'confirm':
			generate_install_page('playerjs', $lang['playerjs:install']);
			break;
		case 'autoapply':
		case 'apply':
			if (fixdb_plugin_install('playerjs', $db_update, 'install', ($action == 'autoapply') ? true : false)) {
				plugin_mark_installed('playerjs');
			} else {
				return false;
			}
			// Now we need to set some default params
			$params = array(
				'localsource'   => 1,
			);
			foreach ($params as $k => $v) {
				extra_set_param('playerjs', $k, $v);
			}
			extra_commit_changes();
			break;
	}

	return true;
}