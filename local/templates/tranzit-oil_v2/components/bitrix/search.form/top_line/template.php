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

$path = $GLOBALS['APPLICATION']->GetCurPage(false);
$is_shop_main = $path == '/shop/';
?>
<!-- search line -->
<section class="main_search_line catalog<?=!$is_shop_main?' white':''?>">
	<div class="wrapper center-block">
		<form action="<?=$arResult["FORM_ACTION"]?>" type="get">
			<div class="button">Каталог товаров<span></span>

				<div class="menu">
					<ul>
						<?foreach($arResult['CATALOG'] as $section):?>
						<li><a href="<?=$section['URL']?>"><?=$section['NAME']?></a></li>
						<?endforeach;?>
					</ul>
				</div>

			</div>

			<div class="input">
				<?if($arParams["USE_SUGGEST"] === "Y"):?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:search.suggest.input",
						"",
						array(
							"NAME" => "q",
							"VALUE" => "",
							"INPUT_SIZE" => 15,
							"DROPDOWN_SIZE" => 10,
						),
						$component, array("HIDE_ICONS" => "Y")
					);?>
				<?else:?>
					<input type="text" name="q" value="<?=htmlspecialchars($_GET['q'])?>" placeholder="Введите название товара" maxlength="50">
				<?endif;?>
			</div>

			<div class="button-block">
				<button type="submit" name="s" value="Y"><?//=GetMessage("BSF_T_SEARCH_BUTTON");?></button>
			</div>
		</form>
	</div>
</section>
<!-- end search line -->


<?/*
<section class="main_search_line">
	<div class="wrapper center-block">
		<form action="" type="get">
			<label>Поиск по каталогу:</label>
			<input type="text" name="q" value="" placeholder="Введите номер детали, Vin, Марку или модель автомобиля">
			<div class="button-block">
				<button type="submit" name="search" value="Y"></button>
			</div>
		</form>
	</div>
</section>

<section class="main_search_line catalog">
	<div class="wrapper center-block">
		<form action="" type="get">
			<div class="button">Каталог товаров<span></span>
				<div class="menu">
				<ul>
					<li><a href="/catalog/">Масла</a></li>
					<li><a href="/catalog/">Запчасти</a></li>
					<li><a href="/catalog/">Автохимия</a></li>
					<li><a href="/catalog/">Запчати</a></li>
					<li><a href="/catalog/">Автошины</a></li>
				</ul>
				</div>
			</div>

			<div class="input">
				<input type="text" name="q" value="" placeholder="Введите номер детали, Vin, Марку или модель автомобиля">
			</div>
			<div class="button-block">
				<button type="submit" name="search" value="Y"></button>
			</div>
		</form>
	</div>
</section>
*/?>