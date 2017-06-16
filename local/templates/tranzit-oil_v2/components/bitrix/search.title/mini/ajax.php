<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult["CATEGORIES"])):?>
	<ul class="title-search-result">
		<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>

			<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<li>
                <a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?>
			</li>
			<?endforeach;?>

		<?endforeach;?>
	</ul>
<?endif;
?>