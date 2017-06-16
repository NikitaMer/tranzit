<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$count  = count($arResult);
$CSiteController = SiteController::getEntity();
# use construction for get formated price
#$CSiteController->getHtmlFormatedPrice($arItem["CURRENCY"], $arItem["PRICE"]);
?>

<?if (!empty($arResult)):?>
<div class="last-visited">
	<div class="title">Последние просмотренные<?//=GetMessage("VIEW_HEADER");?></div>

	<?if($count > 4):?>
	<a href="#" data-target="prev" class="nav-icon-white nav up custom"></a>
	<a href="#" data-target="next" class="nav-icon-white nav down custom"></a>
	<?endif?>

	<ul id="viewed_products">
	<?foreach($arResult as $arItem):?>
		<li>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=TruncateText($arItem["NAME"], 50);?></a>
			<?if($arItem["CAN_BUY"]=="Y"): ?>
			<div class="price-block"><?=$CSiteController->getHtmlFormatedPrice($arItem["CURRENCY"], $arItem["PRICE"]);?></div>
			<!-- <? //print_r($arItem); ?> -->
			<?endif;?>

		</li>
	<?endforeach;?>
	</ul>
</div>
<?endif;?>


<?if($count > 4):?>
<script>
	var total_count = <?=count($arResult);?>,
		total_list = total_count - 3;

	$(function(){

		var sudoSlider = $("#viewed_products").sudoSlider({
			speed: 300,
			pause: 3000,
			auto: false,
			prevNext: false,
			numeric: false,
			touch: false,
			continuous: false,
			startSlide: 1,
			slideCount: 4,
			customLink: '.custom',
			controlsFade: true,
			controlsFadeSpeed: '500',
			vertical:true,
			beforeAnimation: function(t){

				if(t == 1)
					$('.last-visited a[data-target=prev]').hide();
				else
					$('.last-visited a[data-target=prev]').show();

				if(t == total_list)
					$('.last-visited a[data-target=next]').hide();
				else
					$('.last-visited a[data-target=next]').show();

				},
			afterAnimation: function(t){

				}
			});
		});
</script>
<?endif?>