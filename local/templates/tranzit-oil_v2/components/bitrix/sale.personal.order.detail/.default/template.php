<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(strlen($arResult["ERROR_MESSAGE"])):?>

	<?=ShowError($arResult["ERROR_MESSAGE"]);?>

<?else:?>

	<div class="order-info">
		<?=GetMessage('SPOD_ORDER')?> <?=GetMessage('SPOD_NUM_SIGN')?> <b><?=$arResult["ACCOUNT_NUMBER"]?> 
		<?if(strlen($arResult["DATE_INSERT_FORMATED"])):?>
			<?=GetMessage("SPOD_FROM")?> <?=$arResult["DATE_INSERT_FORMATED"]?>
		<?endif?></b>
	</div>
	
	
	<table class="yellow w100">
		<thead>
			<tr>
				<td>Артикул</td>
				<td><?=GetMessage('SPOD_NAME')?></td>
				<td>Статус</td>
				<td><?=GetMessage('SPOD_PRICE')?></td>
				<td><?=GetMessage('SPOD_QUANTITY')?></td>
				<td>Стоимость</td>
				<td>Бонус</td>
				
				<?/*if($arResult['HAS_PROPS']):?>
					<td class="custom amount"><?=GetMessage('SPOD_PROPS')?></td>
				<?endif*/?>
				
				<?/*if($arResult['HAS_DISCOUNT']):?>
					<td class="custom price"><?=GetMessage('SPOD_DISCOUNT')?></td>
				<?endif*/?>
			</tr>
		</thead>
		<tbody>
			<?foreach($arResult["BASKET"] as $prod):?>
				<tr>
					<td></td>
					<?$hasLink = !empty($prod["DETAIL_PAGE_URL"]);?>
					<td>
						<?/*if($prod['PICTURE']['SRC']):?>
							<img src="<?=$prod['PICTURE']['SRC']?>" width="<?=$prod['PICTURE']['WIDTH']?>" height="<?=$prod['PICTURE']['HEIGHT']?>" alt="<?=$prod['NAME']?>" />
						<?endif*/?>
						
						<?if($hasLink):?>
							<a href="<?=$prod["DETAIL_PAGE_URL"]?>" target="_blank">
						<?endif?>

							<?=htmlspecialcharsEx($prod["NAME"])?>

						<?if($hasLink):?>
							</a>
						<?endif?>
					</td>		
					<td><? // СТАТУС ?></td>
					<td><?=$prod["PRICE_FORMATED"]?></td>
					<td>
						<?=$prod["QUANTITY"]?>
						<?if(strlen($prod['MEASURE_TEXT'])):?>
							<?=$prod['MEASURE_TEXT']?>
						<?else:?>
							<?=GetMessage('SPOD_DEFAULT_MEASURE')?>
						<?endif?>
					</td>
					<td>
						<?=($prod["QUANTITY"] * $prod["PRICE"]);?>
					</td>
					<td>
						<?//бонус?>
					</td>

					<?if($arResult['HAS_PROPS']):?>
						<?
						$actuallyHasProps = is_array($prod["PROPS"]) && !empty($prod["PROPS"]);
						?>
						<td class="custom"> <?if($actuallyHasProps):?><span class="fm"><?=GetMessage('SPOD_PROPS')?>:</span><?endif?>

							<table cellspacing="0" class="bx_ol_sku_prop">
								<?if($actuallyHasProps):?>
									<?foreach($prod["PROPS"] as $prop):?>

										<?if(!empty($prop['SKU_VALUE']) && $prop['SKU_TYPE'] == 'image'):?>

											<tr>
												<td colspan="2">
													<nobr><?=$prop["NAME"]?>:</nobr><br />
													<img src="<?=$prop['SKU_VALUE']['PICT']['SRC']?>" width="<?=$prop['SKU_VALUE']['PICT']['WIDTH']?>" height="<?=$prop['SKU_VALUE']['PICT']['HEIGHT']?>" title="<?=$prop['SKU_VALUE']['NAME']?>" alt="<?=$prop['SKU_VALUE']['NAME']?>" />
												</td>
											</tr>

										<?else:?>

											<tr>
												<td><nobr><?=$prop["NAME"]?>:</nobr></td>
												<td style="padding-left: 10px !important"><b><?=$prop["VALUE"]?></b></td>
											</tr>

										<?endif?>

									<?endforeach?>
								<?endif?>

							</table>

						</td>
					<?endif/**/?>

					<?/*if($arResult['HAS_DISCOUNT']):?>
						<td class="custom price"> <span class="fm"><?=GetMessage('SPOD_DISCOUNT')?>:</span> <?=$prod["DISCOUNT_PRICE_PERCENT_FORMATED"]?></td>
					<?endif*/?>

					<?/*
					<td><?//=GetMessage('SPOD_PRICETYPE')?>: <?=htmlspecialcharsEx($prod["NOTES"])?></td>
					*/?> 
				</tr>
			<?endforeach?>

			<? ///// WEIGHT ?>
			<?/*if(floatval($arResult["ORDER_WEIGHT"])):?>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?=GetMessage('SPOD_TOTAL_WEIGHT')?>:</td>
					<td><?=$arResult['ORDER_WEIGHT_FORMATED']?></td>
				</tr>
			<?endif*/?>

			<? ///// PRICE SUM ?>
			<?//=GetMessage('SPOD_PRODUCT_SUM')?>
            <?//=$arResult['PRODUCT_SUM_FORMATTED']?>

			<? ///// DELIVERY PRICE: print even equals 2 zero ?>
			<?/*if(strlen($arResult["PRICE_DELIVERY_FORMATED"])):?>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="custom_t1"><?=GetMessage('SPOD_DELIVERY')?>:</td>
					<td colspan="2"><?=$arResult["PRICE_DELIVERY_FORMATED"]?></td>
				</tr>
			<?endif*/?>

			<? ///// TAXES DETAIL ?>
			<?/*foreach($arResult["TAX_LIST"] as $tax):?>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?=$tax["TAX_NAME"]?>:</td>
					<td colspan="2"><?=$tax["VALUE_MONEY_FORMATED"]?></td>
				</tr>	
			<?endforeach*/?>

			<? ///// TAX SUM ?>
			<?/*if(floatval($arResult["TAX_VALUE"])):?>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?=GetMessage('SPOD_TAX')?>:</td>
					<td colspan="2"><?=$arResult["TAX_VALUE_FORMATED"]?></td>
				</tr>
			<?endif*/?>

			<? ///// DISCOUNT ?>
			<?/*if(floatval($arResult["DISCOUNT_VALUE"])):?>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?=GetMessage('SPOD_DISCOUNT')?>:</td>
					<td colspan="2"><?=$arResult["DISCOUNT_VALUE_FORMATED"]?></td>
				</tr>
			<?endif*/?>

			<tr class="total">
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?=GetMessage('SPOD_SUMMARY')?>:</td>
				<td colspan="2"><?=$arResult["PRICE_FORMATED"]?></td>
			</tr>



<?
if ($arResult[SUM_PAID]>0) { 

$price2=$arResult[PRICE]-$arResult[SUM_PAID];

?>

<tr class="total">
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><b>С учетом бонусов</b>:</td>
				<td colspan="2"><?=$price2;?> руб.</td>
			</tr>
<? } ?>
			
		</tbody>
	</table>
	
	
	<?//=GetMessage('SPOD_ORDER_STATUS')?>
	<?//=$arResult["STATUS"]["NAME"]?>
	<?/*if(strlen($arResult["DATE_STATUS_FORMATED"])):?>
		(<?=GetMessage("SPOD_FROM")?> <?=$arResult["DATE_STATUS_FORMATED"]?>)
	<?endif*/?>
			
	<?//=GetMessage('SPOD_ORDER_PRICE')?>
		
	<?//=$arResult["PRICE_FORMATED"]?>
	<?/*if(floatval($arResult["SUM_PAID"])):?>
		(<?=GetMessage('SPOD_ALREADY_PAID')?>:&nbsp;<?=$arResult["SUM_PAID_FORMATED"]?>)
	<?endif*/?>


	<?/*if($arResult["CANCELED"] == "Y" || $arResult["CAN_CANCEL"] == "Y"):?>
		
		<?=GetMessage('SPOD_ORDER_CANCELED')?>
		
			<?if($arResult["CANCELED"] == "Y"):?>
				<?=GetMessage('SPOD_YES')?>
				<?if(strlen($arResult["DATE_CANCELED_FORMATED"])):?>
					(<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_CANCELED_FORMATED"]?>)
				<?endif?>
			<?elseif($arResult["CAN_CANCEL"] == "Y"):?>
				<?=GetMessage('SPOD_NO')?>&nbsp;&nbsp;&nbsp;[<a href="<?=$arResult["URL_TO_CANCEL"]?>"><?=GetMessage("SPOD_ORDER_CANCEL")?></a>]
			<?endif?>
		
	<?endif*/?>

	<?if(intval($arResult["USER_ID"])):?>
		<?//=GetMessage('SPOD_ACCOUNT_DATA')?>
		<?/*if(strlen($arResult["USER_NAME"])):?>
			<?=GetMessage('SPOD_ACCOUNT')?>:<?=$arResult["USER_NAME"]?>
		<?endif*/?>
		<?//=GetMessage('SPOD_LOGIN')?> <?//=$arResult["USER"]["LOGIN"]?>
		<?//=GetMessage('SPOD_EMAIL')?> <?//=$arResult["USER"]["EMAIL"]?>
	<?endif?>

	<?//=GetMessage('SPOD_ORDER_PROPERTIES')?>
	<?//=GetMessage('SPOD_ORDER_PERS_TYPE')?><?//=$arResult["PERSON_TYPE"]["NAME"]?>
	
			
	<?//=GetMessage('SPOD_ORDER_COMPLETE_SET')?>
			

	<?/*foreach($arResult["ORDER_PROPS"] as $prop):?>

		<?if($prop["SHOW_GROUP_NAME"] == "Y"):?>
			<?=$prop["GROUP_NAME"]?>
		<?endif?>
		
		<?=$prop['NAME']?>

		<?if($prop["TYPE"] == "CHECKBOX"):?>
			<?=GetMessage('SPOD_'.($prop["VALUE"] == "Y" ? 'YES' : 'NO'))?>
		<?else:?>
			<?=$prop["VALUE"]?>
		<?endif?>

	<?endforeach*/?>

	<?/*if(!empty($arResult["USER_DESCRIPTION"])):?>
		<?=GetMessage('SPOD_ORDER_USER_COMMENT')?>: <?=$arResult["USER_DESCRIPTION"]?>
	<?endif*/?>
		
	<?//=GetMessage("SPOD_ORDER_PAYMENT")?>
	<?//=GetMessage('SPOD_PAY_SYSTEM')?>
	

	<?/*if(intval($arResult["PAY_SYSTEM_ID"])):?>
		<?=$arResult["PAY_SYSTEM"]["NAME"]?>
	<?else:?>
		<?=GetMessage("SPOD_NONE")?>
	<?endif*/?>
			
			

	<?//=GetMessage('SPOD_ORDER_PAYED')?>
	
	<?/*if($arResult["PAYED"] == "Y"):?>
		<?=GetMessage('SPOD_YES')?>
		<?if(strlen($arResult["DATE_PAYED_FORMATED"])):?>
			(<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_PAYED_FORMATED"]?>)
		<?endif?>
	<?else:?>
		<?=GetMessage('SPOD_NO')?>
		<?if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
			&nbsp;&nbsp;&nbsp;[<a href="<?=$arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank"><?=GetMessage("SPOD_REPEAT_PAY")?></a>]
		<?endif?>
	<?endif*/?>


	<?//=GetMessage("SPOD_ORDER_DELIVERY")?>
				
	<?/*if(strpos($arResult["DELIVERY_ID"], ":") !== false || intval($arResult["DELIVERY_ID"])):?>
		<?=$arResult["DELIVERY"]["NAME"]?>

		<?if(intval($arResult['STORE_ID']) && !empty($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']])):?>

			<?$store = $arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']];?>
			<div class="bx_ol_store">
				<div class="bx_old_s_row_title">
					<?=GetMessage('SPOD_TAKE_FROM_STORE')?>: <b><?=$store['TITLE']?></b>

					<?if(!empty($store['DESCRIPTION'])):?>
						<div class="bx_ild_s_desc">
							<?=$store['DESCRIPTION']?>
						</div>
					<?endif?>

				</div>
				
				<?if(!empty($store['ADDRESS'])):?>
					<div class="bx_old_s_row">
						<b><?=GetMessage('SPOD_STORE_ADDRESS')?></b>: <?=$store['ADDRESS']?>
					</div>
				<?endif?>

				<?if(!empty($store['SCHEDULE'])):?>
					<div class="bx_old_s_row">
						<b><?=GetMessage('SPOD_STORE_WORKTIME')?></b>: <?=$store['SCHEDULE']?>
					</div>
				<?endif?>

				<?if(!empty($store['PHONE'])):?>
					<div class="bx_old_s_row">
						<b><?=GetMessage('SPOD_STORE_PHONE')?></b>: <?=$store['PHONE']?>
					</div>
				<?endif?>

				<?if(!empty($store['EMAIL'])):?>
					<div class="bx_old_s_row">
						<b><?=GetMessage('SPOD_STORE_EMAIL')?></b>: <a href="mailto:<?=$store['EMAIL']?>"><?=$store['EMAIL']?></a>
					</div>
				<?endif?>

				<?if(($store['GPS_N'] = floatval($store['GPS_N'])) && ($store['GPS_S'] = floatval($store['GPS_S']))):?>
					
					<div id="bx_old_s_map">

						<div class="bx_map_buttons">
							<a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" id="map-show">
								<?=GetMessage('SPOD_SHOW_MAP')?>
							</a>

							<a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" id="map-hide">
								<?=GetMessage('SPOD_HIDE_MAP')?>
							</a>
						</div>

						<?ob_start();?>
							<div><?$mg = $arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'];?>
								<?if(!empty($mg['SRC'])):?><img src="<?=$mg['SRC']?>" width="<?=$mg['WIDTH']?>" height="<?=$mg['HEIGHT']?>"><br /><br /><?endif?>
								<?=$store['TITLE']?></div>
						<?$ballon = ob_get_contents();?>
						<?ob_end_clean();?>

						<?
							$mapId = '__store_map';

							$mapParams = array(
							'yandex_lat' => $store['GPS_N'],
							'yandex_lon' => $store['GPS_S'],
							'yandex_scale' => 16,
							'PLACEMARKS' => array(
								array(
									'LON' => $store['GPS_S'],
									'LAT' => $store['GPS_N'],
									'TEXT' => $ballon
								)
							));
						?>

						<div id="map-container">

							<?$APPLICATION->IncludeComponent("bitrix:map.yandex.view", ".default", array(
								"INIT_MAP_TYPE" => "MAP",
								"MAP_DATA" => serialize($mapParams),
								"MAP_WIDTH" => "100%",
								"MAP_HEIGHT" => "200",
								"CONTROLS" => array(
									0 => "SMALLZOOM",
								),
								"OPTIONS" => array(
									0 => "ENABLE_SCROLL_ZOOM",
									1 => "ENABLE_DBLCLICK_ZOOM",
									2 => "ENABLE_DRAGGING",
								),
								"MAP_ID" => $mapId
								),
								false
							);?>

						</div>

						<?CJSCore::Init();?>
						<script>
							new CStoreMap({mapId:"<?=$mapId?>", area: '.bx_old_s_map'});
						</script>

					</div>

				<?endif?>

			</div>

		<?endif?>

	<?else:?>
		<?=GetMessage("SPOD_NONE")?>
	<?endif*/?>
				
	<?/*if($arResult["TRACKING_NUMBER"]):?>
		<?=GetMessage('SPOD_ORDER_TRACKING_NUMBER')?>
		<?=$arResult["TRACKING_NUMBER"]?>
	<?endif*/?>

	<?/*if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] != "Y"):?>
		<?
			$ORDER_ID = $ID;
			include($arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]);
		?>
	<?endif*/?>


	<a href="<?=$arResult["URL_TO_LIST"]?>"><?=GetMessage('SPOD_CUR_ORDERS')?></a>
	
<?endif?>
