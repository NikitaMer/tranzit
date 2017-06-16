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
$this->setFrameMode(true);
?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?if($arResult["ITEMS"]):?>
	<ul class="contacts">
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		$image = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>151, 'height'=>151), BX_RESIZE_IMAGE_EXACT, true);  //BX_RESIZE_IMAGE_PROPORTIONAL
		
		$PROP = $arItem['PROPERTIES'];
		?>
		<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="foto">
				<?if($image):?>
				<img src="<?=$image['src']?>" alt="<?=$arItem['NAME']?>"/>
				<?endif;?>
			</div>
			<div class="desc">
				<?if($PROP['POSITION']['VALUE']):?>
				<p><b><?=$PROP['POSITION']['VALUE']?>:</b></p>
				<?endif;?>
				<p><?=$arItem['NAME']?></p>

				<?if($PROP['MOBILE']['VALUE']):?>
				<p><?=$PROP['MOBILE']['NAME']?>: <?=is_array($PROP['MOBILE']['VALUE']) ? implode(',',$PROP['MOBILE']['VALUE']) : $PROP['MOBILE']['VALUE'];?>;</p>
				<?endif;?>

				<?if($PROP['PHONE']['VALUE']):?>
				<p><?=$PROP['PHONE']['NAME']?>: <?=is_array($PROP['PHONE']['VALUE']) ? implode(',',$PROP['PHONE']['VALUE']) : $PROP['PHONE']['VALUE'];?>;</p>
				<?endif;?>

				<?if($PROP['FAX']['VALUE']):?>
				<p><?=$PROP['FAX']['NAME']?>: <?=is_array($PROP['FAX']['VALUE']) ? implode(',',$PROP['FAX']['VALUE']) : $PROP['FAX']['VALUE'];?>;</p>
				<?endif;?>
				<?if($PROP['EMAIL']['VALUE']):?>
				<p><?=$PROP['EMAIL']['NAME']?>: <a href="mailto: <?=$PROP['EMAIL']['VALUE']?>"><?=$PROP['EMAIL']['VALUE']?></a></p>
				<?endif;?>

				<? #echo '<pre>'.print_r($arItem['PROPERTIES'], true).'</pre>'?>
			</div>
		</li>
	<?endforeach;?>
	</ul>
<?endif;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

