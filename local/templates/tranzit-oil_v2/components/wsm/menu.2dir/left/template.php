<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="menu-left layers" id="site-left-menu2">
    <?
    $frame = $this->createFrame("site-left-menu2", false)->begin();
    ?>
    <?
    foreach($arResult as $arItem):?>

        <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
            <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
        <?endif?>

        <?if ($arItem["IS_PARENT"]):?>
        <li class="parent">
            <a class="parent<?if($arItem["SELECTED"]):?> selected<?endif;?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
            <ul>

        <?else:?>

            <?if ($arItem["PERMISSION"] > "D"):?>
                <li>
                    <a class="<?if($arItem["DEPTH_LEVEL"] == 1):?> firstLayer<?endif;?><?if($arItem["SELECTED"]):?> selected<?endif;?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
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