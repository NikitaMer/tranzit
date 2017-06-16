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
$image = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>670, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true);  //BX_RESIZE_IMAGE_PROPORTIONAL
?>

<div class="news-detail">
	
	<?if($image):?>
	<img class="main" src="<?=$image['src']?>" alt="<?=$arResult["NAME"]?>"/>
	<?endif;?>
	
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><?endif;?>
		<?=$arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><?=$arResult["NAV_STRING"]?><?endif;?>
	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?=$arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?=$arResult["PREVIEW_TEXT"];?>
	<?endif?>
	
</div>
