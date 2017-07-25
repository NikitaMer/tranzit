<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бонусы");
?><?$APPLICATION->IncludeComponent(
	"logictim:bonus.history",
	"",
	Array(
		"FIELDS" => array("ID","DATE","NAME","OPERATION_SUM","BALLANCE_BEFORE","BALLANCE_AFTER"),
		"ORDER_LINK" => "Y",
		"ORDER_URL" => "/personal/order/",
		"PAGE_NAVIG_LIST" => "30",
		"PAGE_NAVIG_TEMP" => "arrows",
		"SORT" => "DESC"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>