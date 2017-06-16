<?
IncludeModuleLangFile(__FILE__);
global $MESS;

if(class_exists("wsm_import1c"))
        return;

Class wsm_import1c extends CModule
{
	var $MODULE_ID = 'wsm.import1c'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";
    var $MODULE_PATH;

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		
		$this->MODULE_NAME = GetMessage("WSM_IMPORT1C_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("WSM_IMPORT1C_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("WSM_IMPORT1C_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("WSM_IMPORT1C_PARTNER_URI");

        $a_path = dirname(__FILE__);
        $r_path = str_replace($_SERVER['DOCUMENT_ROOT'], "", $a_path);
        $m_path = strpos($r_path, "/local") === 0 ? "/local" : "/bitrix";

        $this->MODULE_PATH = $m_path."/modules/".$this->MODULE_ID;
	}

    function InstallDB($arParams = array())
    {
        global $DB, $APPLICATION;

        $this->errors = false;
        $this->errors = $DB->RunSQLBatch(dirname(__FILE__).'/db/'.strtolower($DB->type).'/install.sql');

        if($this->errors !== false)
        {
            $APPLICATION->ThrowException(implode("<br>", $this->errors));
            return false;
        }

        return true;
    }

    function UnInstallDB($arParams = array())
    {
        GLOBAL $DB;

        if(!array_key_exists("save_options", $arParams) || ($arParams["save_options"] != "Y"))
            COption::RemoveOption($this->MODULE_ID);

        if(!array_key_exists("save_data", $arParams) || ($arParams["save_data"] != "Y"))
            $this->errors = $DB->RunSQLBatch(dirname(__FILE__).'/db/'.strtolower($DB->type).'/uninstall.sql');

        return true;
    }

    function InstallFiles($arParams = array())
    {
        #-----------------------------------------------------------------
        #admin page
        #-----------------------------------------------------------------
        if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].$this->MODULE_PATH.'/admin'))
        {
            if ($dir = opendir($p))
            {
                while (false !== $item = readdir($dir))
                {
                    if ($item == '..' || $item == '.' || $item == 'menu.php')
                        continue;

                    file_put_contents(
                        $file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$item,
                        '<'.'? require($_SERVER["DOCUMENT_ROOT"]."'.$this->MODULE_PATH.'/admin/'.$item.'");?'.'>');
                }
                closedir($dir);
            }
        }

        #-----------------------------------------------------------------
        #themes
        #-----------------------------------------------------------------
        CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"].$this->MODULE_PATH.'/install/themes',
            $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes",
            true,
            true
        );

        return true;
    }

    function InstallEvents()
    {
        include_once(dirname(__FILE__).'/install_events.php');
        return true;
    }

    function UnInstallEvents($arParams = array())
    {
        if(!array_key_exists("save_event_templates", $arParams) && $arParams["save_event_templates"] != "Y")
        {
            $statusMes[] = "WSM_IMPORT1C_STRUCTURE_NEW";

            foreach($statusMes as $v)
            {
                $eventType = new CEventType;
                $eventType->Delete($v);

                $eventM = new CEventMessage;
                $dbEvent = CEventMessage::GetList($b="ID", $order="ASC", Array("EVENT_NAME" => $v));
                while($arEvent = $dbEvent->Fetch())
                {
                    $eventM->Delete($arEvent["ID"]);
                }
            }
        }

        return true;
    }

    function UnInstallFiles($arParams = array())
    {

        # remove admin page
        DeleteDirFiles(
            $_SERVER["DOCUMENT_ROOT"].$this->MODULE_PATH.'/admin',
            $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin"
        );

        # remove css
        DeleteDirFiles(
            $_SERVER["DOCUMENT_ROOT"].$this->MODULE_PATH.'/install/themes/.default/',
            $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes/.default");

        # remove ions, images
        DeleteDirFilesEx('/bitrix/themes/.default/icons/'.$this->MODULE_ID.'/');
        DeleteDirFilesEx('/bitrix/themes/.default/images/'.$this->MODULE_ID.'/');
        return true;
    }

	function DoInstall()
	{
		global $APPLICATION;

        $GLOBALS["errors"] = false;

        $this->InstallFiles();
        $this->InstallDB();
        $this->InstallEvents();

        #elements
        RegisterModuleDependences("iblock",
            "OnBeforeIBlockElementAdd",
            "wsm.import1c",
            "WsmImport1cIBlockElements",
            "OnBeforeIBlockElementAddUpdateHandler");

        RegisterModuleDependences("iblock",
            "OnBeforeIBlockElementUpdate",
            "wsm.import1c",
            "WsmImport1cIBlockElements",
            "OnBeforeIBlockElementAddUpdateHandler");

        #sections
        RegisterModuleDependences("iblock",
            "OnBeforeIBlockSectionAdd",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnBeforeIBlockSectionAddHandler");

        RegisterModuleDependences("iblock",
            "OnBeforeIBlockSectionUpdate",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnBeforeIBlockSectionUpdateHandler");

        RegisterModuleDependences("iblock",
            "OnAfterIBlockSectionAdd",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnAfterIBlockSectionAddHandler");

        RegisterModuleDependences("iblock",
            "OnAfterIBlockSectionUpdate",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnAfterIBlockSectionUpdateHandler");

        RegisterModuleDependences("iblock",
            "OnBeforeIBlockSectionDelete",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnBeforeIBlockSectionDeleteHandler");

        #catalog
        RegisterModuleDependences("catalog",
            "OnSuccessCatalogImport1C",
            "wsm.import1c",
            "WsmImport1cIBlockElements",
            "OnSuccessCatalogImport1CHandler");

        RegisterModuleDependences("search",
            "BeforeIndex",
            "wsm.import1c",
            "WsmImport1cIBlockSearch",
            "BeforeIndexHandler");
			
		#price_rules

        RegisterModuleDependences("catalog",
            "OnBeforePriceUpdate",
            "wsm.import1c",
            "\\WSM\\Import1c\\Price",
            "OnBeforePriceUpdateHandler");

		RegisterModuleDependences("catalog",
            "OnPriceUpdate",
            "wsm.import1c",
            "\\WSM\\Import1c\\Price",
            "OnPriceUpdateHandler");
			
		#изменение разделов
		RegisterModuleDependences("iblock",
            "OnAfterIBlockSectionAdd",
            "wsm.import1c",
            "\\WSM\\Import1c\\Price",
            "OnAfterIBlockSectionAddHandler");
			
		RegisterModuleDependences("iblock",
            "OnAfterIBlockSectionUpdate",
            "wsm.import1c",
            "\\WSM\\Import1c\\Price",
            "OnAfterIBlockSectionUpdateHandler");
			
			


        RegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile(GetMessage("WSM_IMPORT1C_INSTALL_TITLE"), dirname(__FILE__)."/step2.php");
	}

	function DoUninstall()
	{
		global $APPLICATION;

        $this->UnInstallFiles();
        $this->UnInstallDB();
        $this->UnInstallEvents();

        #elements
        UnRegisterModuleDependences("iblock",
            "OnBeforeIBlockElementAdd",
            "wsm.import1c",
            "WsmImport1cIBlockElements",
            "OnBeforeIBlockElementAddUpdateHandler");

        UnRegisterModuleDependences("iblock",
            "OnBeforeIBlockElementUpdate",
            "wsm.import1c",
            "WsmImport1cIBlockElements",
            "OnBeforeIBlockElementAddUpdateHandler");

        #sections
        UnRegisterModuleDependences("iblock",
            "OnBeforeIBlockSectionAdd",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnBeforeIBlockSectionAddHandler");

        UnRegisterModuleDependences("iblock",
            "OnBeforeIBlockSectionUpdate",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnBeforeIBlockSectionUpdateHandler");

        UnRegisterModuleDependences("iblock",
            "OnAfterIBlockSectionAdd",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnAfterIBlockSectionAddHandler");

        UnRegisterModuleDependences("iblock",
            "OnAfterIBlockSectionUpdate",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnAfterIBlockSectionUpdateHandler");

        UnRegisterModuleDependences("iblock",
            "OnBeforeIBlockSectionDelete",
            "wsm.import1c",
            "WsmImport1cIBlockSections",
            "OnBeforeIBlockSectionDeleteHandler");

        #catalog
        UnRegisterModuleDependences("catalog",
            "OnSuccessCatalogImport1C",
            "wsm.import1c",
            "WsmImport1cIBlockElements",
            "OnSuccessCatalogImport1CHandler");

        UnRegisterModuleDependences("search",
            "BeforeIndex",
            "wsm.import1c",
            "WsmImport1cIBlockSearch",
            "BeforeIndexHandler");
		
		#price_rules

        UnRegisterModuleDependences("catalog",
            "OnBeforePriceUpdate",
            "wsm.import1c",
            "\\WSM\\Import1c\\Price",
            "OnBeforePriceUpdateHandler");

		UnRegisterModuleDependences("catalog",
            "OnPriceUpdate",
            "wsm.import1c",
            "\\WSM\\Import1c\\Price",
            "OnBeforePriceUpdateHandler");
			/*
		UnRegisterModuleDependences("catalog",
            "OnBeforePriceUpdate",
            "wsm.import1c",
            "WsmImport1cCatalogPrice",
            "OnBeforePriceUpdateHandler");*/
			
		UnRegisterModuleDependences("iblock",
            "OnAfterIBlockSectionAdd",
            "wsm.import1c",
            "\\WSM\\Import1c\\Price",
            "OnAfterIBlockSectionAddHandler");
			
		UnRegisterModuleDependences("iblock",
            "OnAfterIBlockSectionUpdate",
            "wsm.import1c",
            "\\WSM\\Import1c\\Price",
            "OnAfterIBlockSectionUpdateHandler");

        UnRegisterModule($this->MODULE_ID);

		$APPLICATION->IncludeAdminFile(GetMessage("WSM_IMPORT1C_UNINSTALL_TITLE"),  dirname(__FILE__)."/unstep2.php");

	}
	
}
?>