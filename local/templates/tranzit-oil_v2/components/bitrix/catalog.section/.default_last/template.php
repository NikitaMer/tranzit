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

<?

if (!empty($arResult['ITEMS']))
{
    if ($arParams["DISPLAY_TOP_PAGER"])
    {
        ?><? echo $arResult["NAV_STRING"]; ?><?
    }
    ?><ul class="catalog-element-list"><?

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
        ?>
        <li id="<? echo $strMainID; ?>">
            <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="image" style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC']; ?>);" title="<?=$imgTitle;?>"></a>
            <div class="desc">
                <div class="line1">
                    
                    <div class="left-block">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']; ?>" class="name" title="<? echo $productTitle; ?>"><?=TruncateText($productTitle, 95);?></a>
                        <?if($arItem['PREVIEW_TEXT']):?>
                        <div class="info"><?=TruncateText(HTMLToTxt($arItem['PREVIEW_TEXT']), 95);?></div>
                        <?endif;?>
                    </div>
                    
                    <div class="right-block">
                        <div class="price-block">
                            <?
                            if (!empty($arItem['MIN_PRICE']) && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
                            {
                                echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                            }
                            ?>
                        </div>
                        <?
                        if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
                        {
                            if ($arItem['CAN_BUY'])
                            {
                                ?>
                                <div class="availability">В наличии</div>
                                <?
                                
                            }
                            else
                            {
                                ?>
                                <div class="availability no">Нет в наличии</div>
                                <?
                            }
                            
                        }
                        ?>
                    </div>
                </div>
                <div class="line2">
                    <div class="articul">Артикул: <span><?=TruncateText($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'], 9);?></span></div>
                    <div class="action-block">
                        <?
                        if ($arParams['DISPLAY_COMPARE'] && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
                        {
                            ?>
                            <a class="icon icon16 compare link" data-action="add2compare" data-id="<?=$arItem['ID']?>" href="#"><span>К сравнению</span></a>
                            <?
                        }
                        ?>
                        <a class="icon icon16 favorite link add2favorite" data-action="add2favorite" data-id="<?=$arItem['ID']?>" href="#"><span>В закладки</span></a>
                        <?
                        if ($arItem['CAN_BUY'] && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
                        {
                            #BUY_URL
                            ?>
                            <a class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Купить</a>
                            <?
                        }
                        else
                        {
                            ?>
                            <a class="buy button not_av" href="javascript:void(0);" rel="nofollow">Купить</a>
                            <?
                        }
                        ?>
                    </div>
                </div>
            </div>
        
            
        </li><?
    }
    ?></ul><?

    if ($arParams["DISPLAY_BOTTOM_PAGER"])
    {
        ?><? echo $arResult["NAV_STRING"]; ?><?
    }

}
?>
<script>
    $(function(){

        $('.catalog-element-list li').each(function(i, el){
            var name = $(el).find('.name'),
                info = $(el).find('.info');

            if(name.height() > 30)
                info.height(20);
            });
        });
</script>

