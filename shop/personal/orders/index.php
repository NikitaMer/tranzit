<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Мои заказы");
$APPLICATION->SetTitle("Мои заказы");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order", 
	".default", 
	array(
		"PROP_1" => array(
		),
		"PROP_2" => "",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/shop/personal/orders/",
		"ORDERS_PER_PAGE" => "50",
		"PATH_TO_PAYMENT" => "payment.php",
		"PATH_TO_BASKET" => "/shop/cart/",
		"SET_TITLE" => "N",
		"SAVE_IN_SESSION" => "Y",
		"NAV_TEMPLATE" => "",
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"CUSTOM_SELECT_PROPS" => array(
			0 => "CML2_ARTICLE",
			1 => "",
		),
		"HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"SEF_URL_TEMPLATES" => array(
			"list" => "index.php",
			"detail" => "#ID#/",
			"cancel" => "",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>