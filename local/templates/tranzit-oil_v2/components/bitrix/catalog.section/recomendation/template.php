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

$CSiteController = SiteController::getEntity();

if (!empty($arResult['ITEMS']))
{
    if ($arParams["DISPLAY_TOP_PAGER"])
        echo $arResult["NAV_STRING"];

    ?>
    <div class="title">Рекомендуемые товары</div>

    <ul class="catalog-specoffers-list"><?

    $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
    $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
    $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

    foreach ($arResult['ITEMS'] as $key => $arItem)
    {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
        $strMainID = $this->GetEditAreaId($arItem['ID']);

        $productTitle = (
            isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
            ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
            : $arItem['NAME']
            );
            
        $imgTitle = (
            isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
            ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
            : $arItem['NAME']
            );

        $pict = null;//$arItem['PREVIEW_PICTURE'];


        if(!$pict && is_array($arItem['DETAIL_PICTURE']))
            $pict = $arItem['DETAIL_PICTURE'];

        if(!$pict && is_array($arItem['PREVIEW_PICTURE']))
            $pict = $arItem['PREVIEW_PICTURE'];

        $image = CFile::ResizeImageGet($pict, array('width'=>82, 'height'=>82), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        ?>
        <li id="<? echo $strMainID; ?>">

            <?if($image):?>
                <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="image" style="background-image: url(<?=$image['src'];?>)" title="<?=$imgTitle;?>"></a>
            <?else:?>
                <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="image" title="<?=$imgTitle;?>"></a>
            <?endif;?>

            <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="catalog-name"><? echo TruncateText($arItem['NAME'], 30); ?></a>

            <div class="price-block">
                <?if (!empty($arItem['MIN_PRICE']) && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))):?>
                <?=$CSiteController->getHtmlFormatedPrice($arItem["MIN_PRICE"]["CURRENCY"], $arItem["MIN_PRICE"]["DISCOUNT_VALUE"]);?>
                <?endif;?>
            </div>

            <?
            if ($arItem['CAN_BUY'])
            {
                #BUY_URL
                ?>
                <a class="buy button round green" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Купить</a>
            <?
            }
            else
            {
                ?>
                <a class="buy button round white not_av" href="javascript:void(0);" rel="nofollow">Купить</a>
            <?
            }
            ?>


        </li><?
    }
    ?></ul><?

    if ($arParams["DISPLAY_BOTTOM_PAGER"])
        echo $arResult["NAV_STRING"];

}
?>