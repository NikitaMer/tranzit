<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$CSiteController = SiteController::getEntity();

$this->setFrameMode(true);

?>
<?if (isset($arResult['ITEMS']) && !empty($arResult['ITEMS'])): ?>
	<div class="title"><? echo GetMessage('SRP_HREF_TITLE') ?></div>	
	<ul class="catalog-specoffers-list">
	<?
	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$strMainID = $this->GetEditAreaId($arItem['ID'] . $key);
		
		$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
			? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
			: $arItem['NAME']
			);
			
		$picture = $arItem["DETAIL_PICTURE"]['ID'];
		
		if(!$picture)
			$picture = $arItem["PREVIEW_PICTURE"]['ID'];
		
		$image = CFile::ResizeImageGet($picture, array('width'=>138, 'height'=>138), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		?>
		<li id="<? echo $strMainID; ?>">
			<?if($image):?>
			<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="image" style="background-image: url(<?=$image['src']?>)"></a>
			<?endif;?>
			<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="catalog-name"><? echo TruncateText($arItem['NAME'], 30); ?></a>
			<div class="price-block">
				<?=$CSiteController->getHtmlFormatedPrice($arItem["MIN_PRICE"]["CURRENCY"], $arItem["MIN_PRICE"]["DISCOUNT_VALUE"]);?>
			</div>
			<form class="check-button">
				<?if ($arItem['CAN_BUY']):?>
				<input type="checkbox" name="buy" id="add_btn_<? echo $arItem['ID']; ?>">
					<label data-action="add2basket" href="<?=$arResult['ADD_URL']; ?>" class="button round" for="add_btn_<? echo $arItem['ID']; ?>"><span></span>Добавить</label>
				<?else:?>
					<a data-action="add2basket" href="javascrip:void(0);" class="button buy_now">Купить сейчас</a>
				<?endif;?>
			</form>
			
			<?/*
				if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) // Simple Product
				{
					?>
					<div class="bx_catalog_item_controls"><?
						if ($arItem['CAN_BUY'])
						{
							if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
							{
								?>
								<div class="bx_catalog_item_controls_blockone">
									<div style="display: inline-block;position: relative;">
										<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)"
											class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
										<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>"
											name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>"
											value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
										<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)"
											class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
										<span
											id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"
											class="bx_cnt_desc"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
									</div>
								</div>
							<?
							}
							?>
							<div class="bx_catalog_item_controls_blocktwo">
								<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium"
									href="javascript:void(0)" rel="nofollow"><?
									echo('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('SRP_TPL_MESS_BTN_BUY'));
									?></a>
							</div>
						<?
						}
						?>
						</div>
						<?
						
					$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
					if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
					{
					?>
						<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
							<?
							if (!empty($arItem['PRODUCT_PROPERTIES_FILL']))
							{
								foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
								{
									?>
									<input
										type="hidden"
										name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
										value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"
										>
									<?
									if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
										unset($arItem['PRODUCT_PROPERTIES'][$propID]);
								}
							}
							?>
						</div>
					<?
					}
				*/
			?>
		</li>
	<?
	} // endforeach
	?>
	</ul>
	

<? endif ?>
