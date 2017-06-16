<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
//количество
$arResult["AMOUNT"] = 0;
$arResult["TOTAL_PRICE"] = array();
$arResult["TOTAL_PRICE_FORMATED"] = array();

foreach ($arResult["ITEMS"] as $v)
{
	if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
	{
		$arResult["AMOUNT"] += 1; //$v["QUANTITY"];
		$arResult["TOTAL_PRICE"][$v["CURRENCY"]] += $v["PRICE"] * $v["QUANTITY"]; 
	}
}

foreach($arResult["TOTAL_PRICE"] as $currency => $price)
{
	$arResult["TOTAL_PRICE_FORMATED"][$currency] = SaleFormatCurrency($price, $currency);
}
?>