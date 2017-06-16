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
    <?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<ul class="brand-portfolio">
    <?$count = 0;?>
	<?foreach($arResult["ITEMS"] as $arItem):?>
        <?$count++;?>
	<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		$image = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>140, 'height'=>91), BX_RESIZE_IMAGE_PROPORTIONAL, true);  // BX_RESIZE_IMAGE_EXACT BX_RESIZE_IMAGE_PROPORTIONAL

        $link_title = isset($arItem["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arItem["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
            ? $arItem["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
            : $arItem['NAME'];

        $alt = $arItem["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
            ? $arItem["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
            : $arItem["NAME"];

        $title = $arItem["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
            ? $arItem["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
            : $arItem["NAME"];

        $PROP = $arItem['PROPERTIES'];
	?>
	<li<?if($count % 2 == 0):?> class="second"<?endif;?> id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="brand">
            <div class="foto" href="galery-album.php">
                <?if($image):?>
                    <a class="brand_logo" href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$title?>">
                    <img src="<?=$image['src']?>" title="<?=$title?>" alt="<?=$alt?>"/>
                    </a>
                <?endif;?>

                <?if($PROP['LINK']['VALUE']):?>
                <!--noindex-->
                    <a class="link" target="_blank" rel="nofollow" href="http://<?=$PROP['LINK']['VALUE']?>"><?=$PROP['LINK']['VALUE']?></a>
                <!--/noindex-->
                <?endif;?>
            </div>
            <div class="desc">
                <?=$obParser->html_cut($arItem['PREVIEW_TEXT'], 73);?>
				<?/*
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>">Подробнее</a>
				*/?>
            </div>
        </div>
    </li>
	<?endforeach;?>
</ul>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>
