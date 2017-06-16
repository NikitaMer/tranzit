<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Профиль");
?>
<?if(CSite::InGroup (array(9))):?>


<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"simple1", 
	array(
		"USER_PROPERTY_NAME" => "",
		"SET_TITLE" => "N",
		"AJAX_MODE" => "Y",
		"USER_PROPERTY" => array(
			0 => "UF_OPF",
			1 => "UF_ADR_UR",
			2 => "UF_INN",
			3 => "UF_ADR_UR",
			4 => "UF_ADR_FACT",
			5 => "UF_ADR_POST",
			6 => "UF_OGRN",
			7 => "UF_REKV",
			8 => "UF_RUKOVODITEL",
			/*<!--by ko begin-->*/
			9 => "UF_DOC_FILE",
			/*<!--by ko end-->*/
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?> 
<?else:?>

	<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"simple", 
	array(
		"USER_PROPERTY_NAME" => "",
		"SET_TITLE" => "N",
		"AJAX_MODE" => "Y",
		"USER_PROPERTY" => array(
			0 => "UF_CAR_MARKA",
			1 => "UF_CAR_YEAR",
			2 => "UF_CAR_ENGINE",
			3 => "UF_CAR_POWER",
			4 => "UF_VIN",
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?> 
<?endif?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>