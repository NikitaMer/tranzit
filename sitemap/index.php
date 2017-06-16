<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
?><?
$APPLICATION->IncludeComponent("bitrix:main.map", ".default", Array(
	"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"LEVEL" => "3",	// Максимальный уровень вложенности (0 - без вложенности)
		"COL_NUM" => "1",	// Количество колонок
		"SHOW_DESCRIPTION" => "Y",	// Показывать описания
	),
	false
);
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>