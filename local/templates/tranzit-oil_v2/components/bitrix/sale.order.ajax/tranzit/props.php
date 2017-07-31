<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");

function usortTest($a, $b)
{
    return $a['SORT'] > $b['SORT'];
}

$arSections = array();

foreach($arResult["ORDER_PROP"]["USER_PROPS_N"] as $prop)
{
    if(!array_key_exists($prop['PROPS_GROUP_ID'], $arSections))
    {
        $arSections[$prop['PROPS_GROUP_ID']] = array(
            'ID' => $prop['PROPS_GROUP_ID'],
            'NAME' => $prop['GROUP_NAME'],
            );
    }

    $arSections[$prop['PROPS_GROUP_ID']]['PROP'][] = $prop;
}

foreach($arResult["ORDER_PROP"]["USER_PROPS_Y"] as $prop)
{
    if(!array_key_exists($prop['PROPS_GROUP_ID'], $arSections))
    {
        $arSections[$prop['PROPS_GROUP_ID']] = array(
            'ID' => $prop['PROPS_GROUP_ID'],
            'NAME' => $prop['GROUP_NAME'],
            );
    }

    $arSections[$prop['PROPS_GROUP_ID']]['PROP'][] = $prop;
}

$count = 0;
usort($arSections, "usortTest");

//_print_r($arSections[0]['PROP']);
?>
<?foreach($arSections as $id => $aSection):?>
    <?
    if(empty($aSection['PROP']))
        continue;
        
    if($aSection['NAME'] == 'Бонусная система')
        continue; 

    usort($aSection['PROP'], "usortTest");
    ?>
    <?if($count > 0):?>
        <div class="sep"></div>
        <div class="section_title"><?=$aSection['NAME']?></div>
    <?else:?>
        <h1>Оформление заказа</h1>
    <?endif;?>

    <? PrintPropsForm($aSection['PROP'], $arParams["TEMPLATE_LOCATION"], $count); ?>

    <?$count++;?>
<?endforeach;?>
<?
#PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"]);
#PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"]);
?>
<?if(!CSaleLocation::isLocationProEnabled()):?>
    <div style="display:none;">

        <?$APPLICATION->IncludeComponent(
            "bitrix:sale.ajax.locations",
            $arParams["TEMPLATE_LOCATION"],
            array(
                "AJAX_CALL" => "N",
                "COUNTRY_INPUT_NAME" => "COUNTRY_tmp",
                "REGION_INPUT_NAME" => "REGION_tmp",
                "CITY_INPUT_NAME" => "tmp",
                "CITY_OUT_LOCATION" => "Y",
                "LOCATION_VALUE" => "",
                "ONCITYCHANGE" => "submitForm()",
            ),
            null,
            array('HIDE_ICONS' => 'Y')
        );?>

    </div>
<?endif?>