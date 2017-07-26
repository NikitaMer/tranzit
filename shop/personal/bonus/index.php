<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бонусы");
?><?$APPLICATION->IncludeComponent(
	"logictim:bonus.history", 
	".default", 
	array(
		"FIELDS" => array(
			0 => "ID",
			1 => "DATE",
			2 => "NAME",
			3 => "OPERATION_SUM",
			4 => "BALLANCE_BEFORE",
			5 => "BALLANCE_AFTER",
		),
		"ORDER_LINK" => "N",
		"ORDER_URL" => "/personal/order/",
		"PAGE_NAVIG_LIST" => "30",
		"PAGE_NAVIG_TEMP" => "arrows",
		"SORT" => "DESC",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>