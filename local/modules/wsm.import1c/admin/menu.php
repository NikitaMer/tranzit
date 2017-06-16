<?
IncludeModuleLangFile(__FILE__);

$module_id = 'wsm.import1c';

$rsModule = CModule::IncludeModuleEx($module_id);

if($rsModule != MODULE_INSTALLED && $rsModule != MODULE_DEMO)
    return;

if($APPLICATION->GetGroupRight($module_id)!="D")
{
	$aMenu = array(
		"parent_menu" => "global_menu_store",
		"section" => "wsm_import1c",
		"module_id"=> $module_id,
		"sort" => 500,
		"text" => GetMessage("mnu_wsm_import1c"),
		"title" => GetMessage("mnu_wsm_import1c_title"),
		"icon" => "mnu_wsm_import1c_icon",
		"page_icon" => "mnu_wsm_import1c_icon",
		"url" => "wsm_import1c_price_rules.php?lang=".LANGUAGE_ID,
		"more_url" => Array("wsm_import1c_price_rules_edit.php"),
		"items_id" => "wsm_import1c",
		);

	return $aMenu;
}

return false;