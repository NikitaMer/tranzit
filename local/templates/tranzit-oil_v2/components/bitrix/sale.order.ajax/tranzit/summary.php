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
$skidka = $arResult["MAX_BONUS"];
?>

<script type="text/javascript">
    function changePrice()
    {
        var a = $(".bonuse_price").html();
        if ($("#ORDER_<?=$arResult["ORDER_PROP_PAYMENT_BONUS_ID"]?>").prop("checked")===true) {
            $("#priceoff").css("display","none");
            $("#priceon").css("display","block");
            $("#ORDER_PROP_<?=$arResult["ORDER_PROP_PAYMENT_BONUS_ID"]?>").val(a);
        } else {
            $("#priceon").css("display","none");
            $("#priceoff").css("display","block");
            $("#ORDER_PROP_<?=$arResult["ORDER_PROP_PAYMENT_BONUS_ID"]?>").val(0);
        }
    }
</script>
	<div class="field data">
		<label>Итого</label>
		<div class="block">

			<dl class="prop w100">
				<dt>Стоимость вашего заказа</dt>
				<dd><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_PRICE"]-$allSum);?></dd>
			</dl>

<dl class="prop w100">

<?

?>
                <input type="text" style="display: none" onchange="submitForm();" maxlength="250" size="0" name="ORDER_PROP_<?=$arResult["ORDER_PROP_PAYMENT_BONUS_ID"]?>" id="ORDER_PROP_<?=$arResult["ORDER_PROP_PAYMENT_BONUS_ID"]?>">
                <dt> <input OnChange='changePrice();' style="width:15px;" type="checkbox" name="ORDER_<?=$arResult["ORDER_PROP_PAYMENT_BONUS_ID"]?>" id="ORDER_<?=$arResult["ORDER_PROP_PAYMENT_BONUS_ID"]?>"> <span style="float:right;margin-top:6px;margin-left:-20px;">Использовать бонус</span></dt>

				<dd style='margin-top:6px;'><font class="bonuse_price" ><?=round($skidka);?></font> <span>руб.</span></dd>
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
                    <dd><div id='priceoff'><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_PRICE"] );?></div></dd>
                    <dd><div id='priceon' style='display:none;'><?=$CSiteController->getHtmlFormatedPrice($arResult["BASE_LANG_CURRENCY"], $arResult["ORDER_PRICE"] - $arResult["MAX_BONUS"]);?></div></dd>

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
