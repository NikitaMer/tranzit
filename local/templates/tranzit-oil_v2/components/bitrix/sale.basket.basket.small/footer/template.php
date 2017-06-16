<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="sep link cart">
    <div class="ballon cart"><div class="text_data">Добавлено</div></div>
	<div class="link<?if($arResult['AMOUNT'] > 0):?> active<?endif;?>">
		<a class="icon  icon16 cart" href="<?=$arParams["PATH_TO_BASKET"]?>">Корзина</a>
		<div class="counter"><?=$arResult['AMOUNT'];?></div>
	</div>

	<?/*if ($arResult["READY"]=="Y" && strlen($arParams["PATH_TO_ORDER"]) > 0):?>
		<a class="button yellow" rel="nofollow" href="<?= $arParams["PATH_TO_ORDER"] ?>">Оформить заказ</a>
	<?else:?>
		<a class="button" onClick="javascript: void(0);" class="yellow">Оформить заказ</a>
	<?endif;*/?>
</div>