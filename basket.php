<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');?><?

CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");

// Изменим количество товара в записи $ID корзины на 2 штуки и отложим товар
$arFields = array(
   "QUANTITY" => $_REQUEST[co],
);
CSaleBasket::Update($_REQUEST[id], $arFields);

?>