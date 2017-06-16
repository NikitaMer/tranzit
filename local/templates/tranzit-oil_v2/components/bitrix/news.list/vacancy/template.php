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
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?><br />
<?endif;?>

<?if($arResult["ITEMS"]):?>
    <ul class="vacance">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

            $image = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>151, 'height'=>151), BX_RESIZE_IMAGE_EXACT, true);  //BX_RESIZE_IMAGE_PROPORTIONAL

            $PROP = $arItem['PROPERTIES'];
            ?>
            <li class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <h2><?=$arItem['NAME']?><?if($PROP['SALARY']['VALUE']):?> (<?=$PROP['SALARY']['VALUE']?>)<?endif;?>:</h2>

                <?if($PROP['RESPONS']['VALUE'] && is_array($PROP['RESPONS']['VALUE'])):?>
                <p class="duties">Обязанности:</p>
                <ul class="red">
                    <?foreach($PROP['RESPONS']['VALUE'] as $response):?>
                    <li><?=$response?></li>
                    <?endforeach;?>
                </ul>
                <?endif;?>

                <?if($PROP['DEMANDS']['VALUE'] && is_array($PROP['DEMANDS']['VALUE'])):?>
                    <p class="duties">Требования:</p>
                    <ul class="red">
                        <?foreach($PROP['DEMANDS']['VALUE'] as $response):?>
                            <li><?=$response?></li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>

                <?if($PROP['CONDITION']['VALUE'] && is_array($PROP['CONDITION']['VALUE'])):?>
                    <p class="duties">Условия:</p>
                    <ul class="red">
                        <?foreach($PROP['CONDITION']['VALUE'] as $response):?>
                            <li><?=$response?></li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>

                <?if($arItem['PREVIEW_TEXT']):?>
                    <?=$arItem['PREVIEW_TEXT'];?>
                <?endif;?>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>

