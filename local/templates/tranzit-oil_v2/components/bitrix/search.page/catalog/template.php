<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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

include $_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/include/status_bayers.php';

$CSiteController = SiteController::getEntity();
?>
<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div>
<?endif;?>

<?
#_print_r($arResult["SEARCH"]);
?>

<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>

<?elseif($arResult["ERROR_CODE"]!=0):?>

	<p><?=GetMessage("SEARCH_ERROR")?></p>
	<?ShowError($arResult["ERROR_TEXT"]);?>
	<p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
	<br /><br />
	<p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
	<table border="0" cellpadding="5">
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
			<td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
			<td><?=GetMessage("SEARCH_AND_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
			<td><?=GetMessage("SEARCH_OR_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
			<td><?=GetMessage("SEARCH_NOT_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top">( )</td>
			<td valign="top">&nbsp;</td>
			<td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
		</tr>
	</table>

<?elseif(count($arResult["SEARCH"])>0):?>


	<?/*if($arResult["REQUEST"]["HOW"]=="d"):?>
		<a href="<?=$arResult["URL"]?>&amp;how=r<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>"><?=GetMessage("SEARCH_SORT_BY_RANK")?></a>&nbsp;|&nbsp;<b><?=GetMessage("SEARCH_SORTED_BY_DATE")?></b>
	<?else:?>
		<b><?=GetMessage("SEARCH_SORTED_BY_RANK")?></b>&nbsp;|&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>"><?=GetMessage("SEARCH_SORT_BY_DATE")?></a>
	<?endif;*/?>

	<?#if($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"]?>

	<h1>Поиск "<?=TruncateText($arResult['REQUEST']['QUERY'], 50);?>" <!--- <span><span><?//=count($arResult["SEARCH"])?></span><?//=$arResult["SEARCH_TEXT"]?>.</span>--></h1>

	<?
	#_print_r($arItem['PRODUCT']);
	?>

	<ul class="catalog-element-list">
	<?foreach($arResult["SEARCH"] as $arItem):?>
		<?php
		if($arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 94
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 219
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 220
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 223
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 227
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 230
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 235
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 237
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 240
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 243
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 245
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 250
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 252
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 253
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 254
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 255
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 256
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 258
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 259
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 260
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 262
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 263
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 264
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 330
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 325
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 326
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 329
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 332
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 334
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 335
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 336
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 337
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 338
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 339
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 340
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 341
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 345
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 350
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 352
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 353
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 354
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 357
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 359
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 363
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 402
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 403
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 406
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 408
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 412
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 419
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 420
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 421
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 428
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 431
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 433
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 458
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 459
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 464
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 476
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 478
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 480
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 484
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 489
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 490
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 503
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 512
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 515
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 521
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 522
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 523
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 524
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 525
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 529
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 534
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 542
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 554
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 555
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 583
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 585
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 587
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 592
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 598
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 599
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 600
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 601
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 604
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 605
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 610
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 612
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 613
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 617
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 618
		&& $arItem['PRODUCT']["IBLOCK_SECTION_ID"] != 622){?>
		<?php if($arItem['PRODUCT']['PROP']['HIDE_OPT']['VALUE'] != 1 && $status_bayer == 'Юридическое лицо'){ ?>
		<li>
			<a href="<?=$arItem["URL"]?>" class="image" style="background-image: url(<?=$arItem['PRODUCT']["PICTURE"]['src']?>);" title="<?=$arItem['PRODUCT']["NAME"]?>"></a>
			<div class="desc">
				<div class="line1">

					<div class="left-block">
						<a href="<?=$arItem['URL']; ?>" class="name" title="<?=$arItem['PRODUCT']["NAME"]?>"><?=$arItem['TITLE_FORMATED']//TruncateText(HTMLToTxt($arItem['TITLE_FORMATED']), 95);?></a>
						<?/*if($arItem['PRODUCT']['PREVIEW_TEXT']):?>
							<div class="info"><?=TruncateText(HTMLToTxt($arItem['PRODUCT']['PREVIEW_TEXT']), 95);?></div>
						<?endif;*/?>
					</div>

					<div class="right-block">
						<div class="price-block">
                            <?if($arItem['PRODUCT']["PRICE"]):?>
							<?=$CSiteController->getHtmlFormatedPrice($arItem['PRODUCT']["PRICE"]["CURRENCY"], $arItem["PRODUCT"]["DISCOUNT_PRICE"]);?>
                            <?endif;?>
						</div>

						<?if($arItem['PRODUCT']["CAN_BUY"] && $arItem['PRODUCT']["CATALOG_QUANTITY"] > 0):?>
							<div class="availability">В наличии</div>
						<?else:?>
							<div class="no-availability">Нет&nbsp;в&nbsp;наличии</div>
						<?endif;?>
					</div>
				</div>
				<div class="line2">

                    <?if($arItem['PRODUCT']["PROP"]["CML2_ARTICLE"]["VALUE"]):?>
					<div class="articul">Артикул: <span><?=$arItem['PRODUCT']["PROP"]["CML2_ARTICLE"]["VALUE"]?></span></div>
                    <?endif;?>

					<div class="action-block">
						<a class="icon icon16 compare link" data-action="add2compare" data-id="<?=$arItem['ITEM_ID']?>" href="#"><span>К сравнению</span></a>
						<a class="icon icon16 favorite link add2favorite" data-action="add2favorite" data-id="<?=$arItem['ITEM_ID']?>" href="#"><span>В закладки</span></a>
						<?if($arItem['PRODUCT']["CAN_BUY"]):?>
						<?php 
						CModule::IncludeModule('catalog');
						CModule::IncludeModule('sale');
						
						$ar_res = CCatalogProduct::GetByID($arItem[ITEM_ID]);
						$arItem['ADD_URL']=$arItem[PRODUCT][DETAIL_PAGE_URL]."?action=ADD2BASKET&id=".$arItem[ITEM_ID];
						?>
						<? if ($ar_res[QUANTITY]>0) { ?>
							<a  style="background:#99CC33;border: 1px solid #99CC33;"  class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Купить</a>
                        <? } else {?>
						    <a class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Заказать</a>
						<? } ?>

						<?else:?>
							<a class="buy button white" href="javascript:void(0);" rel="nofollow">Купить</a>
						<?endif;?>
					</div>
				</div>
			</div>
		</li>
		<? }elseif($status_bayer != 'Юридическое лицо'){ ?>
		<li>
			<a href="<?=$arItem["URL"]?>" class="image" style="background-image: url(<?=$arItem['PRODUCT']["PICTURE"]['src']?>);" title="<?=$arItem['PRODUCT']["NAME"]?>"></a>
			<div class="desc">
				<div class="line1">

					<div class="left-block">
						<a href="<?=$arItem['URL']; ?>" class="name" title="<?=$arItem['PRODUCT']["NAME"]?>"><?=$arItem['TITLE_FORMATED']//TruncateText(HTMLToTxt($arItem['TITLE_FORMATED']), 95);?></a>
						<?/*if($arItem['PRODUCT']['PREVIEW_TEXT']):?>
							<div class="info"><?=TruncateText(HTMLToTxt($arItem['PRODUCT']['PREVIEW_TEXT']), 95);?></div>
						<?endif;*/?>
					</div>

					<div class="right-block">
						<div class="price-block">
                            <?if($arItem['PRODUCT']["PRICE"]):?>
							<?=$CSiteController->getHtmlFormatedPrice($arItem['PRODUCT']["PRICE"]["CURRENCY"], $arItem["PRODUCT"]["DISCOUNT_PRICE"]);?>
                            <?endif;?>
						</div>

						<?if($arItem['PRODUCT']["CAN_BUY"] && $arItem['PRODUCT']["CATALOG_QUANTITY"] > 0):?>
							<div class="availability">В наличии</div>
						<?else:?>
							<div class="no-availability">Нет&nbsp;в&nbsp;наличии</div>
						<?endif;?>
					</div>
				</div>
				<div class="line2">

                    <?if($arItem['PRODUCT']["PROP"]["CML2_ARTICLE"]["VALUE"]):?>
					<div class="articul">Артикул: <span><?=$arItem['PRODUCT']["PROP"]["CML2_ARTICLE"]["VALUE"]?></span></div>
                    <?endif;?>

					<div class="action-block">
						<a class="icon icon16 compare link" data-action="add2compare" data-id="<?=$arItem['ITEM_ID']?>" href="#"><span>К сравнению</span></a>
						<a class="icon icon16 favorite link add2favorite" data-action="add2favorite" data-id="<?=$arItem['ITEM_ID']?>" href="#"><span>В закладки</span></a>
						<?if($arItem['PRODUCT']["CAN_BUY"]):?>
						<?php 
						CModule::IncludeModule('catalog');
						CModule::IncludeModule('sale');
						
						$ar_res = CCatalogProduct::GetByID($arItem[ITEM_ID]);
						$arItem['ADD_URL']=$arItem[PRODUCT][DETAIL_PAGE_URL]."?action=ADD2BASKET&id=".$arItem[ITEM_ID];
						?>
						<? if ($ar_res[QUANTITY]>0) { ?>
							<a  style="background:#99CC33;border: 1px solid #99CC33;"  class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Купить</a>
                        <? } else {?>
						    <a class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Заказать</a>
						<? } ?>

						<?else:?>
							<a class="buy button white" href="javascript:void(0);" rel="nofollow">Купить</a>
						<?endif;?>
					</div>
				</div>
			</div>
		</li>
		<? } ?>
		
		<? } ?>
	<?endforeach;?>
	</ul>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]?>



<?else:?>

	<?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>***

<?endif;?>
</div>
