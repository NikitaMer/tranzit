<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

#echo '<pre>'.print_r($arResult, true).'</pre>';

$this->setFrameMode(true);

$CSiteController = SiteController::getEntity();


$strMainID = $this->GetEditAreaId($arResult['ID']);

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
	);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);

?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/include/status_bayers.php'; ?>

<? if ($status_bayer != 'Юридическое лицо') { ?>

<? if ('Y' == $arParams['DISPLAY_NAME']) { ?>
    <h1>
	<? echo (
		isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ''
		? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
		: $arResult["NAME"]
	); ?>
	</h1>
<? } ?>
<div class="columns catalog-element" id="<? echo $arItemIDs['ID']; ?>">
	<div class="col main_left">
	
		<?
		reset($arResult['MORE_PHOTO']);
		$arFirstPhoto = current($arResult['MORE_PHOTO']);
		unset($arResult['MORE_PHOTO'][0]);
		?>


		<?if($arFirstPhoto['thumb_b']):?>
		<a class="main-image fancyapp" rel="galery" href="<?=$arFirstPhoto['thumb_b']['src']?>" style="background-image: url(<?=$arFirstPhoto['thumb_s']['src']?>);"></a>
		<?endif;?>

		<?if(count($arResult['MORE_PHOTO']) > 0):?>
		<div class="galery">
			<?foreach($arResult['MORE_PHOTO'] as $img):?>
			<a class="fancyapp" rel="galery" href="<?=$img['thumb_b']['src']?>" target="_blank" style="background-image: url(<?=$img['thumb_s']['src']?>);"></a>
			<?endforeach;?>
		</div>
		<?endif;?>

	</div>
	<div class="col main_right">
		<div class="columns">
		
                <div class="col main_left">
				<?
				if ('' != $arResult['PREVIEW_TEXT'] && '' == $arResult['DETAIL_TEXT'])
				{
					echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>');
				}
				elseif ('' != $arResult['DETAIL_TEXT'])
				{
					echo ('html' == $arResult['DETAIL_TEXT_TYPE'] ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>');
				}
				?>
                    <br>
                    <?if(count($arResult['PRODUCT_OFFER'])):?>


<?
$path=explode('?',$_SERVER[REQUEST_URI]);
$path=explode('/',$path[0]);
$c=count($path)-1;

$ht='';
for ($i=2; $i<$c; $i++)
{

$arFilter = Array('IBLOCK_ID'=>$arParams[IBLOCK_ID], 'CODE'=>$path[$i]);
  $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true,array('UF_*'));
  while($ar_result = $db_list->GetNext())
  {
if ($ar_result[UF_TITLEP]!='') $ht=$ar_result[UF_TITLEP];
  }

}

if ($ht=='')  $ht='Выберите тип товара';

if ($ht!='') echo "<h2 style='font-size:16px;'>$ht</h2>";

?>




                        <ul class="product_variant">
                        <select onchange="document.location=this.options[this.selectedIndex].value">
                        <option value='#'>Выберите...</option>
                        <?foreach($arResult['PRODUCT_OFFER'] as $aProductOffer):?>
                            <option value="<?=$aProductOffer['DETAIL_PAGE_URL']; ?>"><?=$aProductOffer['NAME']?></option>
                        <?endforeach;?>
                         </select>
                        </ul>
                    <?endif;?>
                </div>
				
                <div class="col main_right">

                    <?if($arResult['MIN_PRICE']):?>
                    <div class="price-block main">
						<!-- <? #print_r($arResult['MIN_PRICE']);?> -->
						<?=$CSiteController->getHtmlFormatedPrice($arResult["MIN_PRICE"]["CURRENCY"], $arResult["MIN_PRICE"]["DISCOUNT_VALUE"]);?>
					</div>
                    <?endif;?>

					<?if($arResult['BONUS_AMOUNT']):?>
					<div class="your_bonus">Ваш бонус:<span><?=floor($arResult['BONUS_AMOUNT']);?> руб</span></div>
					<?endif;?>

                    <?
                    //$arResult['CATALOG_QUANTITY'] = 8;
                    ?>
					
					<div class="availability">Наличие:
						<?if($arResult['CATALOG_QUANTITY'] >= 10):?>
							<span>В наличии</span>
                        <?elseif($arResult['CATALOG_QUANTITY'] > 0 && $arResult['CATALOG_QUANTITY'] < 10):?>
                            <span class="red">Меньше 10</span>
						<?else:?>
							<span class="no">Нет в наличии</span>
						<?endif;?>
                    </div>

                    <div class="catalog-action">
						<?if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])):?>
							<?if ($arParams['DISPLAY_COMPARE']):?>
							<a class="link icon icon16 compare" data-action="add2compare" data-id="<?=$arResult['ID']?>" href="<?=$arParams['COMPARE_PATH']?>"><span>К сравнению</span></a>
							<br>
							<?endif;?>
                        	<a class="link icon icon16 favorite add2favorite" data-action="add2favorite" data-id="<?=$arResult['ID']?>" href="#"><span>В закладки</span></a>
						<?endif;?>
                    </div>

					<?if($arResult['CAN_BUY']):?>
					<?//=$arResult['BUY_URL']?> <?//=$arResult['ADD_URL']?>

<? if ($arResult['CATALOG_QUANTITY']>0) { ?>
						<a  style="background:#99CC33;border: 1px solid #99CC33;" data-action="add2basket" href="<?=$arResult['ADD_URL']; ?>" class="button buy_now yellow">Купить сейчас</a>
<? } else { ?>

				<a  data-action="add2basket" href="<?=$arResult['ADD_URL']; ?>" class="button buy_now yellow">Сделать предзаказ</a>

<? } ?>

					<?else:?>
						<a data-action="add2basket" href="javascrip:void(0);" class="button buy_now white">Купить сейчас</a>
					<?endif;?>

					<?
					if(count($arResult['SIMILAR_ID']) > 0) //SIMILAR_PRODUCTS
					{
						global $arSimilarFilter;
						$arSimilarFilter = array(
							'ID' => $arResult['SIMILAR_ID']
							);

                        #_print_r($arSimilarFilter);


						?>

						<?$APPLICATION->IncludeComponent(
							"bitrix:catalog.section",
							"similar",
							array(
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
								"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
								"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
								"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
								"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
								"INCLUDE_SUBSECTIONS" => 'Y' ,// 'Y' $arParams["INCLUDE_SUBSECTIONS"],
								"SHOW_ALL_WO_SECTION" => 'Y',
								"BASKET_URL" => $arParams["BASKET_URL"],
								"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
								//"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
								//"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
								//"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
								//"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],

								"FILTER_NAME" => 'arSimilarFilter',

								"CACHE_TYPE" => 'A',
								"CACHE_TIME" => 0,
								"CACHE_FILTER" => 0,
								"CACHE_GROUPS" => 'N',

								"SET_TITLE" => 'N',
								"SET_STATUS_404" => 'N',
								"DISPLAY_COMPARE" => 'N',
								"PAGE_ELEMENT_COUNT" => 10,
								"LINE_ELEMENT_COUNT" => 10,

								"PRICE_CODE" => $arParams["PRICE_CODE"],
								"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
								"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

								"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
								"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
								"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
								"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
								"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

								"DISPLAY_TOP_PAGER" => 'N',
								"DISPLAY_BOTTOM_PAGER" => 'N',

								"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
								"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
								"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
								"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
								"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

								"SECTION_ID" => 0, //$arResult["VARIABLES"]["SECTION_ID"],
								#"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
								#"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
								"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID'],
								'HIDE_NOT_AVAILABLE' => 'Y',

								'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
								'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
								'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
								'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
								#'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],

								"ADD_SECTIONS_CHAIN" => "N",
								//'ADD_TO_BASKET_ACTION' => $basketAction,
								'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
							),
							$component,
							array("HIDE_ICONS" => "Y")
						);?>

						<?
					}
					?>

                </div> 

		</div> 
	</div>
</div>

<? } elseif ($arResult['PROPERTIES']['HIDE_OPT']['VALUE'] != 1) { ?>
<? if ('Y' == $arParams['DISPLAY_NAME']) { ?>
    <h1>
	<? echo (
		isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ''
		? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
		: $arResult["NAME"]
	); ?>
	</h1>
<? } ?>

<div class="columns catalog-element" id="<? echo $arItemIDs['ID']; ?>">
	<div class="col main_left">
	
		<?
		reset($arResult['MORE_PHOTO']);
		$arFirstPhoto = current($arResult['MORE_PHOTO']);
		unset($arResult['MORE_PHOTO'][0]);
		?>


		<?if($arFirstPhoto['thumb_b']):?>
		<a class="main-image fancyapp" rel="galery" href="<?=$arFirstPhoto['thumb_b']['src']?>" style="background-image: url(<?=$arFirstPhoto['thumb_s']['src']?>);"></a>
		<?endif;?>

		<?if(count($arResult['MORE_PHOTO']) > 0):?>
		<div class="galery">
			<?foreach($arResult['MORE_PHOTO'] as $img):?>
			<a class="fancyapp" rel="galery" href="<?=$img['thumb_b']['src']?>" target="_blank" style="background-image: url(<?=$img['thumb_s']['src']?>);"></a>
			<?endforeach;?>
		</div>
		<?endif;?>

	</div>
	<div class="col main_right">
		<div class="columns">
		
                <div class="col main_left">
				<?
				if ('' != $arResult['PREVIEW_TEXT'] && '' == $arResult['DETAIL_TEXT'])
				{
					echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>');
				}
				elseif ('' != $arResult['DETAIL_TEXT'])
				{
					echo ('html' == $arResult['DETAIL_TEXT_TYPE'] ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>');
				}
				?>
                    <br>
                    <?if(count($arResult['PRODUCT_OFFER'])):?>


<?
$path=explode('?',$_SERVER[REQUEST_URI]);
$path=explode('/',$path[0]);
$c=count($path)-1;

$ht='';
for ($i=2; $i<$c; $i++)
{

$arFilter = Array('IBLOCK_ID'=>$arParams[IBLOCK_ID], 'CODE'=>$path[$i]);
  $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true,array('UF_*'));
  while($ar_result = $db_list->GetNext())
  {
if ($ar_result[UF_TITLEP]!='') $ht=$ar_result[UF_TITLEP];
  }

}

if ($ht=='')  $ht='Выберите тип товара';

if ($ht!='') echo "<h2 style='font-size:16px;'>$ht</h2>";

?>




                        <ul class="product_variant">
                        <select onchange="document.location=this.options[this.selectedIndex].value">
                        <option value='#'>Выберите...</option>
                        <?foreach($arResult['PRODUCT_OFFER'] as $aProductOffer):?>
                            <option value="<?=$aProductOffer['DETAIL_PAGE_URL']; ?>"><?=$aProductOffer['NAME']?></option>
                        <?endforeach;?>
                         </select>
                        </ul>
                    <?endif;?>
                </div>
				
                <div class="col main_right">

                    <?if($arResult['MIN_PRICE']):?>
                    <div class="price-block main">
						<!-- <? #print_r($arResult['MIN_PRICE']);?> -->
						<?=$CSiteController->getHtmlFormatedPrice($arResult["MIN_PRICE"]["CURRENCY"], $arResult["MIN_PRICE"]["DISCOUNT_VALUE"]);?>
					</div>
                    <?endif;?>

					<?if($arResult['BONUS_AMOUNT']):?>
					<div class="your_bonus">Ваш бонус:<span><?=floor($arResult['BONUS_AMOUNT']);?> руб</span></div>
					<?endif;?>

                    <?
                    //$arResult['CATALOG_QUANTITY'] = 8;
                    ?>
					
					<div class="availability">Наличие:
						<?if($arResult['CATALOG_QUANTITY'] >= 10):?>
							<span>В наличии</span>
                        <?elseif($arResult['CATALOG_QUANTITY'] > 0 && $arResult['CATALOG_QUANTITY'] < 10):?>
                            <span class="red">Меньше 10</span>
						<?else:?>
							<span class="no">Нет в наличии</span>
						<?endif;?>
                    </div>

                    <div class="catalog-action">
						<?if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])):?>
							<?if ($arParams['DISPLAY_COMPARE']):?>
							<a class="link icon icon16 compare" data-action="add2compare" data-id="<?=$arResult['ID']?>" href="<?=$arParams['COMPARE_PATH']?>"><span>К сравнению</span></a>
							<br>
							<?endif;?>
                        	<a class="link icon icon16 favorite add2favorite" data-action="add2favorite" data-id="<?=$arResult['ID']?>" href="#"><span>В закладки</span></a>
						<?endif;?>
                    </div>

					<?if($arResult['CAN_BUY']):?>
					<?//=$arResult['BUY_URL']?> <?//=$arResult['ADD_URL']?>

<? if ($arResult['CATALOG_QUANTITY']>0) { ?>
						<a  style="background:#99CC33;border: 1px solid #99CC33;" data-action="add2basket" href="<?=$arResult['ADD_URL']; ?>" class="button buy_now yellow">Купить сейчас</a>
<? } else { ?>

				<a  data-action="add2basket" href="<?=$arResult['ADD_URL']; ?>" class="button buy_now yellow">Сделать предзаказ</a>

<? } ?>

					<?else:?>
						<a data-action="add2basket" href="javascrip:void(0);" class="button buy_now white">Купить сейчас</a>
					<?endif;?>

					<?
					if(count($arResult['SIMILAR_ID']) > 0) //SIMILAR_PRODUCTS
					{
						global $arSimilarFilter;
						$arSimilarFilter = array(
							'ID' => $arResult['SIMILAR_ID']
							);

                        #_print_r($arSimilarFilter);


						?>

						<?$APPLICATION->IncludeComponent(
							"bitrix:catalog.section",
							"similar",
							array(
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
								"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
								"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
								"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
								"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
								"INCLUDE_SUBSECTIONS" => 'Y' ,// 'Y' $arParams["INCLUDE_SUBSECTIONS"],
								"SHOW_ALL_WO_SECTION" => 'Y',
								"BASKET_URL" => $arParams["BASKET_URL"],
								"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
								//"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
								//"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
								//"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
								//"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],

								"FILTER_NAME" => 'arSimilarFilter',

								"CACHE_TYPE" => 'A',
								"CACHE_TIME" => 0,
								"CACHE_FILTER" => 0,
								"CACHE_GROUPS" => 'N',

								"SET_TITLE" => 'N',
								"SET_STATUS_404" => 'N',
								"DISPLAY_COMPARE" => 'N',
								"PAGE_ELEMENT_COUNT" => 10,
								"LINE_ELEMENT_COUNT" => 10,

								"PRICE_CODE" => $arParams["PRICE_CODE"],
								"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
								"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

								"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
								"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
								"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
								"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
								"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

								"DISPLAY_TOP_PAGER" => 'N',
								"DISPLAY_BOTTOM_PAGER" => 'N',

								"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
								"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
								"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
								"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
								"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

								"SECTION_ID" => 0, //$arResult["VARIABLES"]["SECTION_ID"],
								#"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
								#"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
								"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID'],
								'HIDE_NOT_AVAILABLE' => 'Y',

								'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
								'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
								'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
								'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
								#'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],

								"ADD_SECTIONS_CHAIN" => "N",
								//'ADD_TO_BASKET_ACTION' => $basketAction,
								'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
							),
							$component,
							array("HIDE_ICONS" => "Y")
						);?>

						<?
					}
					?>

                </div> 

		</div> 
	</div>
</div>
<? } else { ?>
    <h1>Товар не доступный для оптовой продажи</h1>
<? } ?>