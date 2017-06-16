<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

GLOBAL $APPLICATION;

$output = array(
	'ID' => 0,
	'ERROR' => false,
	'MESSAGE' => '',
	'CAPTCHA_CODE' => '',
	'CAPTCHA_IMG' => '',
	);

function retJSON($out, $check_error = false)
{
	if(($out['ERROR'] && $check_error) || !$check_error)
	{
		if($out['ERROR'])
		{ 
			GLOBAL $APPLICATION;
			$out["CAPTCHA_CODE"] = htmlspecialchars($APPLICATION->CaptchaGetCode());
			$out["CAPTCHA_IMG"] = '/bitrix/tools/captcha.php?captcha_sid='.$out["CAPTCHA_CODE"];
			//$out["MESSAGE"] = '<b>Возникли ошибки</b>: <br/>'.$out["MESSAGE"];
		}
		echo json_encode($out);
		die ();
	}
}

if(!CModule::IncludeModule("iblock"))
	$output['MESSAGE'][] = 'Не подключен модуль инфоблоков!';
	
$FEEDBACK = $_REQUEST['FEEDBACK'];
$FEEDBACK = htmlspecialcharsEx($FEEDBACK);

/*
foreach($_REQUEST['CALLBACK'] as $code => $val)
{
	$val = trim($val);
	
	$_REQUEST['CALLBACK'][$code] = $val;
}
*/

$err = array();

if(strlen($FEEDBACK['NAME']) == 0)
	$err[] = 'Вы не представились';

if(strlen($FEEDBACK['PHONE']) == 0)
	$err[] = 'Не введен номер телефона';	

if(strlen($FEEDBACK['EMAIL']) != 0 && !check_email($FEEDBACK['EMAIL']))
	$err[] = 'Введен не корректный Email';

if(strlen($FEEDBACK['PHONE']) == 0)
	$err[] = 'Не введен защитный код';	
elseif (!$APPLICATION->CaptchaCheckCode($FEEDBACK["captcha_word"], $FEEDBACK["captcha_sid"]))
	$err[] = 'Неверный код с картинки';	


if(count($err) > 0)
{
	$output['ERROR'] = true;
	$output['MESSAGE'] = implode('<br/>', $err);
}
  
retJSON($output, true);


$el = new CIBlockElement;

$PROP = array(
	'PHONE' => $FEEDBACK['PHONE'],
	'EMAIL' => $FEEDBACK['EMAIL'],
	);

$arLoadProductArray = Array(
	"IBLOCK_SECTION_ID" => false,
	"IBLOCK_ID"      	=> 14,
	"PROPERTY_VALUES"	=> $PROP,
	"NAME"           	=> $FEEDBACK['NAME'],
	"PREVIEW_TEXT"   	=> $FEEDBACK['COMMENTS'],
	"ACTIVE"         	=> "Y",
	);

if($PRODUCT_ID = $el->Add($arLoadProductArray))
{
	$output['ID'] = $PRODUCT_ID;
	$output['MESSAGE'] = 'Ваше сообщение №'.$PRODUCT_ID.' принято.';
}	
else
{
  $output['ERROR'] = true;
  $output['MESSAGE'] = $el->LAST_ERROR;
}  

retJSON($output);
?>