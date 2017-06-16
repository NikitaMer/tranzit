<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$CSiteController = SiteController::getEntity();

$out = array(
	'QUANTITY' => 0,
	'PRICE' => 0,
	'TEXT' => 'товар',
	'ERRORS' => array(),
	);

if(!Bitrix\Main\Loader::includeModule('sale'))
{
	$out['ERRORS']['module'] = 'Module not installed';
	echo json_encode($out);
	die();
}

$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
	array(
		"NAME" => "ASC",
		"ID" => "ASC"
	),
	array(
		"FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => SITE_ID,
		"ORDER_ID" => "NULL"
	),
	false,
	false,
	array("ID", "CALLBACK_FUNC", "MODULE",
		"PRODUCT_ID", "QUANTITY", "DELAY",
		"CAN_BUY", "PRICE", "CURRENCY")
	);

while ($arItem = $dbBasketItems->Fetch())
{
	if($arItem['CAN_BUY'] == 'Y')
	{
		$out['ITEMS'][] = $arItem;

		$out['QUANTITY']++;
		$out['PRICE'] += $arItem['PRICE'] * $arItem['QUANTITY'];
	}

	//$out['ITEMS'][] = $arItems;
}


$c = $out['QUANTITY'] > 20 ? $out['QUANTITY'] - floor($out['QUANTITY'] / 10) * 10 : $out['QUANTITY'];

if($c == 1)
	$out['TEXT'] =  'товар';
elseif($c > 1 && $out['QUANTITY'] < 5)
	$out['TEXT'] =  'товара';
elseif($c > 5)
	$out['TEXT'] =  'товаров';

$out['TEXT'] = 'шт.';

$format_save = $CSiteController->getEnumHtml();
$CSiteController->setEnumHtml(' #');
$out['PRICE_FORMATED'] = $CSiteController->getHtmlFormatedPrice('RUB', $out['PRICE'], true);
$CSiteController->setEnumHtml($format_save);

$out['PRICE_FORMATED_2'] = $CSiteController->getHtmlFormatedPrice('RUB', $out['PRICE'], true);

//$out['PRICE'] = $CSiteController->getHtmlFormatedPrice('RUB', $out['PRICE'], false);

echo json_encode($out);
die();

?>
<?/*$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "footer", array(
		"PATH_TO_BASKET" => "/cart/",
		"PATH_TO_ORDER" => "/cart/order.php"
		),
		false
		);*/?>