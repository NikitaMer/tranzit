<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="filter">


	<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter" id="smartfilter">
		<?foreach($arResult["HIDDEN"] as $arItem):?>
		<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
		<?endforeach;

		foreach($arResult["ITEMS"] as $key=>$arItem):

			$key = md5($key);

			if(isset($arItem["PRICE"])):
				if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
					continue;

				$arItem["NAME"] = 'Цена';
				?>
				<div class="filter-section price">
					<span class="title"><?=$arItem["NAME"]?></span>
					<div class="input-group">
						<input
							class="min-price"
							type="text"
							name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
							id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
							value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
							size="5"
							onkeyup="smartFilter.keyup(this)"
							/>
						<span>—</span>
						<input
							class="max-price"
							type="text"
							name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
							id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
							value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
							size="5"
							onkeyup="smartFilter.keyup(this)"
							/>
						<span class="currency">руб.</span>
					</div>

					<div class="slider-line">
						<div class="pos">
							<div id="curMinPrice_<?=$key?>"><?
								if (isset($arItem["VALUES"]["MIN"]["CURRENCY"]))
									echo CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"], $arItem["VALUES"]["MIN"]["CURRENCY"], false);
								else
									echo $arItem["VALUES"]["MIN"]["VALUE"];
								?></div>
							<div id="curMaxPrice_<?=$key?>"><?
								if (isset($arItem["VALUES"]["MAX"]["CURRENCY"]))
									echo CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
								else
									echo $arItem["VALUES"]["MAX"]["VALUE"];
								?></div>
						</div>

						<div class="line" id="drag_track_<?=$key?>">
							<div class="percent" id="drag_tracker_<?=$key?>" style="left: 0; right: 0%;"></div>
							<div class="pol left" id="left_slider_<?=$key?>"></div>
							<div class="pol right" id="right_slider_<?=$key?>"></div>
						</div>

					</div>

				</div>

				<?
				$arJsParams = array(
					"leftSlider" => 'left_slider_'.$key,
					"rightSlider" => 'right_slider_'.$key,
					"tracker" => "drag_tracker_".$key,
					"trackerWrap" => "drag_track_".$key,
					"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
					"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
					"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
					"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
					"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
					"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
					"precision" => 0
				);
				?>
				<script type="text/javascript">
					BX.ready(function(){
						var trackBar<?=$key?> = new BX.Iblock.SmartFilter.Vertical(<?=CUtil::PhpToJSObject($arJsParams)?>);
					});
				</script>
			<?endif;
		endforeach;

		foreach($arResult["ITEMS"] as $key=>$arItem):

			if($arItem["PROPERTY_TYPE"] == "N" ):
				if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
					continue;
				?>
				<div class="filter-section price">
					<span class="title"><?=$arItem["NAME"]?></span>
					<div class="input-group">

						<input
							class="min-price"
							type="text"
							name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
							id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
							value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
							size="5"
							onkeyup="smartFilter.keyup(this)"
						/>
						<span>—</span>

						<input
							class="max-price"
							type="text"
							name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
							id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
							value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
							size="5"
							onkeyup="smartFilter.keyup(this)"
						/>
						<span class="currency">руб.</span>
					</div>

					<div class="slider-line">
						<div class="pos">
							<div id="curMinPrice_<?=$key?>"><?
								if (isset($arItem["VALUES"]["MIN"]["CURRENCY"]))
									echo CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"], $arItem["VALUES"]["MIN"]["CURRENCY"], false);
								else
									echo $arItem["VALUES"]["MIN"]["VALUE"];
								?></div>
							<div id="curMaxPrice_<?=$key?>"><?
								if (isset($arItem["VALUES"]["MAX"]["CURRENCY"]))
									echo CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
								else
									echo $arItem["VALUES"]["MAX"]["VALUE"];
								?></div>
						</div>

						<div class="line" id="drag_track_<?=$key?>">
							<div class="percent" id="drag_tracker_<?=$key?>" style="left: 0; right: 0%;"></div>
							<div class="pol left" id="left_slider_<?=$key?>"></div>
							<div class="pol right" id="right_slider_<?=$key?>"></div>
						</div>

					</div>

				</div>
				<?
				$arJsParams = array(
					"leftSlider" => 'left_slider_'.$key,
					"rightSlider" => 'right_slider_'.$key,
					"tracker" => "drag_tracker_".$key,
					"trackerWrap" => "drag_track_".$key,
					"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
					"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
					"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
					"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
					"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
					"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
					"precision" => 0
				);
				?>
				<script type="text/javascript">
					BX.ready(function(){
						var trackBar<?=$key?> = new BX.Iblock.SmartFilter.Vertical(<?=CUtil::PhpToJSObject($arJsParams)?>);
					});
				</script>

			<?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>

				<?$count = 0;?>
				<div class="filter-section">
					<span class="title" onclick="smartFilter.hideFilterProps(this)"><?=$arItem["NAME"]?></span>
					<ul>
						<?foreach($arItem["VALUES"] as $val => $ar):?>
						<?$count++;?>
						<li class="<?echo $ar["DISABLED"] ? 'disabled': ''?><?if(!$ar["CHECKED"] && $count > 6) echo ' hidden';?>">
							<label for="<?echo $ar["CONTROL_ID"]?>">
							<input
								type="checkbox"
								value="<?echo $ar["HTML_VALUE"]?>"
								name="<?echo $ar["CONTROL_NAME"]?>"
								id="<?echo $ar["CONTROL_ID"]?>"
								<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
								onclick="smartFilter.click(this)"
								/><?echo $ar["VALUE"];?>
								<span><?//=$ar['COUNT']?></span>
							</label>
						</li>
						<?endforeach;?>
					</ul>
					<?if($count > 6):?>
					<a class="more" href="#">показать еще</a>
					<?endif;?>
				</div>

			<?endif;
		endforeach;?>

		<?/*
		<a href="#" class="button more-param">Дополнительные параметры</a>
		*/?>

		<div class="button-group">
			<button class="yellow" type="submit" id="set_filter" name="set_filter"><?=GetMessage("CT_BCSF_SET_FILTER")?></button>
			<a href="#" class="clear"><?=GetMessage("CT_BCSF_DEL_FILTER")?></a>

		</div>


		<input class="bx_filter_search_button" type="hidden" id="del_filter" name="del_filter1" value="<?//=GetMessage("CT_BCSF_DEL_FILTER")?>" />


		<div class="bx_filter_popup_result left" id="modef1" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
			<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
			<span class="arrow"></span>
			<a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
		</div>

	</form>

</div>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');

	$('.filter-section .more').click(function(){
		var parent = $(this).parents('.filter-section');
		$(this).hide();
		parent.find('li').show();
		return false;
		});

	$('#smartfilter a.clear').click(function(){
		$('#del_filter').val('Y');
		$('#del_filter').attr('name', 'del_filter');
		$('#smartfilter').submit();
		return false;
	});

</script>