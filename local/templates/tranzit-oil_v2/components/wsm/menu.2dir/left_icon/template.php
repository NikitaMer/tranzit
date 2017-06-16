<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="catalog-left-menu" id="site-left-icon-menu">
    <?
    $frame = $this->createFrame("site-left-icon-menu", false)->begin();
    ?>
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;

    $class = array_key_exists('class', $arItem['PARAMS']) ? $arItem['PARAMS']['class'] : '';
    $class .= $arItem["SELECTED"] ? ' selected' : '';
    $class = $class ? ' class="'.$class.'"' : '';
?>
    <li<?=$class?>>
        <!-- <?print_r($arItem);?> -->
        <div class="ico"></div>
        <span>
            <a href="<?=$arItem["LINK"]?>" class="selected"><?=$arItem["TEXT"]?></a>
        </span>
    </li>
<?endforeach?>
    <?
    $frame->beginStub();

    $frame->end();
    ?>
</ul>
<?endif?>