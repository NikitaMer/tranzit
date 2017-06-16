<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

    <ul class="menu-left" id="site-left-menu">
    <?
    $frame = $this->createFrame("site-left-menu", false)->begin();
    $previousLevel = 0;

    foreach($arResult as $arItem):
    ?>
        <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
            <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
        <?endif?>

        <?/*if($arItem["CHILD_SELECTED"] !== true):?> class="close"<?endif*/?>

        <?if ($arItem["IS_PARENT"]):?>
            <li>
                <a<?if($arItem["SELECTED"]):?> class="selected"<?endif;?> href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                <!-- <?print_r($arItem)?>-->
                <ul>

        <?else:?>

            <?if ($arItem["PERMISSION"] > "D"):?>
                    <li>
                        <a<?if($arItem["SELECTED"]):?> class="selected"<?endif;?> href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                        <!-- <?print_r($arItem)?>-->
                    </li>
            <?endif?>

        <?endif?>

        <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

    <?endforeach?>

    <?if ($previousLevel > 1)://close last item tags?>
        <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
    <?endif?>

    <?
    $frame->beginStub();

    $frame->end();
    ?>
    </ul>
<?endif?>