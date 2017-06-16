<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->AddHeadScript($templateFolder."/script.js");

$arUrls = Array(
	"delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
	);


$CSiteController = SiteController::getEntity();

if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	?>
	<div class="columns cart">
        <div class="col main_left">
		<?if($arResult["ADDITIONAL_PRODUCTS"]):?>
            <span class="section_title">Доп. товары</span>
            <ul class="cart-doptovar">
				<?foreach($arResult["ADDITIONAL_PRODUCTS"] as $product):?>
                <li data-id="<?=$product['ID']?>">
                    <a href="<?=$product['DETAIL_PAGE_URL']?>" class="image" style="background-image: url(<?=$product['PICTURE']['src']?>);"></a>
                    <a href="<?=$product['DETAIL_PAGE_URL']?>" class="catalog-name"><?=TruncateText($product['NAME'], 30);?></a>
                    <div class="price-block"><?=$CSiteController->getHtmlFormatedPrice($product["PRICE"]["CURRENCY"], $product["DISCOUNT_PRICE"]);?></div>
                    <a class="button yellow round" data-action="add2basket" href="<?=$product['DETAIL_PAGE_URL']?>?action=ADD2BASKET&amp;id=<?=$product['ID']?>">В корзину</a>
                </li>
				<?endforeach;?>
            </ul>
		<?endif;?>
        </div>

        <div class="col main_right">
            
			<h1><?$APPLICATION->ShowTitle(false)?></h1>

			<div id="warning_message">
				<?
				if (is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
				{
					foreach ($arResult["WARNING_MESSAGE"] as $v)
						echo ShowError($v);
				}
				?>
			</div>

			<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" class="cart-list2" id="basket_form">
				<div id="basket_form_container">
					<?
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
					?>
				</div>




				<div id="basket_form_container">
					<?
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items2.php");
					?>
				</div>



<a href="javascript:void(0)" class="button yellow round order" onclick="checkOut();">Оформить покупку</a>

				<input type="hidden" name="BasketOrder" value="BasketOrder" />
				<!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
			</form>



        </div>
    </div>

	<?
}
else
{
	ShowError($arResult["ERROR_MESSAGE"]);
}
?>
<script>
	var cart_ajax_path = '<?=$templateFolder?>/ajax.php';
</script>