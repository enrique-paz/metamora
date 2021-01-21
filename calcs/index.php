<?
include_once('variables.php');
include_once('settings.php');
include_once('lang/'.$Variables->Language .'/lang.php');

if (!class_exists('smarty'))
	include_once('libs/Smarty.class.php');
include_once('functions.php');

// Including common header
include('templates/'. $Variables->Template .'/header.php');

$CalcContent = _show_form();

// Including common footer from the templates directory
include('templates/'. $Variables->Template .'/footer.php');


function _show_form() {
	// Making required variables visible into this function.
	global $Variables, $CalcSettings;

	// Creating a Smarty class instance and assigning values array to it.
	$smarty = new Smarty();
	$smarty->assign('vars', $vars);
	$smarty->assign('lang', $Variables->LangVar); 
	$content = $smarty->fetch($Variables->Template.'/index.tpl');

	// Displaying form with values or returning content
	if ($CalcSettings->ReturnContent)
		return $content;
	else
		echo $content;
}
?>