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
$obParser = new CTextParser;
?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?//=$arResult["NAV_STRING"]?><br />
<?endif;?>

<ul class="news-list left_list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		$image = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>91, 'height'=>91), BX_RESIZE_IMAGE_EXACT, true);  //BX_RESIZE_IMAGE_PROPORTIONAL
		$name = $obParser->html_cut($arItem["NAME"], 34);
		$title = strlen($name) != strlen($arItem["NAME"]) ? $arItem["NAME"] : '';
		?>
		<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<h3><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$title?>"><?=$name;?></a></h3>
			<div class="desc">
				<div class="img"><?if($image):?><img src="<?=$image['src']?>" alt="<?=$arItem["NAME"]?>"/><?endif;?></div>
				<div class="text">
					<?if($arItem["PREVIEW_TEXT"]):?>
					<p><?=$obParser->html_cut($arItem["PREVIEW_TEXT"], 40);?></p>
					<?endif;?>
					<a class="more" href="<?=$arItem["DETAIL_PAGE_URL"]?>">подробнее</a>
				</div>
			</div>
		</li>
	<?endforeach;?>
</ul>
