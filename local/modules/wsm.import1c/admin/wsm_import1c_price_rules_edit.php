<?
$module_id = 'wsm.import1c';

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

use WSM\Import1c\Price\RulesTable as PriceRules;

GLOBAL $APPLICATION;

function getSectionList($iblock_id)
{
    $arSections = array();

    $arFilter = array(
        'IBLOCK_ID' => $iblock_id,
        );

    $rs = CIBlockSection::GetList(Array("left_margin"=>"asc"), $arFilter);
    while($s = $rs->GetNext())
    {
        $arSections[$s['ID']] = array(
            'ID' => $s['ID'],
            'IBLOCK_ID' => $s['IBLOCK_ID'],
            'NAME' => '['.$s['ID'].'] '.$s['NAME'],
            'IBLOCK_SECTION_ID' => $s['IBLOCK_SECTION_ID'],
            'DEPTH_LEVEL' => $s['DEPTH_LEVEL'],
        );
    }

    return $arSections;
}




if(!\Bitrix\Main\Loader::includeModule('wsm.import1c'))
{
    die('Module wsm.import1c not installed');
}

if(!\Bitrix\Main\Loader::includeModule('iblock'))
{
    die('Module iblock not installed');
}

if(!\Bitrix\Main\Loader::includeModule('catalog'))
{
    die('Module iblock not installed');
}

IncludeModuleLangFile(__FILE__);

$POST_RIGHT = $APPLICATION->GetGroupRight($module_id);
if($POST_RIGHT=="D")
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

$iblock_id = intval($iblock_id);
$ID = intval($ID);

if($IBLOCK_ID < 1 && $iblock_id < 1 && $ID < 1)
    die('Error: iblock not set');


$arSections = array();
$arPriceType = array();

$rs = GetCatalogGroups('SORT','ASC');
while($p = $rs->GetNext())
    $arPriceType[$p['ID']] = $p['NAME'].($p['BASE'] == 'Y' ? ' [B]' : '');

if($iblock_id > 0)
    $arSections = getSectionList($iblock_id);



$aTabs[] = array(
	"DIV" => "edit1", 
	"TAB" => GetMessage("WSM_IMPORT1C_RULES_TAB_MAIN"), 
	"ICON"=>"main_user_edit", 
	"TITLE"=>GetMessage("WSM_IMPORT1C_RULES_TAB_MAIN_TITLE")
	);
	
$tabControl = new CAdminForm("tabControl", $aTabs);

$ID = intval($ID);
$res_message = null;
$bVarsFromForm = false;
	
//************************************************
// SAVE
//************************************************

if(
    'POST' == $_SERVER['REQUEST_METHOD']
    && strlen($Update) > 0
    && (!$error)
    && empty($dontsave)
)
{

    if(!(check_bitrix_sessid()))
    {
        $strWarning .= GetMessage("IBLOCK_WRONG_SESSION")."<br>";
        $bVarsFromForm = true;
    }

	$arFields = Array(
        'ACTIVE' => $ACTIVE == 'Y' ? 'Y' : 'N',
        'IBLOCK_ID' =>  intval($IBLOCK_ID),
        'SECTION_ID' => intval($SECTION_ID),
        'SUB_SECTIONS' => $SUB_SECTIONS == 'Y' ? 'Y' : 'N',
        'PRICE_ID_FROM' => intval($PRICE_ID_FROM),
        'PRICE_ID_TO' => intval($PRICE_ID_TO),
        'MARGE_TYPE' => $MARGE_TYPE == 'P' ? PriceRules::MARGIN_PERSENT : PriceRules::MARGIN_ABSOLUTE,
        'VALUE' => (double)$VALUE,
		);


    if($ID > 0)
        $result = PriceRules::update($ID, $arFields);
    else
        $result = PriceRules::add($arFields);

    if($result->isSuccess())
    {
        if($ID == 0)
            $ID = $result->getId();

        if($save && empty($errors))
            LocalRedirect(BX_ROOT."/admin/wsm_import1c_price_rules.php?iblock_id=".intval($IBLOCK_ID)."&lang=".LANGUAGE_ID);
        elseif(empty($errors))
            LocalRedirect(BX_ROOT."/admin/wsm_import1c_price_rules_edit.php?iblock_id=".intval($IBLOCK_ID)."&lang=".LANGUAGE_ID."&mess=ok&ID=".$ID."&".$tabControl->ActiveTabParam());
    }
    else
    {
        $errors = $result->getErrorMessages();
        $bVarsFromForm = true;
    }

}

if(!empty($dontsave) && check_bitrix_sessid())
    LocalRedirect("/bitrix/admin/wsm_import1c_price_rules.php?iblock_id=".$iblock_id."&lang=".LANG);

#default for new program
$data_ACTIVE = 'Y';
$data_MARGE_TYPE = 'P';

if($ID>0)
{
    #проверяем существование программы
    $rsData = PriceRules::getById($ID);
    if($ar = $rsData->fetch())
    {
        foreach($ar as $i => $r)
            ${'data_'.$i} = $r;

        if($data_IBLOCK_ID > 0)
            $arSections = getSectionList($data_IBLOCK_ID);
		
		$iblock_id = $data_IBLOCK_ID;
    }
    else
	{
		$ID=0;
	}
}


#d случае ошибки выводим данные с формы
if($bVarsFromForm)
	$DB->InitTableVarsForEdit(PriceRules::getTableName(), "data_");

$APPLICATION->SetTitle(($ID>0? GetMessage("WSM_IMPORT1C_RULES_TITLE").' #'.$ID : GetMessage("WSM_IMPORT1C_RULES_TITLE_ADD")));
require_once ($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/prolog_admin_after.php");


$aMenu = array(
	array(
		"TEXT"=>GetMessage("WSM_IMPORT1C_RULES_LIST"),
		"TITLE"=>GetMessage("WSM_IMPORT1C_RULES_LIST_TITLE"),
		"LINK"=>"wsm_import1c_price_rules.php?lang=".LANG,
		"ICON"=>"btn_list",
	)
);


if($ID > 0)
{
	$aMenu[] = array("SEPARATOR"=>"Y");

	$urlDelete  = '/bitrix/admin/wsm_import1c_price_rules.php?action=delete&'.bitrix_sessid_get().'&ID='.$ID;
	
	$aMenu[] = array(
		"TEXT"=>GetMessage("WSM_IMPORT1C_RULES_MENU_DEL"),
		"LINK"=>"javascript:if(confirm('".GetMessage("WSM_IMPORT1C_RULES_MENU_DEL_CONF")."'))window.location='".CUtil::JSEscape($urlDelete)."';",
		"ICON"=>"btn_delete",
		);
}

$context = new CAdminContextMenu($aMenu);
$context->Show();

#вывод сообщения об успешном сохранении
if($_REQUEST["mess"] == "ok" && $ID>0)
    CAdminMessage::ShowMessage(array("MESSAGE"=>GetMessage("WSM_IMPORT1C_RULES_SAVE_OK"), "TYPE"=>"OK"));

#вывод сообщения об ошибке
if($message)
    echo $message->Show();
elseif($errors)
    CAdminMessage::ShowMessage(implode(', ',$errors));

if($error)
    CAdminMessage::ShowOldStyleError($error->GetErrorText());

#===============================================================================
# формирования формы
#===============================================================================
$tabControl->BeginPrologContent();
echo CAdminCalendar::ShowScript();
$tabControl->EndPrologContent();

$tabControl->BeginEpilogContent();

echo bitrix_sessid_post();
echo GetFilterHiddens("find_");
?>
<input type="hidden" name="lang" value="<?=LANG?>"/>
    <input type="hidden" name="Update" value="Y">
    <input type="hidden" name="IBLOCK_ID" value="<?=$iblock_id?>">
    <input type="hidden" name="return_url" value="<?=htmlspecialcharsbx($return_url)?>">

    <?if($ID>0 && !$bCopy):?>
    <input type="hidden" name="ID" value="<?=$ID?>">
<?endif;?>

    <?if ($bCopy):?>
    <input type="hidden" name="copyID" value="<?=intval($ID); ?>">
<?endif;?>

<?
$tabControl->EndEpilogContent();

$tabControl->Begin(array(
	"FORM_ACTION" => $APPLICATION->GetCurPage()."?ID=".IntVal($ID)."&lang=".LANG,
	"FORM_ATTRIBUTES" => '',
	));
	
$tabControl->BeginNextFormTab();

	if($ID > 0)
	{
        $tabControl->BeginCustomField("ID", GetMessage('WSM_IMPORT1C_RULES_F_ID'), false);?>
        <tr><td><?=$tabControl->GetCustomLabelHTML()?></td><td><?=$date_ID;?></td></tr>
        <?$tabControl->EndCustomField("ID");

        $tabControl->BeginCustomField("DATE_CREATE", GetMessage('WSM_IMPORT1C_RULES_F_DATE_CREATE'), false);?>
        <tr><td><?=$tabControl->GetCustomLabelHTML()?></td><td><?=$date_DATE_CREATE?></td></tr>
        <?$tabControl->EndCustomField("DATE_CREATE");

        $tabControl->BeginCustomField("DATE_CHANGE", GetMessage('WSM_IMPORT1C_RULES_F_DATE_CREATE'), false);?>
        <tr><td><?=$tabControl->GetCustomLabelHTML()?></td><td><?=$date_DATE_CREATE?></td></tr>
        <?$tabControl->EndCustomField("DATE_CHANGE");
	}
	
	$tabControl->AddCheckBoxField("ACTIVE", GetMessage('WSM_IMPORT1C_RULES_F_ACTIVE').':' , false, "Y", ($data_ACTIVE == "Y") );

    $tabControl->BeginCustomField("SECTION_ID", GetMessage("WSM_IMPORT1C_RULES_F_SECTION_ID"));

    ?>
        <tr id="tr_SECTION_ID">
            <td style="width:40%;"><?=GetMessage("WSM_IMPORT1C_RULES_F_SECTION_ID")?>:</td>
            <td style="width:60%;">
                <select name="SECTION_ID">
                <?foreach($arSections as $sid => $section):?>
                    <option value="<?=$sid?>" <?if($sid == $data_SECTION_ID) echo 'selected';?>><?=str_repeat(' . ', ($section['DEPTH_LEVEL']-1))?> <?=$section['NAME']?></option>
                <?endforeach;?>
                </select>
            </td>
        </tr>
    <?
    $tabControl->EndCustomField("SECTION_ID", '');


    $tabControl->AddCheckBoxField("SUB_SECTIONS", GetMessage('WSM_IMPORT1C_RULES_F_SUB_SECTIONS').':' , false, "Y", ($data_SUB_SECTIONS == "Y") );
    $tabControl->AddDropDownField("PRICE_ID_FROM",GetMessage("WSM_IMPORT1C_RULES_F_PRICE_ID_FROM").":",true, $arPriceType, $data_PRICE_ID_FROM);
    $tabControl->AddDropDownField("PRICE_ID_TO",GetMessage("WSM_IMPORT1C_RULES_F_PRICE_ID_TO").":",true, $arPriceType, $data_PRICE_ID_TO);

    //$tabControl->AddSection("PTERM", GetMessage('ORGM_CALCULATOR_PROG_'));
    $tabControl->AddEditField("VALUE",GetMessage("WSM_IMPORT1C_RULES_F_VALUE").":",true,array("size" => 10, "maxlength" => 10),$data_VALUE);
    $tabControl->AddDropDownField("MARGE_TYPE",GetMessage("WSM_IMPORT1C_RULES_F_MARGE_TYPE").":",true, PriceRules::getMargeType(), $data_MARGE_TYPE);

    #вывод кнопок START
    ob_start();
    ?>
        <input <?if ($bDisabled) echo "disabled";?> type="submit" class="adm-btn-save" name="save" id="save" value="<?echo GetMessage("WSM_IMPORT1C_RULES_BTN_SAVE")?>">
        <input <?if ($bDisabled) echo "disabled";?> type="submit" class="button" name="apply" id="apply" value="<?echo GetMessage('WSM_IMPORT1C_RULES_BTN_APPLY')?>">
        <input <?if ($bDisabled) echo "disabled";?> type="submit" class="button" name="dontsave" id="dontsave" value="<?echo GetMessage("WSM_IMPORT1C_RULES_BTN_CANCEL")?>">
    <?
    $buttons_add_html = ob_get_contents();
    ob_end_clean();

    $tabControl->Buttons(false, $buttons_add_html);
    #вывод кнопок END

$tabControl->Show();?>

<?//=BeginNote();?>

<?//=EndNote();?>

<?
$tabControl->End();
$tabControl->ShowWarnings("post_form", $message);

//$a = Wsm\Import1c\Price::getSectionTree(CATALOG_IBLOCK_ID);
//_print_r($a);

//var_dump(Wsm\Import1c\Price::inSection(CATALOG_IBLOCK_ID, 275, 269));
_print_r(Wsm\Import1c\Price::getSectionPriceRule(CATALOG_IBLOCK_ID, 275));

// 269

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>