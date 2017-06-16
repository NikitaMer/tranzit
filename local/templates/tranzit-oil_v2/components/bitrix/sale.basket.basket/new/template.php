<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arUrls = Array(
	"delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
	);
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>
<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
	?>
	<div id="warning_message">
		<?
		if (is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
		{
			foreach ($arResult["WARNING_MESSAGE"] as $v)
				echo ShowError($v);
		}
		?>
	</div>
	<?

	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$normalHidden = ($normalCount == 0) ? "style=\"display:none\"" : "";

	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayHidden = ($delayCount == 0) ? "style=\"display:none\"" : "";

	$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
	$subscribeHidden = ($subscribeCount == 0) ? "style=\"display:none\"" : "";

	$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
	$naHidden = ($naCount == 0) ? "style=\"display:none\"" : "";

	?>
	<div class="columns cart">
        <div class="col main_left">

            <span class="section_title">Доп. товары</span>

            <ul class="cart-doptovar">
                <li>
                    <a href="" class="image"></a>
                    <a href="" class="catalog-name">Масло моторное Форд 5w40 синтетическое.</a>
                    <div class="price-block">6700<span>руб</span></div>
                    <button class="yellow round" type="submit">В корзину</button>
                </li>
                <li>
                    <a href="" class="image"></a>
                    <a href="" class="catalog-name">Масло моторное Форд 5w40 синтетическое.</a>
                    <div class="price-block">6700<span>руб</span></div>
                    <button class="yellow round" type="submit">В корзину</button>
                </li>
            </ul>

        </div>

        <div class="col main_right">
            
			<h1><?$APPLICATION->ShowTitle(false)?></h1>
			
			<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" class="cart-list2" id="basket_form">
				<div id="basket_form_container">
					<?
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
					//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delayed.php");
					//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_subscribed.php");
					//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_not_available.php");
					?>
				</div>
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