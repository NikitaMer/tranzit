<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult["DIFFERENT"])
	LocalRedirect(htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=N",array("DIFFERENT"))));

$CSiteController = SiteController::getEntity();

?>

<div class="columns">
	<div class="col main_left">

		<div class="compare-control" id="compare_title_block">

			<?/*
			<span class="title">Категории товаров</span>
			<form action="" method="POST" id="COMPARE_CATEGORY_SELECTOR">
				<input type="hidden" name="remove" value="" />
				<input type="hidden" name="send" value="Y" />

				<select style=" width: 210px; " name="CATEGORY" class="box">
					<?foreach($arResult['SECTIONS'] as $id => $sec):?>
						<option value="<?=$id?>" <?if($id == $arResult['SEL_CATEGORY']):?>selected<?endif;?>><?=$sec?></option>
					<?endforeach;?>
				</select>
			</form>

			<script>
				$(document).ready(function(){

					$("select[name='CATEGORY']").bind('change', function(){
						$(this).parents('form').submit();
						});

					$("a.removeCategory").bind('click', function(){
						if(confirm('Вы действительно хотите удалить категорию?')){
							$('#COMPARE_CATEGORY_SELECTOR').find("input[name='remove']").val('Y');
							$('#COMPARE_CATEGORY_SELECTOR').submit();
							return false;
						}
					});
				});
			</script>

			<noindex>
			<div class="actions">
				<a href="#" class="icon icon16 remove removeCategory">Удалить список</a>
			</div>
			</noindex>
			*/?>
			
			<noindex>
			<div class="radio-block">
				<input id="butt1" type="radio" name="different" value="all" checked><span></span><label for="butt1">Все параметры</label>
			</div>

			<div class="radio-block">
				<input id="butt2" type="radio" name="different" value="different"><span></span><label for="butt2">Различающиеся</label>
			</div>
			</noindex>
			
			<script>
				$(document).ready(function(){
					$("input[name='different']").bind('change', function(){
                        var val = $(this).val();
						console.log(val);

                        if(val == 'different'){
                            $('.left-title.equal').hide();
                            $('.block.property.equal').hide();
                        }
                        else{
                            $('.left-title').show();
                            $('.block.property').show();
                        }

						});
					});
			</script>

		</div>

	</div>


	<div class="col main_right"<?if(count($arResult["ITEMS"]) > 3):?> style="overflow-x:auto;"<?endif;?>>

		<div class="div-table compare-list">
			<div class="div-tr">
			<?foreach($arResult["ITEMS"] as $arElement):?>
				<?
				$pict = null;
				$img  = null;


				if(is_array($arElement["DETAIL_PICTURE"]))
					$pict = $arElement["DETAIL_PICTURE"]['ID'];

				if(!$pict && is_array($arElement["PREVIEW_PICTURE"]))
					$pict = $arElement["PREVIEW_PICTURE"]['ID'];

				$img = CFile::ResizeImageGet($pict, array('width'=>112, 'height'=>112), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				?>
				<div class="block element_item element_<?=$arElement['ID']?>">
					<div class="tovar">
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="image">
							<?if($img):?>
							<img src="<?=$img['src']?>"/>
							<?endif;?>
						</a>
						<a class="name"  href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=TruncateText($arElement['NAME'], 40)?></a>
						<?if(count($arElement["PRICES"])>1):
						
						?>
							<div class="price-block">
								<?=$CSiteController->getHtmlFormatedPrice($arElement["PRICES"]['3.Оптовые Спец.Цена']["CURRENCY"], $arElement["PRICES"]['3.Оптовые Спец.Цена']["DISCOUNT_VALUE"]);?>
                             </div>
						<?else:?>
							<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
								<?if($arPrice["CAN_ACCESS"] && $arPrice):?>
									<div class="price-block">
									<?=$CSiteController->getHtmlFormatedPrice($arPrice["CURRENCY"], $arPrice["DISCOUNT_VALUE"]);?>
									</div>
								<?endif;?>
							<?endforeach;?>
						<?endif?>
						<div class="block_1">

							
<?
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

$ar_res = CCatalogProduct::GetByID($arElement[ID]);							
	?>							
		
								
								<? if ($ar_res[QUANTITY]>0) { ?>
								<a  style="background:#99CC33;border: 1px solid #99CC33;"  class="buy button yellow" data-action="add2basket" href="<?=$arElement['ADD_URL']; ?>" rel="nofollow">Купить</a>
                                                            <? } else {?>
<a class="buy button yellow" data-action="add2basket" href="<?=$arElement['ADD_URL']; ?>" rel="nofollow">Заказать</a>
<? } ?>
								
								

								
							

							<a href="#" class="icon icon16 favorite add2favorite notext" data-acrion="add2favorite" data-id="<?=$arElement['ID']?>"></a>
						</div>

						<div class="block_2">
							<a href="#" class="icon icon16 remove" data-action="add2compare" data-id="<?=$arElement['ID']?>">Удалить</a>

							<a href="#" class="nav next"><span>→</span></a>
							<a href="#" class="nav prev"><span>←</span></a>
						</div>
					</div>
				</div>
				<?endforeach;?>
			</div>


			<div class="div-tr section">
				<?$count = 0;?>
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<div class="block element_<?=$arElement['ID']?>">
						<?if($count == 0):?><div class="left-title sect">Общая информация</div><?endif;?>
					</div>
					<?$count++;?>
				<?endforeach;?>
			</div>


			<?foreach($arResult["SHOW_PROPERTIES"] as $code=>$arProperty):?>

				<?
				$diff = !$arResult['DIF_PROP'][$code];
				?>
				<?$count = 0;?>
				<div class="div-tr">
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<div class="block property<?if(!$diff):?> equal<?endif;?> element_<?=$arElement['ID']?>">
						<?if($count == 0):?><div class="left-title<?if(!$diff):?> equal<?endif;?>"><?=$arElement["DISPLAY_PROPERTIES"][$code]["NAME"]?></div><?endif;?>
						<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
					</div>
					<?$count++;?>
				<?endforeach?>
				</div>
			<?endforeach;?>


			<?#if($arResult['SHOW_DESC']):?>
			<div class="div-tr">
				<div class="left-title">Описание</div>
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<div class="block element_<?=$arElement['ID']?>">
						<?if($count = 0):?><?endif;?>
						<?=TruncateText($arElement['DETAIL_TEXT'], 250);?>
					</div>
				<?endforeach;?>
			</div>
			<?#endif;?>


		</div>

	</div>
</div>
