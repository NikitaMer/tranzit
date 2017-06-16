<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Опросы");
?><?$APPLICATION->IncludeComponent("bitrix:voting.form", "right", Array(
	"VOTE_ID" => $_REQUEST["VOTE_ID"],	// Идентификатор опроса
		"VOTE_RESULT_TEMPLATE" => "vote_result.php?VOTE_ID=#VOTE_ID#",	// Страница для вывода диаграмм результатов опроса
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>