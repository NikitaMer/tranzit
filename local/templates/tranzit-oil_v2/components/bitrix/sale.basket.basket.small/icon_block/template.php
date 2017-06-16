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

?>
<!-- cart -->
<div class="block cart">
	<div class="ico"><span></span></div>
	<div class="desc">
		<a href="<?=$arParams["PATH_TO_BASKET"]?>" class="title">Корзина</a>
		<br>
		<?if($arResult['AMOUNT'] > 0):?> 
			<span><?=$arResult['AMOUNT'];?> шт.<?//=$text?> — <?=$arResult['TOTAL_PRICE_FORMATED']['RUB']?></span>
		<?else:?>
			<span>0 товаров</span>
		<?endif;?>
	</div>
</div>
<!-- end cart -->