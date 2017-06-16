<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
echo ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

if ($normalCount > 0)
{
?><ul><?

	foreach ($arResult["GRID"]["ROWS"] as $k => $arItem)
	{
		if ($arItem["DELAY"] != "N" || $arItem["CAN_BUY"] != "Y")
			continue;
		?>
		<li id="<?=$arItem["ID"]?>">
		
			<?
			if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
				$url = $arItem["PREVIEW_PICTURE_SRC"];
			elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
				$url = $arItem["DETAIL_PICTURE_SRC"];
			else:
				$url = $templateFolder."/images/no_photo.png";
			endif;
			?>
			<div class="image" style="background-image: url(<?=$url?>);"></div>
			<div class="data">
				<div class="line div-table">
					<div class="div-tr">
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader)
					{
						if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE")))
							continue;

						if ($arHeader["id"] == "NAME")
						{
						?>
							<div class="name">
								<div class="title">Название товара</div>
								<p class="name">	
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
									<?=$arItem["NAME"]?>
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
								</p>
								
								<?/*
								if ($bPropsColumn)
								{
									foreach ($arItem["PROPS"] as $val)
									{
										if (is_array($arItem["SKU_DATA"]))
										{
											$bSkip = false;
											foreach ($arItem["SKU_DATA"] as $propId => $arProp)
											{
												if ($arProp["CODE"] == $val["CODE"])
												{
													$bSkip = true;
													break;
												}
											}
											if ($bSkip)
												continue;
										}

										echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
									}
								}*/
								?>
							</div>

									
						<?
						}
						elseif ($arHeader["id"] == "QUANTITY")
						{
							$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
							$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
							$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
							$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
							
							if (!isset($arItem["MEASURE_RATIO"]))
								$arItem["MEASURE_RATIO"] = 1;
							
							?>
							<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
							<div class="counter">
								<div class="title"> <?//=$arHeader["name"]; ?></div>
								<div class="counter" id="basket_quantity_control">
									<input
										type="text"
										size="3"
										id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
										name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
										size="2"
										maxlength="18"
										min="0"
										<?=$max?>
										step="<?=$ratio?>"
										style="max-width: 50px"
										value="<?=$arItem["QUANTITY"]?>"
										onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)">
									<?if (floatval($arItem["MEASURE_RATIO"]) != 0):?>		
									<a href="javascript:void(0);" class="count add" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"></a>
									<a href="javascript:void(0);" class="count rem" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"></a>
									<?endif;?>
								</div>
								<?
								#if (isset($arItem["MEASURE_TEXT"]))
								#	echo $arItem["MEASURE_TEXT"];
								?>
							</div>
						<?
						}
						elseif ($arHeader["id"] == "PRICE")
						{
							?>
							<div class="tovar-price">
								<div class="title" id="current_price_<?=$arItem["ID"]?>">Цена<?//=$arHeader["name"]; ?></div>
								<div class="price-block"><?=$arItem["PRICE_FORMATED"]?><span>руб</span></div>
								
								<div class="old_price" id="old_price_<?=$arItem["ID"]?>" style="display: none;">
									<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
										<?=$arItem["FULL_PRICE_FORMATED"]?>
									<?endif;?>
								</div>
								
								<?//=$arItem["NOTES"]?>
							</div>
						<?
						}
						elseif ($arHeader["id"] == "DISCOUNT")
						{
							/*?>
								<span><?=$arHeader["name"]; ?>:</span>
								<div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
							<?*/
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							/*?>
								<span><?=$arHeader["name"]; ?>:</span>
								<?=$arItem["WEIGHT_FORMATED"]?>
							<?*/
						}
						elseif ($arHeader["id"] == "SUM")
						{
							?>
							<div class="total-price" id="sum_<?=$arItem["ID"]?>">
								<div class="title">Сумма<?//=$arHeader["name"]; ?></div>
								<div class="price-block"><?echo $arItem[$arHeader["id"]];?><span>руб</span></div>
							</div>
							<?
						}
						else
						{

						}

					} # end foreach $arResult["GRID"]["HEADERS"]
					?>
					</div>
                </div>
				<div class="line cart-actions">
					<a href="#" class="icon icon16 compare"><span>К сравнению</span></a>
					<a href="#" class="icon icon16 favorite"><span>В закладки</span></a>
					<?if ($bDeleteColumn):?>
						<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" class="icon icon16 remove"><?=GetMessage("SALE_DELETE")?></a>
					<?endif;?>
					
					<?/*if ($bDelayColumn):
						?>
							<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?=GetMessage("SALE_DELAY")?></a>
						<?
						endif;*/
					?>
				</div>

			</div>
		</li>
		<?
	}
	?>

		<li class="totalinfo">
			<div class="data">

				<div class="line div-table">
					<div class="div-tr">
						<?/*if ($bWeightColumn):?>
							<div><?=GetMessage("SALE_TOTAL_WEIGHT")?>: <?=$arResult["allWeight_FORMATED"]?></div>
						<?endif;*/?>

						<?/*if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
							<?echo GetMessage('SALE_VAT_EXCLUDED')?>: <?=$arResult["allSum_wVAT_FORMATED"]?><br/>
							<?echo GetMessage('SALE_VAT_INCLUDED')?>: <?=$arResult["allVATSum_FORMATED"]?>
						<?endif;*/?>

						
						<div class="name">&nbsp;</div>
						<div class="tovar-price"><?=GetMessage("SALE_TOTAL")?></div>
						<div class="counter">
							<input type="text" value="2">
						</div>
						<div class="total-price">
							<div class="price-block"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?><span>руб</span></div>
							<?/*if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
								<?=$arResult["PRICE_WITHOUT_DISCOUNT"]?>
							<?endif;*/?>
						</div>
					</div>
				</div>

			</div>

		</li>
	</ul>

	<?/*
	if ($arParams["HIDE_COUPON"] != "Y"):

		$couponClass = "";
		if (array_key_exists('VALID_COUPON', $arResult))
		{
			$couponClass = ($arResult["VALID_COUPON"] === true) ? "good" : "bad";
		}
		elseif (array_key_exists('COUPON', $arResult) && !empty($arResult["COUPON"]))
		{
			$couponClass = "good";
		}
		
	?>
		<span><?=GetMessage("STB_COUPON_PROMT")?></span>
		<input type="text" id="coupon" name="COUPON" value="<?=$arResult["COUPON"]?>" onchange="enterCoupon();" size="21" class="<?=$couponClass?>">
	<?else:?>
		&nbsp;
	<?endif;*/?>

	<?/*if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
		<?=$arResult["PREPAY_BUTTON"]?>
		<span><?=GetMessage("SALE_OR")?></span>
	<?endif;*/?>

	<a href="javascript:void(0)" class="button yellow round order" onclick="checkOut();" class="checkout"><?=GetMessage("SALE_ORDER")?></a>
		
	<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
	<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="coupon_approved" value="N" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />


<?
}
else
{
	echo GetMessage("SALE_NO_ITEMS");
}
?>