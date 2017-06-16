<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

$arResult["allSum"]='';
foreach ($arResult["GRID"]["ROWS"] as $k => $arItem)
{
if ($arItem[AVAILABLE_QUANTITY]<=0) {
$arResult["allSum"]=$arResult["allSum"]+$arItem[PRICE]*$arItem[QUANTITY];
}
}
if ($arResult["allSum"]>0) echo '<h2>Предзаказ</h2>';

?>

<?
echo ShowError($arResult["ERROR_MESSAGE"]);

$CSiteController = SiteController::getEntity();

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;
$tovar_counter = 0;

foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader)
{
    $arHeaders[] = $arHeader["id"];

    if ($arHeader["id"] == "DELAY")
    {
        $bDelayColumn = true;
        continue;
    }
    elseif ($arHeader["id"] == "DELETE")
    {
        $bDeleteColumn = true;
        continue;
    }
}

if ($normalCount > 0)
{
    ?>

    <input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
    <input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
    <input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
    <input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
    <input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
    <input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
    <input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
    <input type="hidden" id="coupon_approved" value="N" />
    <input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />

    <!-- #basket_items -->
    <table id="basket_items2">

        <?

$arResult["allSum"]=0;

        foreach ($arResult["GRID"]["ROWS"] as $k => $arItem)
        {

if ($arItem[AVAILABLE_QUANTITY]<=0) {

$arResult["allSum"]=$arResult["allSum"]+$arItem[PRICE]*$arItem[QUANTITY];

            if ($arItem["DELAY"] != "N" || $arItem["CAN_BUY"] != "Y")
                continue;

            $tovar_counter += $arItem["QUANTITY"];

            if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
                $url = $arItem["PREVIEW_PICTURE_SRC"];
            elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
                $url = $arItem["DETAIL_PICTURE_SRC"];
            else:
                $url = $templateFolder."/images/no_photo.png";
            endif;
            ?>
            <tr class="row item basket_item basket_line" id="<?= $arItem["ID"] ?>">
                <td class="image" rowspan="2">
                    <div style="background-image: url(<?=$url?>);"></div>
                </td>
                <?
                foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader)
                {



                    if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
                        continue;

                    if ($arHeader["id"] == "NAME") {
                        ?>
                        <td class="name">
                            <div class="title">Название товара</div>
                            <p class="name">
                                <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                    <?=$arItem["NAME"]?>
                                    <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                            </p>
                        </td>
                    <?
                    }
                    elseif ($arHeader["id"] == "QUANTITY")
                    {
                        $ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
                        $max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"" . $arItem["AVAILABLE_QUANTITY"] . "\"" : "";
                        $useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
                        $useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");

                        if (!isset($arItem["MEASURE_RATIO"]))
                            $arItem["MEASURE_RATIO"] = 1;

                        ?>
                        <td class="counter">
                            <input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />

                            <div class="title"> <?//=$arHeader["name"]; ?></div>
                            <div class="counter-control" id="basket_quantity_control">
                                <input
                                    type="text"
                                    size="3"
                                    id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
                                    name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
                                    size="2"
                                    maxlength="18"
                                    min="0"
                                    max="10"
                                    step="<?=$ratio?>"
                                    style="max-width: 50px"
                                    value="<?=$arItem["QUANTITY"]?>"
                                    onchange="updateQuantity2('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)">
                                <?if (floatval($arItem["MEASURE_RATIO"]) != 0):?>
                                    <a href="javascript:void(0);" class="count add" onclick="setQuantity2(<?= $arItem["ID"] ?>, <?= $arItem["MEASURE_RATIO"] ?>, 'up', <?= $useFloatQuantityJS ?>);"></a>
                                    <a href="javascript:void(0);" class="count rem" onclick="setQuantity2(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"></a>
                                <?endif;?>
                            </div>
                            <?
                            #if (isset($arItem["MEASURE_TEXT"]))
                            #	echo $arItem["MEASURE_TEXT"];
                            ?>
                        </td>
                        <?
                        if (floatval($arItem["MEASURE_RATIO"]) != 0)
                        {
                            /*
                            ?>
                            <td id="basket_quantity_control">
                                <div class="basket_quantity_control">
                                    <a href="javascript:void(0);" class="plus"
                                       ></a>
                                    <a href="javascript:void(0);" class="minus"
                                       ></a>
                                </div>
                            </td>
                        <?*/
                        }

                        #if (isset($arItem["MEASURE_TEXT"]))
                        #    echo $arItem["MEASURE_TEXT"];
                    }
                    elseif ($arHeader["id"] == "PRICE")
                    {
                        ?>
                        <td class="tovar-price">
                            <div class="title">Цена<?//=$arHeader["name"]; ?></div>
                            <div class="price-block" id="current_price_<?=$arItem["ID"]?>">
                                <?=$CSiteController->getHtmlFormatedPrice($arItem["CURRENCY"], $arItem["PRICE_FORMATED"]);?>
                            </div>
                        </td>
                        <?
                    }
                    elseif ($arHeader["id"] == "DISCOUNT")
                    {/*
                        ?>
                        <span><?= $arHeader["name"]; ?>:</span>
                        <div id="discount_value_<?= $arItem["ID"] ?>"><?= $arItem["DISCOUNT_PRICE_PERCENT_FORMATED"] ?></div>
                        <?*/
                    }
                    elseif ($arHeader["id"] == "WEIGHT")
                    {/*
                        ?>

                        <span><?= $arHeader["name"]; ?>:</span>
                        <?= $arItem["WEIGHT_FORMATED"] ?>

                    <?*/
                    }
                    else
                    {
                        if ($arHeader["id"] == "SUM")
                        {

                            ?>
                            <td class="total-price">
                                <div class="title">Сумма<?//=$arHeader["name"]; ?></div>
                                <div class="price-block" id="sum_<?=$arItem["ID"]?>">
                                    <?=$CSiteController->getHtmlFormatedPrice($arItem["CURRENCY"], $arItem[$arHeader["id"]]);?>
                                </div>
                            </td>
                            <?
                        }
                    }



                } #endforeach $arResult["GRID"]["HEADERS"]

                ?>
            </tr>

            <tr class="basket_line actions">
                <td colspan="4">
                    <div class="line cart-actions">
                        <a href="#" class="icon icon16 compare" data-action="add2compare" data-id="<?=$arItem['PRODUCT_ID']?>"><span>К сравнению</span></a>
                        <a href="#" class="icon icon16 favorite add2favorite" data-action="add2favorite" data-id="<?=$arItem['PRODUCT_ID']?>"><span>В закладки</span></a>
                        <?
                        if ($bDelayColumn || $bDeleteColumn)
                        {
                            if ($bDeleteColumn):
                                /*<i class="fa fa-close" onclick="removeItem(<?= $arItem["ID"] ?>, '<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete_ajax"])?>');" title="<?=GetMessage("SALE_DELETE")?>"></i>*/
                                ?>
                                <a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" class="icon icon16 remove"><?=GetMessage("SALE_DELETE")?></a>
                                <?
                            endif;
                            if ($bDelayColumn):
                                ?>
                                <?//=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?//=GetMessage("SALE_DELAY")?>
                            <?
                            endif;
                        }
                        ?>
                        <?/*if ($bDelayColumn):
                        ?>
                            <a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?=GetMessage("SALE_DELAY")?></a>
                        <?
                        endif;*/
                        ?>
                    </div>
                </td>
            </tr><!-- row item -->
              <?

        } // Кол-во больше нуля
    
        } #endforeach $arResult["GRID"]["ROWS"];

if ($arResult["allSum"]>0) {

        ?>
        <tr class="itogo">
            <td></td>
            <td></td>
            <td class="tovar-price">
                <div class="title"></div>
                <div class="price-block">
                    Итого
                </div>
            </td>
            <td class="counter">
                <div class="title"></div>
                <div class="counter-control" id="basket_quantity_control">
                    <input type="text" value="<?=$tovar_counter?>" readonly id="all_count2"/>
                </div>
            </td>
            <td class="tovar-price">
                <div class="title"></div>
                <div class="price-block" id="all_summ2">
                    <?=$CSiteController->getHtmlFormatedPrice('RUB', $arResult["allSum"]);?>
                </div>
            </td>
        </tr>
		
<? }  ?>
		
    </table>
    <!-- end #basket_items -->

    <?
    if ($arParams["HIDE_COUPON"] != "Y"):

        $couponClass = "";
        if (array_key_exists('VALID_COUPON', $arResult))
        {
            $couponClass = ($arResult["VALID_COUPON"] === true) ? "good" : "bad";
        }
        elseif (array_key_exists('COUPON', $arResult) && !empty($arResult["COUPON"]))
        {
            $couponClass = "good";
        }
        ?>
        <span><?=GetMessage("STB_COUPON_PROMT")?></span>
        <input type="text" id="coupon" name="COUPON" value="<?=$arResult["COUPON"]?>" onchange="enterCoupon();" size="21" class="<?=$couponClass?>">
    <?endif;?>

    <?/*
    <table>
        <?if ($bWeightColumn):?>
            <tr>
                <td class="custom_t1"><?=GetMessage("SALE_TOTAL_WEIGHT")?></td>
                <td class="custom_t2" id="allWeight_FORMATED"><?=$arResult["allWeight_FORMATED"]?></td>
            </tr>
        <?endif;?>

        <?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
            <tr>
                <td><?echo GetMessage('SALE_VAT_EXCLUDED')?></td>
                <td id="allSum_wVAT_FORMATED"><?=$arResult["allSum_wVAT_FORMATED"]?></td>
            </tr>
            <tr>
                <td><?echo GetMessage('SALE_VAT_INCLUDED')?></td>
                <td id="allVATSum_FORMATED"><?=$arResult["allVATSum_FORMATED"]?></td>
            </tr>
        <?endif;?>

        <tr>
            <td class="custom_t1"></td>
            <td class="custom_t2" style="text-decoration:line-through; color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
                <?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
                    <?=$arResult["PRICE_WITHOUT_DISCOUNT"]?>
                <?endif;?>
            </td>
        </tr>
    </table>
    <?*/
    ?>
    <?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
        <?=$arResult["PREPAY_BUTTON"]?>
        <span><?=GetMessage("SALE_OR")?></span>
    <?endif;?>


    
    <?
}
else
{
    ?>
    <div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
    <?
}