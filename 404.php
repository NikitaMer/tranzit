<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
?>
<div class="page_404">
	<div class="road">
		<img src="<?=SITE_TEMPLATE_PATH?>/img/404.jpg">
	</div>
	<div class="page_404_bt">
		<div class="oops">
			<img src="<?=SITE_TEMPLATE_PATH?>/img/404_oops.png">
		</div>
		<div class="text">
			<a href="/">
				<img src="<?=SITE_TEMPLATE_PATH?>/img/404_text.png">
			</a>
		</div>
	</div>
</div>
<?
/*$APPLICATION->IncludeComponent(
	"bitrix:main.map", 
	".default", 
	array(
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"SET_TITLE" => "Y",
		"LEVEL" => "3",
		"COL_NUM" => "1",
		"SHOW_DESCRIPTION" => "Y"
	),
	false
);*/

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>