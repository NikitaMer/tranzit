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

//YOUTUBE

if (!empty($arResult['ITEMS']))
{
    if ($arParams["DISPLAY_TOP_PAGER"])
        echo $arResult["NAV_STRING"];

    $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
    $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
    $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
    ?>
    <ul class="photo-galery-list">
    <?
    $count = 0;

    foreach ($arResult['ITEMS'] as $key => $arItem)
    {
        $count ++;

        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
        $strMainID = $this->GetEditAreaId($arItem['ID']);

        $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

        $productTitle = (
        isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
            ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
            : $arItem['NAME']
        );
        $imgTitle = (
        isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
            ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
            : $arItem['NAME']
            );

        $li_class = $count % 3 == 0 ? ' class="break"' : '' ;

        $thumb_s = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>216, 'height'=>216), BX_RESIZE_IMAGE_EXACT, true);
        $thumb_b = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        ?>
        <li id="<? echo $strMainID; ?>"<?=$li_class?>>
            <a rel="photo_galery" class="fancyapp" target="_blank" href="<? echo $thumb_b['src']; ?>"
                style="background-image: url('<? echo $thumb_s['src']; ?>')" title="<?=$count?>. <? echo $imgTitle; ?>">
            </a>
        </li>
    <?
    }
    ?></ul><?

    if ($arParams["DISPLAY_BOTTOM_PAGER"])
        echo $arResult["NAV_STRING"];
}
?>