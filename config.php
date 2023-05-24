<?php

if (!defined('NGCMS')) die ('HAL');

pluginsLoadConfig();
LoadPluginLang('playerjs', 'config', '', '', '#');

switch ($_REQUEST['action']) {
	case 'about':			about();		break;
	default: main();
}

function about()
{global $twig, $lang, $breadcrumb;
	$tpath = locatePluginTemplates(array('main', 'about'), 'playerjs', 1);
	$breadcrumb = breadcrumb('<i class="fa fa-play-circle btn-position"></i><span class="text-semibold">'.$lang['playerjs']['playerjs'].'</span>', array('?mod=extras' => '<i class="fa fa-puzzle-piece btn-position"></i>'.$lang['extras'].'', '?mod=extra-config&plugin=playerjs' => '<i class="fa fa-play-circle btn-position"></i>'.$lang['playerjs']['playerjs'].'',  '<i class="fa fa-exclamation-circle btn-position"></i>'.$lang['playerjs']['about'].'' ) );

	$xt = $twig->loadTemplate($tpath['about'].'about.tpl');
	$tVars = array();
	$xg = $twig->loadTemplate($tpath['main'].'main.tpl');
	
	$about = 'версия 0.2';
	
	$tVars = array(
		'global' => 'О плагине',
		'header' => $about,
		'entries' => $xt->render($tVars)
	);
	
	print $xg->render($tVars);
}

function main()
{global $twig, $lang, $breadcrumb;
	
	$tpath = locatePluginTemplates(array('main', 'general.from'), 'playerjs', 1);
	$breadcrumb = breadcrumb('<i class="fa fa-play-circle btn-position"></i><span class="text-semibold">'.$lang['playerjs']['playerjs'].'</span>', array('?mod=extras' => '<i class="fa fa-puzzle-piece btn-position"></i>'.$lang['extras'].'', '?mod=extra-config&plugin=playerjs' => '<i class="fa fa-play-circle btn-position"></i>'.$lang['playerjs']['playerjs'].'' ) );

	if (isset($_REQUEST['submit'])){
		pluginSetVariable('playerjs', 'localsource', (int)$_REQUEST['localsource']);
		pluginsSaveConfig();
		msg(array("type" => "info", "info" => "сохранение прошло успешно"));
		return print_msg( 'info', ''.$lang['playerjs']['playerjs'].'', 'Cохранение прошло успешно', 'javascript:history.go(-1)' );
	}
	
	$xt = $twig->loadTemplate($tpath['general.from'].'general.from.tpl');
	$xg = $twig->loadTemplate($tpath['main'].'main.tpl');
	
	$tVars = array(
		'localsource'       => MakeDropDown(array(0 => 'Шаблон сайта', 1 => 'Плагина'), 'localsource', (int)pluginGetVariable('playerjs', 'localsource')),
	);
	
	$tVars = array(
		'global' => 'Общие',
		'header' => '<i class="fa fa-exclamation-circle"></i> <a href="?mod=extra-config&plugin=playerjs&action=about">'.$lang['playerjs']['about'].'</a>',
		'entries' => $xt->render($tVars)
	);
	
	print $xg->render($tVars);
}

?>