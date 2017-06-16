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

<div class="title_line">
	<h2><?=$arResult["NAME"]?></h2>
	<a class="back_all_news" href="<?=$arResult["LIST_PAGE_URL"]?>">все новости</a>
</div>

<ul class="news-list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		$image = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>91, 'height'=>91), BX_RESIZE_IMAGE_EXACT, true);  //BX_RESIZE_IMAGE_PROPORTIONAL
		$name = TruncateText($arItem["NAME"], 50);
		$title = strlen($name) != strlen($arItem["NAME"]) ? $arItem["NAME"] : '';
		?>
		<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<h3><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$title?>"><?=$name;?></a></h3>
			<div class="desc">
				<div class="img"><?if($image):?><img src="<?=$image['src']?>" alt="<?=$arItem["NAME"]?>"/><?endif;?></div>
				<div class="text">
					<?if($arItem["PREVIEW_TEXT"]):?>
					<p><?=$obParser->html_cut($arItem["PREVIEW_TEXT"], 70);?></p>
					<?endif;?>
					<a class="more" href="<?=$arItem["DETAIL_PAGE_URL"]?>">подробнее</a>
				</div>
			</div>
		</li>
	<?endforeach;?>
</ul>
