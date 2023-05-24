<?php
/*
=====================================================
 Добавление для новости
-----------------------------------------------------
 Author: KachalkinGeorg
-----------------------------------------------------
 E-mail: KachalkinGeorg@yandex.ru
=====================================================
 © GK
-----------------------------------------------------
 Данный код защищен авторскими правами
=====================================================
*/

if (!defined('NGCMS'))
	exit('HAL');

class PlayerJSNewsFilter extends NewsFilter {
	
	function addNewsForm(&$tvars) {
		global $mysql, $twig, $lang;


        $ttvars = array(
            'localPrefix' => localPrefix,
			'admin_url' => admin_url,
            );

		$extends = 'additional';

		$tpath = locatePluginTemplates(array('playerjs'), 'playerjs', pluginGetVariable('playerjs', 'localsource'));
        $tvars['extends'][$extends][] = [
			'title' => 'Плейлист PlayerJS',
			'body' => $twig->render($tpath['playerjs'].'/playerjs.tpl', $ttvars),
			];

	}
	
	function addNews(&$tvars, &$SQL) {
		
		$SQL['playerjs'] = $_REQUEST['playerjs'];
		
		return 1;
	}
	
	function addNewsNotify(&$tvars, $SQL, $newsid) {
		global $mysql;
		
		$playerjs = secure_html($_REQUEST['playerjs']);
		$mysql->query("update " . prefix . "_news set playerjs = " . db_squote($playerjs) . " where id = " . intval($newsID));
		
	}
	
	function editNewsForm($newsID, $SQLold, &$tvars){
		global $mysql, $twig, $lang;
	
				
        $ttvars = array(
            'localPrefix' => localPrefix,
			'admin_url' => admin_url,
			'playerjs' => $SQLold['playerjs'],
            );

		$extends = 'additional';

		$tpath = locatePluginTemplates(array('playerjs'), 'playerjs', pluginGetVariable('playerjs', 'localsource'));
        $tvars['extends'][$extends][] = [
			'title' => 'Плейлист PlayerJS',
			'body' => $twig->render($tpath['playerjs'].'/playerjs.tpl', $ttvars),
			];
	}
	
	function editNews($newsID, $SQLold, &$SQLnew, &$tvars)
	{global $mysql, $config;
	
		$playerjs = secure_html($_REQUEST['playerjs']);
		
		$mysql->record("update " . prefix . "_news set playerjs = " . db_squote($playerjs) . " where id = " . intval($newsID));

		return true;
	}
}

register_filter('news','playerjs', new PlayerJSNewsFilter);