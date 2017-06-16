<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//if(!empty($arResult['ORDERS'])):?>
<div class="catalog-opt-line">
	<div class="contragent">
		<?
		if($GLOBALS['USER']->IsAuthorized() && is_object($GLOBALS['USER']))
		{
			$rsUser = CUser::GetList($by, $order,
				array(
					"ID" => $GLOBALS['USER']->GetID(),
				),
				array(
					"SELECT" => array(
						"UF_CONTRAGENT",
					),
				)
			);

			if($arUser = $rsUser->Fetch())
			{
				$rsGender = CUserFieldEnum::GetList(array(), array(
					"ID" => $arUser["UF_CONTRAGENT"],
				));
				if($arGender = $rsGender->GetNext())
					echo 'Контрагент: '.$arGender["VALUE"].' '.$arUser["ID"].' '.$arUser["NAME"];
			}
			if(in_array(9, CUser::GetUserGroup($arUser["ID"]))) {
				$is_whole_sale = true;
			} else {
				$is_whole_sale = false;
			}
		}
		?>

		<?/*Контрагент: Физ. лицо 1121212 Иванов Иван*/?>

	</div>
	<div class="sort-opt">
		<span>Сортировать по:</span>
		
		<div class="opt-group">

			<?/*$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>

			<?if($nothing || isset($_REQUEST["filter_history"])):?>
				<a class="opt" href="<?=$arResult["CURRENT_PAGE"]?>?show_all=Y"><?=GetMessage('SPOL_ORDERS_ALL')?></a>
			<?endif?>

			<?if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y'):?>
				<a class="opt" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><?=GetMessage('SPOL_CUR_ORDERS')?> 11</a>
			<?endif?>

			<?if($nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y'):?>
				<a class="opt" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><?=GetMessage('SPOL_ORDERS_HISTORY')?> 22</a>
			<?endif*/?>

			
			<a class="opt<?if($_REQUEST["filter_history"] == 'N'):?> active<?endif;?>" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N">Текущие</a>
			<a class="opt<?if($_REQUEST["filter_history"] == 'Y'):?> active<?endif;?>" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y">Завершенные</a>
			
		</div>
	</div>
</div>
<?//endif?>


<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?endif?>

	<?if(!empty($arResult['ORDERS'])):?>
		



		<?if(!$k):?>
			<?//=GetMessage("SPOL_STATUS")?><?//=$arResult["INFO"]["STATUS"][$key]["NAME"] ?>
			<?//=$arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?>
		<?endif?>

		<table class="yellow w100">
			<thead>
				<tr>
					<td>Дата</td>
					<td><?if($is_whole_sale) {echo "Cтатус заказа";} else {echo "В резерве";}?></td>
					<td>Номер</td>
					<td><?=GetMessage('SPOL_BASKET')?></td>
					<td>Сумма</td>
                    <td></td>
				</tr>
			</thead>
			<tbody>
			<?foreach($arResult["ORDERS"] as $key => $order):?>
				<tr>
					<td><?if(strlen($order["ORDER"]["DATE_INSERT_FORMATED"])):?><?=$order["ORDER"]["DATE_INSERT_FORMATED"]?><?endif?></td>
					<td><?
					if($is_whole_sale) {
						CModule::IncludeModule("sale");
						$status = CSaleStatus::GetByID($order["ORDER"]["STATUS_ID"]);
						echo $status['NAME'];
						if ($order["ORDER"]["STATUS_ID"] == "H") {
							$rsProps = CSaleOrderPropsValue::GetOrderProps($order["ORDER"]["ID"]);
							while ($arProps = $rsProps->Fetch())
							$arOrderProps[$arProps["ORDER_PROPS_ID"]] = $arProps;
							if ($arUser["UF_CONTRAGENT"] == 3) {echo " ".$arOrderProps[24]["VALUE"];} else {echo " ".$arOrderProps[25]["VALUE"];}
						}
					}					
					?></td>
					<td><a href="<?=$order["ORDER"]["URL_TO_DETAIL"]?>"><?=$order["ORDER"]["ACCOUNT_NUMBER"]?></a></td>
					<td>
						<?foreach ($order["BASKET_ITEMS"] as $item):?>

							<?/*if(strlen($item["DETAIL_PAGE_URL"])):?>
								<a href="<?=$item["DETAIL_PAGE_URL"]?>" target="_blank">
							<?endif*/?>
								<?=$item['NAME']?><br>
							<?/*if(strlen($item["DETAIL_PAGE_URL"])):?>
								</a>
							<?endif*/?>
							<?
							/*<nobr>&nbsp;&mdash; <?=$item['QUANTITY']?> <?=(isset($item["MEASURE_NAME"]) ? $item["MEASURE_NAME"] : GetMessage('SPOL_SHT'))?></nobr><br/>*/
							?>

						<?endforeach?>
					</td>
					<td>
						<?=$order["ORDER"]["FORMATED_PRICE"]?>

						<?//=GetMessage('SPOL_'.($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO'))?>

						<? // PAY SYSTEM ?>
						<?/*if(intval($order["ORDER"]["PAY_SYSTEM_ID"])):?>
							<strong><?=GetMessage('SPOL_PAYSYSTEM')?>:</strong> <?=$arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?> <br />
						<?endif*/?>

						<? // DELIVERY SYSTEM ?>
						<?/*if($order['HAS_DELIVERY']):?>

							<strong><?=GetMessage('SPOL_DELIVERY')?>:</strong>

							<?if(intval($order["ORDER"]["DELIVERY_ID"])):?>

								<?=$arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"]?> <br />

							<?elseif(strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false):?>

								<?$arId = explode(":", $order["ORDER"]["DELIVERY_ID"])?>
								<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]?> (<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"]?>) <br />

							<?endif?>

						<?endif*/?>

						<?//=$order["ORDER"]["DATE_STATUS_FORMATED"];?>

						<?//=$arResult["INFO"]["STATUS"][$key]['COLOR']?><?/*yellow*/ /*red*/ /*green*/ /*gray*/?>
						<?//=$arResult["INFO"]["STATUS"][$key]["NAME"]?>

					</td>
                    <td>
                        <?if($_REQUEST["filter_history"] == 'N' && $order["ORDER"]["CANCELED"] != "Y"):?>
							<a href="<?=$order["ORDER"]["URL_TO_CANCEL"]?>" class="cancel_order""><?=GetMessage('SPOL_CANCEL_ORDER')?></a>
                        <?elseif($_REQUEST["filter_history"] == 'Y'):?>
                            <a href="<?=$order["ORDER"]["URL_TO_COPY"]?>"><?=GetMessage('SPOL_REPEAT_ORDER')?></a>
						<?endif?>
                    </td>
				</tr>
			<?endforeach?>
			</tbody>
		</table>

		<?if(strlen($arResult['NAV_STRING'])):?>
			<?=$arResult['NAV_STRING']?>
		<?endif?>

	<?else:?>
		<?=GetMessage('SPOL_NO_ORDERS')?>
	<?endif?>

<?endif?>