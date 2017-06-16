<?
$module_id = 'wsm.import1c';

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
//require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/include.php");

use \Bitrx\Main;
use \Wsm\Import1c\Price\RulesTable as PriceRules;


if(
    !\Bitrix\Main\Loader::includeModule($module_id) ||
    !\Bitrix\Main\Loader::includeModule("iblock") ||
    !\Bitrix\Main\Loader::includeModule("catalog"))
    return;

IncludeModuleLangFile(__FILE__);

$POST_RIGHT = $APPLICATION->GetGroupRight($module_id);
if($POST_RIGHT=="D")
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));


$sTableID = PriceRules::getTableName()."_interface";

$oSort = new CAdminSorting($sTableID, "ID", "DESC");
$lAdmin = new CAdminList($sTableID, $oSort);

//**************************************************
//*** FILTER ***
//**************************************************
$arFilterFields = Array(
	"find_ID",
	);

$lAdmin->InitFilter($arFilterFields);

$arFilter = array(
	'ID' 		=> $find_ID,
	);

foreach($arFilter as $key => $value)
	if(!strlen($value))
		unset($arFilter[$key]);

// ***************************************************
$arIBlock = array();
$arSections = array();
$arPriceType = array();
$arMargeType = \WSM\Import1c\Price\RulesTable::getMargeType();

# price type
$rs = GetCatalogGroups('SORT','ASC');
while($p = $rs->GetNext())
    $arPriceType[$p['ID']] = $p['NAME'].($p['BASE'] == 'Y' ? ' [B]' : '');

#iblock
$IBLOCK_TYPE = WsmImport1cIBlockHelper::getIBlockType1C();

$res = CIBlock::GetList(array(), array('TYPE'=>$IBLOCK_TYPE),true);
while($ar = $res->Fetch())
{
    $mxResult = CCatalogSKU::GetInfoByOfferIBlock($ar['ID']);

    if(!is_array($mxResult))
    {
        $arIBlock[$ar['ID']] = $ar;

        $arFilterS = array(
            'IBLOCK_ID' => $ar['ID'],
            );

        $rs = CIBlockSection::GetList(Array("left_margin"=>"asc"), $arFilterS);
        while($s = $rs->GetNext())
        {
            $arSections[$ar['ID']][$s['ID']] = array(
                'ID' => $s['ID'],
                'IBLOCK_ID' => $s['IBLOCK_ID'],
                'NAME' => $s['NAME'],
                'IBLOCK_SECTION_ID' => $s['IBLOCK_SECTION_ID'],
                'DEPTH_LEVEL' => $s['DEPTH_LEVEL'],
            );
        }
    }
}









// ***************************************************
// *** edit ***
// ***************************************************
if($lAdmin->EditAction() && $POST_RIGHT=="W")
{
	foreach($FIELDS as $ID => $arFields)
	{
		if(!$lAdmin->IsUpdated($ID))
			continue;

        $ID = IntVal($ID);
		$rsData = PriceRules::getById($ID);

		if($arData = $rsData->fetch())
		{
			foreach($arFields as $key => $value)
				$arData[$key]=$value;

            $res = PriceRules::update($ID, $arData);
            if(!$res->isSuccess())
                $lAdmin->AddUpdateError(GetMessage("SAVE_ERROR", array("#ID#"=>$ID, "#ERROR_TEXT#"=>$res->getErrorMessages())), $ID);
		}
	}
}

// ***************************************************
// *** group action ***
// ***************************************************
if(($arID = $lAdmin->GroupAction()))
{
	if($_REQUEST['action_target']=='selected')
	{
        $rsData = PriceRules::getList(array($by=>$order), $arFilter);
        while($arRes = $rsData->fetch())
            $arID[] = $arRes['ID'];
	}

	foreach($arID as $ID)
	{
		if(strlen($ID)<=0)
			continue;

		$ID = IntVal($ID);
		
		$rsRes = PriceRules::getById($ID);
		$arRes = $rsRes->fetch();

		if(!$arRes)
			continue;
		
		switch($_REQUEST['action'])
		{

            case "delete":
                $result = PriceRules::delete($ID);
                if(!$result->isSuccess())
                    $lAdmin->AddGroupError("(ID=".$ID.") ".implode("<br>", $result->getErrorMessages()), $ID);
                break;

            case 'activate':
            case 'deactivate':
                PriceRules::update($ID, array('ACTIVE' => $_REQUEST['action'] == 'activate' ? 'Y' : 'N'));
                break;
		}
		
		if(isset($return_url) && strlen($return_url)>0)
			LocalRedirect($return_url);
	}
}

$rsData = PriceRules::getList(array('order'=>array($by => $order), 'filter' => $arFilter));
$rsData = new CAdminResult($rsData, $sTableID);
$rsData->NavStart();

// navigation setup
$lAdmin->NavText($rsData->GetNavPrint(GetMessage("SEARCH_PHL_PHRASES")));

$aContext=array();
$arElements = array();
$arUsers = array();


$lAdmin->AddAdminContextMenu($aContext);

$arHeaders=array(
	array(
		"id"=>"ID", 
		"content"=>GetMessage("WSM_IMPORT1C_RULES_F_ID"),
		"sort"=>"ID", 
		"default"=>true
		),
	array(
		"id"=>"DATE_CREATE", 
		"content"=>GetMessage("WSM_IMPORT1C_RULES_F_DATE_CREATE"),
		"sort"=>"DATE_CREATE", 
		"default"=>false
		),
    array(
        "id"=>"DATE_CHANGE",
        "content"=>GetMessage("WSM_IMPORT1C_RULES_F_DATE_CHANGE"),
        "sort"=>"DATE_CHANGE",
        "default"=>false
        ),

    array(
        "id"=>"IBLOCK_ID",
        "content"=>GetMessage("WSM_IMPORT1C_RULES_F_IBLOCK_ID"),
        "sort"=>"IBLOCK_ID",
        "default"=>false
        ),

    array(
        "id"=>"SECTION_ID",
        "content"=>GetMessage("WSM_IMPORT1C_RULES_F_SECTION_ID"),
        "sort"=>"SECTION_ID",
        "default"=>true
    ),

    array(
        "id"=>"PRICE_ID_FROM",
        "content"=>GetMessage("WSM_IMPORT1C_RULES_F_PRICE_ID_FROM"),
        "sort"=>"PRICE_ID_FROM",
        "default"=>true
    ),
    array(
        "id"=>"PRICE_ID_TO",
        "content"=>GetMessage("WSM_IMPORT1C_RULES_F_PRICE_ID_TO"),
        "sort"=>"PRICE_ID_TO",
        "default"=>true
    ),

    array(
        "id"=>"ACTIVE",
        "content"=>GetMessage("WSM_IMPORT1C_RULES_F_ACTIVE"),
        "sort"=>"ACTIVE",
        "default"=>true
        ),

	array(
		"id"=>"SECTION_ID",
		"content"=>GetMessage("WSM_IMPORT1C_RULES_F_SECTION_ID"), 
		"sort"=>"SECTION_ID",
		"default"=>true
		),

	array(
		"id"=>"SUB_SECTIONS",
		"content"=>GetMessage("WSM_IMPORT1C_RULES_F_SUB_SECTIONS"), 
		"sort"=>"SUB_SECTIONS",
		"default"=>true
		),

    array(
        "id"=>"VALUE",
        "content"=>GetMessage("WSM_IMPORT1C_RULES_F_VALUE"),
        "sort"=>"VALUE",
        "default"=> true,
        ),
    array(
        "id"=>"MARGE_TYPE",
        "content"=>GetMessage("WSM_IMPORT1C_RULES_F_CHANGE_TYPE"),
        "sort"=>"CHANGE_TYPE",
        "default"=> true,
    ),


);

$arrFields = PriceRules::getMap();
foreach($arHeaders as $i => $h)
{
    if(array_key_exists($h['id'], $arrFields))
    {
        if(!$h['content'])
            $arHeaders[$i]['content'] = $arrFields[$h['id']]['title'] ? $arrFields[$h['id']]['title'] : $h['id'];
    }
}


$lAdmin->AddHeaders($arHeaders);

while($arRes = $rsData->NavNext(true, "data_"))
{
	$row =& $lAdmin->AddRow($data_ID, $arRes);

	if($_REQUEST["mode"] != "excel")
		$row->AddViewField("DATE_CREATE", str_replace(" ", "&nbsp;", $data_DATE_CREATE));

	$row->AddCheckField("ACTIVE");
    $row->AddCheckField("SUB_SECTIONS");

    $row->AddInputField('VALUE');

    //$row->AddSelectField("ACTIVE", $arStatus);

	$row->AddViewField("IBLOCK_ID", '['.$data_IBLOCK_ID.'] '.$arIBlock[$data_IBLOCK_ID]['NAME']);
    $row->AddViewField("SECTION_ID", '['.$data_SECTION_ID.'] '.$arSections[$data_IBLOCK_ID][$data_SECTION_ID]['NAME']);

    $row->AddViewField("PRICE_ID_FROM", $arPriceType[$data_PRICE_ID_FROM]);
    $row->AddViewField("PRICE_ID_TO", $arPriceType[$data_PRICE_ID_TO]);

    $row->AddViewField("MARGE_TYPE", $arMargeType[$data_MARGE_TYPE]);

	$arActions = array();

	$arActions[] = array(
		"ICON"=>"edit",
		"DEFAULT"=>true,
		"TEXT"=>GetMessage("WSM_IMPORT1C_RULES_ACTION_EDIT"),
		"ACTION"=>$lAdmin->ActionRedirect("wsm_import1c_price_rules_edit.php?ID=".$data_ID)
	);

	if ($POST_RIGHT>="W")
	{
		$arActions[] = array(
			"ICON"=>"delete",
			"TEXT"=>GetMessage("WSM_IMPORT1C_RULES_ACTION_DEL"),
			"ACTION"=>"if(confirm('".GetMessage('WSM_IMPORT1C_RULES_ACTION_DEL_CONFIRM')."')) ".$lAdmin->ActionDoGroup($ostrov_ID, "delete")
		);
	}

	$row->AddActions($arActions);
}


$arDDMenu = array();
foreach($arIBlock as $iblock)
{
	$arDDMenu[] = array(
		"TEXT" => htmlspecialcharsbx("[".$iblock["ID"]."] ".$iblock["NAME"]),
		"ACTION" => "window.location = 'wsm_import1c_price_rules_edit.php?lang=".urlencode(LANG)."&iblock_id=".intval($iblock["ID"])."';"
	);
}


$aContext[] = array(
	"TEXT"		 =>	GetMessage("WSM_IMPORT1C_RULES_ACTION_ADD"),
	"TITLE"		 =>	GetMessage("WSM_IMPORT1C_RULES_ACTION_ADD_TITLE"),
	"ICON"		 =>	"btn_new",
    //"LINK"		 =>	"wsm_import1c_price_rules_edit.php?lang=".LANG,
	"MENU" => $arDDMenu
	);

$lAdmin->AddAdminContextMenu($aContext, false, true);

$lAdmin->AddFooter(array(
		array("title"=>GetMessage("MAIN_ADMIN_LIST_SELECTED"), "value"=>$rsData->SelectedRowsCount()),
	)
);

$arGroupActions = array(
	//'edit' => GetMessage("MAIN_ADMIN_LIST_EDIT"),
	'delete' => GetMessage("MAIN_ADMIN_LIST_DELETE"),
	);

$lAdmin->AddGroupActionTable($arGroupActions, $arParams);
$lAdmin->CheckListMode();

$APPLICATION->SetTitle(GetMessage("WSM_IMPORT1C_RULES_TITLE"));

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>

<form name="form1" method="GET" action="<?=$APPLICATION->GetCurPage()?>">
<?
$oFilter = new CAdminFilter(
	$sTableID."_filter",
	array(
		"find_ID" => GetMessage("WSM_IMPORT1C_RULES_F_ID"),
	)
);

$oFilter->Begin();
?>
<tr>
	<td nowrap><b><?echo GetMessage("WSM_IMPORT1C_RULES_F_ID")?>:</b></td>
	<td><input type="text" name="find_ID" size="47" value="<?echo htmlspecialcharsbx($find_ID)?>"></td>
</tr>


<?
$oFilter->Buttons(array("table_id"=>$sTableID, "url"=>$APPLICATION->GetCurPage()));
$oFilter->End();
?>
</form>
<?
$lAdmin->DisplayList();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>