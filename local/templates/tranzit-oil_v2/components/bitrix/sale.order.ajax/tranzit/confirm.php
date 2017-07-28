<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    $CSiteController = SiteController::getEntity();
    $CSiteController->setEnumHtml(' #');

    use \Bitrix\Sale\DeliveryTable;
    use \Bitrix\Sale\PaySystemTable;

    $aOrderProp = array();

    $db_props = CSaleOrderPropsValue::GetOrderProps($arResult["ORDER"]["ID"]);
    while ($arProps = $db_props->Fetch())
    {
        $aOrderProp[$arProps['CODE']] = array(
            'NAME' => $arProps['NAME'],
            'VALUE' => $arProps['VALUE'],
        );
    }

    if (!empty($arResult["ORDER"]))
    {
        
        /*
        $rsDelivery = DeliveryTable::getById($arResult["ORDER"]['DELIVERY_ID']);
        $aDelivery = $rsDelivery->fetch();
        
        if($aDelivery['ID'] == 1)
        {
            $db_vars = CSaleOrderPropsVariant::GetList(
                array("SORT" => "ASC"),
                array(
                    "ORDER_PROPS_CODE" => 'SHOP',
                    "VALUE" => $aOrderProp['SHOP']['VALUE']
                )
            );
            while ($vars = $db_vars->Fetch())
            {
                $aOrderProp['SHOP']['TEXT'] = $vars['NAME'];
            }
        }
         */                     
       
    ?>

    <? if ($arResult["ORDER"]["PRICE"]>0 ) { ?> 
        <h1>Заказ оформлен, спасибо!</h1>
    <? } else { ?>
        <h1>Предзаказ оформлен, спасибо!</h1>
    <? } ?>

    <p>Оплатить заказ можно при получении наличными или по безналичному расчету.</p>

    <?
        $arOrder = CSaleOrder::GetByID($arResult["ORDER"]["ID"]);
        $price2=$arOrder[PRICE]-$arOrder[SUM_PAID];
        $dbOrderProps = CSaleOrderPropsValue::GetOrderProps($arResult["ORDER"]["ID"]);
        while ($arOrderProps = $dbOrderProps->Fetch())
        {            
            $OrderProps[$arOrderProps["ORDER_PROPS_ID"]] =  $arOrderProps;
             
        }
                                         
        //$OrderProp = CSaleOrderPropsVariant::GetList(array(), array("ORDER_PROPS_ID" => 11, "VALUE" => $OrderProp[11]["VALUE"]))->GetNext();                
    ?>

    <div class="order_detail">

    <? if ($arResult["ORDER"]["PRICE"]>0 ) 
    { ?>

        <h2>Заказ №<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?> от <?=$arResult["ORDER"]["DATE_INSERT"]?></h2>
        <div class="data">
            <ul> 
                <?if($arResult["ORDER"]['DELIVERY_ID'] == 1):
                    $OrderProp = CSaleOrderPropsVariant::GetList(array(), array("ORDER_PROPS_ID" => 11, "VALUE" => $OrderProps[11]["VALUE"]))->GetNext(); ?>
                    <li><span>Cпособ получения:</span> Самовывоз</li>                
                    <li><span>Где забирать</span> <?=$OrderProp['NAME']?></li>
                <?elseif($arResult["ORDER"]['DELIVERY_ID'] == 2):
                    ?>
                    <li><span>Cпособ получения:</span> Доставка</li> 
                    <li><span>Адрес доставки</span> <?=$OrderProps[9]['VALUE']?></li>
                <?endif;?>



                <li><span>Сумма к оплате</span><b><?=$CSiteController->getHtmlFormatedPrice($arResult["ORDER"]["CURRENCY"], $arResult["ORDER"]["PRICE"]);?></b></li>

                <? if ($arOrder[SUM_PAID]>'0') { ?><li><span>Сумма к оплате c учетом<br> бонусов</span><b><?=$CSiteController->getHtmlFormatedPrice($arResult["ORDER"]["CURRENCY"], $price2);?></b></li><br> <? } ?>

                <li><span>Спопсоб оплаты</span><?=$arResult["PAY_SYSTEM"]["NAME"]?><?// PAY_SYSTEM PAY_SYSTEM_ID?></li>

                <li class="sep"><span>Электронная почта</span><?=$aOrderProp["EMAIL"]['VALUE']?></li>
                <li><span>Телефон</span><?=$aOrderProp['PHONE']['VALUE']?></li>
            </ul>

        <? } else 
        { ?>

            <h2>Предзаказ №<?=($arResult["ORDER"]["ACCOUNT_NUMBER"]+1)?> от <?=$arResult["ORDER"]["DATE_INSERT"]?></h2>
            <div class="data">
                <ul>

                <?if($arResult["ORDER"]['DELIVERY_ID'] == 1):
                    $OrderProp = CSaleOrderPropsVariant::GetList(array(), array("ORDER_PROPS_ID" => 11, "VALUE" => $OrderProps[11]["VALUE"]))->GetNext(); ?>
                    <li><span>Cпособ получения:</span> Самовывоз</li>                
                    <li><span>Где забирать</span> <?=$OrderProp['NAME']?></li>
                <?elseif($arResult["ORDER"]['DELIVERY_ID'] == 2):
                    ?>
                    <li><span>Cпособ получения:</span> Доставка</li> 
                    <li><span>Адрес доставки</span> <?=$OrderProps[9]['VALUE']?></li>
                <?endif;?>

                    <?

                        // Определить цену предзаказа


                        global $USER;


                        global $DB;
                        $SQL="SELECT * FROM order_agent WHERE status=0 and user=".$USER->GetID()." order by user ASC LIMIT 0,1000;";
                        
                        $results=$DB->Query($SQL);


                        $su=0;

                        while ($row = $results->Fetch())
                        {
                           $su=$su+$row[PRICE]*$row[QUANTITY];
                        }

                        if ($su<=0) 
                        {
                            $arOrder = CSaleOrder::GetByID($arResult["ORDER"]["ACCOUNT_NUMBER"]+1);
                            $su=$arOrder[PRICE];
                        }

                    ?>


                    <li><span>Сумма к оплате<br> </span><b><?=$CSiteController->getHtmlFormatedPrice($arResult["ORDER"]["CURRENCY"], $su);?></b></li>

                    <li><span>Спопсоб оплаты</span><?=$arResult["PAY_SYSTEM"]["NAME"]?><?// PAY_SYSTEM PAY_SYSTEM_ID?></li>

                    <li class="sep"><span>Электронная почта</span><?=$aOrderProp["EMAIL"]['VALUE']?></li>
                    <li><span>Телефон</span><?=$aOrderProp['PHONE']['VALUE']?></li>
                </ul>

        <? } ?>

        </div>

    </div>

    <? if (!empty($arResult["PAY_SYSTEM"])) 
    {  ?>
            <br /><br />

            <table class="sale_order_full_table">
                <tr>
                    <td class="ps_logo">
                        <div class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></div>
                        <?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
                        <div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div><br>
                    </td>
                </tr>
                <?
                    if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
                    {
                    ?>
                    <tr>
                        <td>
                            <?
                                if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
                                {
                                ?>
                                <script language="JavaScript">
                                    window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
                                </script>
                                <?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
                                <?
                                    if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
                                    {
                                    ?><br />
                                    <?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
                                    <?
                                    }
                                }
                                else
                                {
                                    if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
                                    {
                                        include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                    <?
                    }
                ?>
            </table>
            <?
            }
    }
    else
    {
    ?>
    <b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

    <table class="sale_order_full_table">
        <tr>
            <td>
                <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
                <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
            </td>
        </tr>
    </table>
    <?
    }
?>
