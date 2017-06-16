<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

<ul class="menu-left" id="site-left-menu">
<?
$frame = $this->createFrame("site-left-menu", false)->begin();
?>
<?foreach($arResult as $arItem):?>

	<?if ($arItem["PERMISSION"] > "D"):?>
		<li class="layer<?=$arItem["DEPTH_LEVEL"]?>"><a<?if($arItem["SELECTED"]):?> class="selected"<?endif;?> href="<?=$arItem["LINK"]?>"><nobr><?=$arItem["TEXT"]?></nobr></a></li>
	<?endif?>

<?endforeach?>
    <?
    $frame->beginStub();

    $frame->end();
    ?>
</ul>
<?endif?>