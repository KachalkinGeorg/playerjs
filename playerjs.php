<?php


if(!defined('NGCMS')) exit('HAL');

class PlayerJSFilter extends NewsFilter {
	
    function showNews($newsID, $SQLnews, &$tvars, $mode = array()) {
		global $lang, $template, $mysql, $twig;

		$tpath = locatePluginTemplates(array('playerjs', ':playerjs.js'), 'playerjs', pluginGetVariable('playerjs', 'localsource'), pluginGetVariable('playerjs', 'skin') ? pluginGetVariable('playerjs', 'skin') : 'default');
		$xt = $twig->loadTemplate($tpath['playerjs'].'playerjs.tpl');
		
		$row = $mysql->record("select * from " . prefix . "_news where id = " . db_squote($newsID)." LIMIT 1");

		register_htmlvar('js', $tpath['url::playerjs.js'].'/playerjs.js');

		if( !empty($row['playerjs']) ) {
			$playlist = array();
			$array_playlist = explode('||', $row['playerjs']);

			foreach ($array_playlist as $value) {
				$playl = explode("|", $value);
				$playlist[] = "{'title':'" . $playl[0] . "','file':'" . $playl[1] . "'}";
			}

			$playlist = implode(",", $playlist);
			$playlist = "[" . $playlist . "]";

		}

		$tVars = array(
			'playlist'       => $playlist,
		);

		$tvars['vars']['playerjs'] = $xt->render($tVars);

	}
}

register_filter('news','playerjs', new PlayerJSFilter);

?>