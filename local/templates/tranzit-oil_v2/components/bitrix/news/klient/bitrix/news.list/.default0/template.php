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
if(count($arResult["ITEMS"]) == 0)
	return;
	
$obParser = new CTextParser;
?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

<ul class="news-list-full">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		$image = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>291, 'height'=>105), BX_RESIZE_IMAGE_EXACT, true);  //BX_RESIZE_IMAGE_PROPORTIONAL
		$name = TruncateText($arItem["NAME"], 62);
		$title = strlen($name) != strlen($arItem["NAME"]) ? $arItem["NAME"] : '';
		
		?>
		<li class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		
			<a class="img" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<?if($arItem["ACTIVE_FROM"]):?>
				<div class="date"><?=$arItem["ACTIVE_FROM"]?></div>
				<?endif;?>
				<?if($image):?>
				<img src="<?=$image['src']?>" alt="<?=$arItem["NAME"]?>"/>
				<?endif;?>
			</a>
			<div class="desc">
				<h3><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$name?></a></h3>
				<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
					<p><?=$obParser->html_cut($arItem["PREVIEW_TEXT"], 120);?></p>
				<?endif;?>
				<a class="more" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Подробнее</a>
			</div>
			
		</li>
	<?endforeach;?>
</ul>
		
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

