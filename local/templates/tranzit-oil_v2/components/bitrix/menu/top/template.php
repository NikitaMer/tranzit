<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):
$page = $APPLICATION->GetCurPage(false);
?>
<nav class="main-nav" id="site-top-menu">
    <?
    $frame = $this->createFrame("site-top-menu", false)->begin();
    ?>
    <ul class="layer1">
        <li><a href="/"><?if($page == '/'):?>Главная<?else:?><div class="return"></div>На главную страницу<?endif;?></a></li>
        <?
        $previousLevel = 0;
        foreach($arResult as $arItem):?>

            <?
            if($arItem["PERMISSION"] <= "D")
                continue;

            $target = strpos($arItem["LINK"], 'http://') === 0 ? ' target="_blank"' : '';
            ?>

            <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
            <?endif?>

            <?if ($arItem["DEPTH_LEVEL"] == 1):?>
            <li class="sep"></li>
            <?endif?>

            <?if ($arItem["IS_PARENT"]):?>

                <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                    <li class="parent<?if ($arItem["SELECTED"]):?> current<?endif?>">
                        <a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>current<?endif?>"<?=$target?>><?=$arItem["TEXT"]?></a>
                        <span class="menu-down"></span>
                        <ul>
                <?else:?>
                    <li<?if ($arItem["SELECTED"]):?> class="current"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                        <ul>
                <?endif?>

            <?elseif ($arItem["PERMISSION"] > "D"):?>
                <li<?if ($arItem["SELECTED"]):?> class="current"<?endif?>><a href="<?=$arItem["LINK"]?>"<?=$target?>><?=$arItem["TEXT"]?></a></li>
            <?endif?>

            <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

        <?endforeach?>

        <?if ($previousLevel > 1)://close last item tags?>
            <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
        <?endif?>

    </ul>
    <?
    $frame->beginStub();

    $frame->end();
    ?>
</nav>
<?endif?>