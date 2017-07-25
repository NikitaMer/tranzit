<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
    if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
    {
        if(strlen($arResult["REDIRECT_URL"]) > 0)
        {
            $APPLICATION->RestartBuffer();
            ?>
            <script type="text/javascript">
                window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
            </script>
            <?
            die();
        }

    }
}

$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");

CJSCore::Init(array('fx', 'popup', 'window', 'ajax'));
?>

<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">

    <NOSCRIPT>
        <div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
    </NOSCRIPT>

    <?
    if (!function_exists("getColumnName"))
    {
        function getColumnName($arHeader)
        {
            return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
        }
    }

    if (!function_exists("cmpBySort"))
    {
        function cmpBySort($array1, $array2)
        {
            if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
                return -1;

            if ($array1["SORT"] > $array2["SORT"])
                return 1;

            if ($array1["SORT"] < $array2["SORT"])
                return -1;

            if ($array1["SORT"] == $array2["SORT"])
                return 0;
        }
    }
    ?>


    <?
    if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
    {
        if(!empty($arResult["ERROR"]))
        {
            foreach($arResult["ERROR"] as $v)
                echo ShowError($v);
        }
        elseif(!empty($arResult["OK_MESSAGE"]))
        {
            foreach($arResult["OK_MESSAGE"] as $v)
                echo ShowNote($v);
        }

        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
    }
    else
    {
        if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
        {
            if(strlen($arResult["REDIRECT_URL"]) == 0)
            {
                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
            }
        }
        else
        {
            ?>
            <script type="text/javascript">
            var BXFormPosting = false;
            function submitForm(val)
            {
                if (BXFormPosting === true)
                    return true;

                BXFormPosting = true;
                if(val != 'Y')
                    BX('confirmorder').value = 'N';

                var orderForm = BX('ORDER_FORM');
                BX.showWait();

                BX.ajax.submit(orderForm, ajaxResult);

                return true;
            }

            function ajaxResult(res)
            {
                try
                {
                    var json = JSON.parse(res);
                    BX.closeWait();

                    if (json.error)
                    {
                        BXFormPosting = false;
                        return;
                    }
                    else if (json.redirect)
                    {
                        window.top.location.href = json.redirect;
                    }
                }
                catch (e)
                {
                    BXFormPosting = false;
                    BX('order_form_content').innerHTML = res;

                    <?if(CSaleLocation::isLocationProEnabled()):?>
                    BX.saleOrderAjax.initDeferredControl();
                    <?endif?>
                }

                BX.closeWait();
                BX.onCustomEvent(orderForm, 'onAjaxSuccess');
            }

            function SetContact(profileId)
            {
                BX("profile_change").value = "Y";
                submitForm();
            }
            </script>
            <?if($_POST["is_ajax_post"] != "Y")
            {
                ?>
                <form class="style2 form_order" action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
                <?=bitrix_sessid_post()?>
                <div id="order_form_content">
                <?
            }
            else
            {
                $APPLICATION->RestartBuffer();
            }

            $t = $arResult;
            unset($t['BASKET_ITEMS']);
            unset($t['GRID']);

            #_print_r($t, true);

            if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
            {
                foreach($arResult["ERROR"] as $v)
                    echo ShowError($v);
                ?>
                <script type="text/javascript">
                    top.BX.scrollToNode(top.BX('ORDER_FORM'));
                </script>
                <?
            }

            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");

            echo '<div class="sep line"></div>';

            if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
            {
                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");

                echo PrintPropsForm($arResult["ORDER_PROP"]["RELATED"], $arParams["TEMPLATE_LOCATION"]);
            }
            else
            {
                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");


                foreach($arResult["ORDER_PROP"]["RELATED"] as $index => $prop)
                {
                    if($prop['CODE'] == 'DELIVERY_ADRES' || $prop['CODE'] == 'SHOP')
                    {
                        $p = array($prop);
                        echo PrintPropsForm($p, $arParams["TEMPLATE_LOCATION"]);
                    }
                }

                echo '<div class="sep"></div>';

                ?>
                <div class="field textarea w480p">
                    <label><?=GetMessage("SOA_TEMPL_SUM_COMMENTS")?></label>
                    <textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION" style="min-height:100px"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
                    <input type="hidden" name="" value="">
                </div>
                <?

                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");

                foreach($arResult["ORDER_PROP"]["RELATED"] as $index => $prop)
                {
                    if($prop['CODE'] == 'DETAILS')
                    {
                        $p = array($prop);
                        echo PrintPropsForm($p, $arParams["TEMPLATE_LOCATION"]);
                        break;
                    }
                }

            }

            echo '<div class="sep line"></div>';
            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");

            if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
                echo $arResult["PREPAY_ADIT_FIELDS"];
            ?>

            <?if($_POST["is_ajax_post"] != "Y")
            {
                ?>
                    </div>
                    <input type="hidden" name="confirmorder" id="confirmorder" value="Y">
                    <input type="hidden" name="profile_change" id="profile_change" value="N">
                    <input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
                    <input type="hidden" name="json" value="Y">

                    <br>
                    <br>
                    <div class="bx_ordercart_order_pay_center">
                        <a href="javascript:void();" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="button round yellow">
                            <?=GetMessage("SOA_TEMPL_BUTTON")?></a>
                        <div class="button-line"></div>
                    </div>

                    <br>
                    <br>
                    <p>После оформления заказа, с вами по указанному номеру свяжется менеджер и еще раз<br>
                        уточнит все детали. Проверьте, чтобы контактный телефон был указан правильно</p>
                </form>
                <?if($arParams["DELIVERY_NO_AJAX"] == "N"):?>
                    <div style="display:none;">
                        <?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?>
                    </div>
                    <?endif;?>

            <?
            }
            else
            {
                ?>
                <script type="text/javascript">
                    top.BX('confirmorder').value = 'Y';
                    top.BX('profile_change').value = 'N';
                </script>
                <?
                die();
            }
            ?>

            <script>
                $(function(){
                    submitForm();
                });

            </script>
            <?

        }
    }
    ?>
    </div>


<?if(CSaleLocation::isLocationProEnabled()):?>

    <div style="display: none">
        <?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:sale.location.selector.steps",
            ".default",
            array(
            ),
            false
        );?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:sale.location.selector.search",
            ".default",
            array(
            ),
            false
        );?>
    </div>

<?endif?>