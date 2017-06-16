<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

GLOBAL $APPLICATION;

function retJSON($out, $check_error = false)
{
	if((count($out['ERRORS']) && $check_error) || !$check_error)
	{
		echo json_encode($out);
		die ();
	}
}

$output = array(
	'ID' => 0,	//ID элемента
	'NAME' => '',
	'ELEMENTS' => array(),
	'IBLOCK_ID' => 0,
	'IN_COMPARE' => false, //элемент в сравнении 
	'ERRORS' => array(),
	);
	
$output["NAME"]			= trim($_REQUEST["list_name"]);
$output['ID'] 			= intval($_REQUEST['id']);
$output['IBLOCK_ID']	= intval($_REQUEST['iblock_id']);
$output['ELEMENTS'] 	= $_REQUEST['elements'];


if(strlen($output["NAME"])<=0)
	$output["NAME"] = "CATALOG_COMPARE_LIST";

if(!isset($_SESSION[$output["NAME"]]) || !is_array($_SESSION[$output["NAME"]]))
	$_SESSION[$output["NAME"]] = array();


if(!is_array($output['ELEMENTS']))
	$output['ELEMENTS'] = array();

if(!CModule::IncludeModule("iblock"))
	$out['ERRORS'][] = 'Не подключен модуль инфоблоков!';

	
if($output['IBLOCK_ID'] <= 0)
	$out['ERRORS'][] = 'Не задан ID инфоблока';
	
if($output['ID'] <= 0 && $_REQUEST['action'] != 'check')
{
	$out['ERRORS'][] = 'Не задан ID элемента';
}
elseif(count($out['ERRORS']) ==0 && $_REQUEST['action'] != 'check')
{
	$arFilter = Array(
		"IBLOCK_ID" => $output['IBLOCK_ID'], 
		"ID"		=> $output['ID']
		);
			
	$res = CIBlockElement::GetList(Array(), $arFilter, array("ID"));
	if (intval($res->SelectedRowsCount())==0)
		$output['ERRORS'][] = 'Элемент не найден';
}

retJSON($output, true);

if($_REQUEST['action'] == 'check')
{
	//chechk elements
	foreach($output['ELEMENTS'] as $index => $id)
	{
		if(!array_key_exists($id, $_SESSION[$output["NAME"]][$output["IBLOCK_ID"]]["ITEMS"]))
		{
			unset($output['ELEMENTS'][$index]);
		}
	}
}
else
{
	$output['ELEMENTS'] = array();
		
	//добавляем элемент в сравнение
	if(!array_key_exists($output['ID'], $_SESSION[$output["NAME"]][$output["IBLOCK_ID"]]["ITEMS"]))
	{
		$_SESSION[$output["NAME"]][$output["IBLOCK_ID"]]["ITEMS"][$output['ID']] = $arElement;
		$output['IN_COMPARE'] = true;
	}
	else
	{
		unset($_SESSION[$output["NAME"]][$output["IBLOCK_ID"]]["ITEMS"][$output['ID']]);
	}
}

$output['COUNT'] = count($_SESSION[$output["NAME"]][$output["IBLOCK_ID"]]["ITEMS"]);

retJSON($output);
die();
?>