<?
define('COLUMN_OFF', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"main_cart", 
	array(
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DELETE",
			2 => "PRICE",
			3 => "QUANTITY",
			4 => "SUM",
			5 => "PROPERTY_CML2_ARTICLE",
		),
		"PATH_TO_ORDER" => "/shop/cart/order.php",
		"HIDE_COUPON" => "Y",
		"QUANTITY_FLOAT" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_PREPAYMENT" => "N",
		"SET_TITLE" => "N",
		"ACTION_VARIABLE" => "action",
		"PRICE_CODE" => array(
			0 => "Интернет Магазин",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>