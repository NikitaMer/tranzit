<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$bUseDiscount = false;

CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

CBitrixComponent::includeComponentClass("bitrix:sale.basket.basket");
$basket = new CBitrixBasketComponent();
$a=$basket->getBasketItems();

$allSum=0;

foreach ($a[ITEMS][AnDelCanBuy] as $kk=>$b)
{
if ($b[AVAILABLE_QUANTITY]>0) {
$id=$a[ITEMS][AnDelCanBuy][$kk][ID];
 unset($a[ITEMS][AnDelCanBuy][$kk]);
 unset($a[GRID][ROWS][$id]);

} else 
{
$id=$a[ITEMS][AnDelCanBuy][$kk][ID];
$allSum=$allSum+$a[GRID][ROWS][$id][PRICE]*$a[GRID][ROWS][$id][QUANTITY];
}


}

// $allSum Предзаказ


$CSiteController = SiteController::getEntity();
?>

	<div class="field data">
		<label>Итого</label>
		<div class="block">

			<?//_print_r($arResult);?>


				<?//=GetMessage("SOA_TEMPL_SUM_SUMMARY")?>


			<dl class="prop w100">
				<dt>Стоимость вашего заказа</dt>
				<dd><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_PRICE"]-$allSum);?></dd>
			</dl>

<dl class="prop w100">

<?
global $skidka;
;

?>
                             <dt> <input OnChange='if ($("#PAY_CURRENT_ACCOUNT").prop("checked")===true) { var a=$("#priceon").html(); $(".summa").html(a);}  if ($("#PAY_CURRENT_ACCOUNT").prop("checked")===false) { var a=$("#priceoff").html(); $(".summa").html(a);} ' style="width:15px;" type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"> <span style="float:right;margin-top:6px;margin-left:-20px;">Использовать бонус</span></dt>
				
				<dd style='margin-top:6px;'><?=round($skidka);?> <span>руб.</span></dd>
			</dl>
			<?
			/*
			if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
			{
				?>
				<tr>
					<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DISCOUNT")?><?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?> (<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)<?endif;?>:</td>
					<td class="custom_t2" class="price"><?echo $arResult["DISCOUNT_PRICE_FORMATED"]?></td>
				</tr>
				<?
			}*/

			/*
			if(!empty($arResult["TAX_LIST"]))
			{
				foreach($arResult["TAX_LIST"] as $val)
				{
					?>
					<tr>
						<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=$val["NAME"]?> <?=$val["VALUE_FORMATED"]?>:</td>
						<td class="custom_t2" class="price"><?=$val["VALUE_MONEY_FORMATED"]?></td>
					</tr>
					<?
				}
			}
			*/

			if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
			{
				?>
				<dl class="prop w100">
					<dt><?=GetMessage("SOA_TEMPL_SUM_DELIVERY")?></dt>
					<dd><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["DELIVERY_PRICE"]);?></dd>
					<?//=$arResult["DELIVERY_PRICE_FORMATED"]?>
				</dl>
				<?
			}

			/*
			if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0)
			{
				?>
				<tr>
					<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_PAYED")?></td>
					<td class="custom_t2" class="price"><?=$arResult["PAYED_FROM_ACCOUNT_FORMATED"]?></td>
				</tr>
				<?
			}
*/

			if ($bUseDiscount):
			?>
				<dl class="prop w100">
					<dt>Итого<?//=GetMessage("SOA_TEMPL_SUM_IT")?></dt>
					<dd><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_TOTAL_PRICE"]);?></dd>
				</dl>
				<dl class="prop w100">
					<dt></dt>
					<dd><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></dd>
				</dl>
			<?
			else:
			?>
				<dl class="prop w100">
					<dt>К оплате</dt>
<div id='priceoff' style='display:none;'><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_PRICE"] + $arResult["DELIVERY_PRICE"]-$allSum);?></div>
<div id='priceon' style='display:none;'><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_PRICE"] + $arResult["DELIVERY_PRICE"]-$skidka-$allSum);?></div>
					<dd><div class='summa'><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_PRICE"] + $arResult["DELIVERY_PRICE"]-$allSum);?></div></dd>
					<?//=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?>
				</dl>
			<?
			endif;
			?>
<? if ($allSum>0) { ?>
				<dl class="prop w100">
					<dt>Предзаказ*</dt>
					<dd><div><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $allSum);?></div></dd>
</dl>

<? } ?>

		</div>
	</div>




