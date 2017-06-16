<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата заказа");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
Array(),
false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>