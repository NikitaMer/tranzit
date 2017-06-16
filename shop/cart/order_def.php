<?
define('COLUMN_OFF', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");

?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	".default", 
	array(
		"PAY_FROM_ACCOUNT" => "N",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"ALLOW_AUTO_REGISTER" => "N",
		"SEND_NEW_USER_NOTIFY" => "N",
		"DELIVERY_NO_AJAX" => "N",
		"DELIVERY_NO_SESSION" => "Y",
		"TEMPLATE_LOCATION" => "popup",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"USE_PREPAYMENT" => "N",
		"PROP_1" => array(
		),
		"PROP_2" => array(
			0 => "21",
			1 => "22",
			2 => "23",
			3 => "24",
			4 => "25",
		),
		"PATH_TO_BASKET" => "/shop/cart/",
		"PATH_TO_PERSONAL" => "/shop/personal/",
		"PATH_TO_PAYMENT" => "payment.php",
		"PATH_TO_AUTH" => "/shop/personal/?auth",
		"SET_TITLE" => "Y",
		"DISPLAY_IMG_WIDTH" => "90",
		"DISPLAY_IMG_HEIGHT" => "90",
		"JS_AFTER_STEP_1" => "ga('send', 'event', 'cart', '1_step');",
		"JS_AFTER_STEP_2" => "ga('send', 'event', 'cart', '2_step');",
		"ALLOW_NEW_PROFILE" => "N",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"DISABLE_BASKET_REDIRECT" => "N",
		"PRODUCT_COLUMNS" => array(
			0 => "PREVIEW_PICTURE",
			1 => "PROPERTY_CML2_ARTICLE",
		),
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>