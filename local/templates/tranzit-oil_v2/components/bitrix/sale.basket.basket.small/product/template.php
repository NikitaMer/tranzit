<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$c = $arResult['AMOUNT'] > 20 ? $arResult['AMOUNT'] - floor($arResult['AMOUNT'] / 10) * 10 : $arResult['AMOUNT'];

$text = '';

if($c == 1)
	$text =  'товар';
elseif($c > 1 && $c < 5)
	$text =  'товара';
elseif($c > 5)
	$text =  'товаров';

$CSiteController = SiteController::getEntity();

#echo '<pre>'.print_r($arResult, true).'</pre>';

?>
<div class="product-more-cart"<?if($arResult['AMOUNT'] == 0):?> style="display: none;"<?endif;?>>
	<div class="counter"><?=$arResult['AMOUNT'];?> <?=$text?> на сумму</div>
	<div class="price-block">
		<?=$CSiteController->getHtmlFormatedPrice("RUB", $arResult["TOTAL_PRICE"]["RUB"]);?>
	</div>

	<a class="button round <?if($arResult['AMOUNT'] == 0):?>white<?else:?>yellow<?endif;?> open_ajax" href="/local/ajax/buy_one_click.php" <?if($arResult['AMOUNT'] == 0):?>onclick="javascript:void(0);"<?endif;?>>Купить</a>
	<p class="info">Отметьте интересующие аксессуары и купите в один клик.</p>
</div>