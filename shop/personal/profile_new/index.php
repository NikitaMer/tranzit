<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Профиль");
?>
<?if(CSite::InGroup (array(9))):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"company_user_profile", 
	array(
		"USER_PROPERTY_NAME" => "",
		"SET_TITLE" => "N",
		"AJAX_MODE" => "Y",
		"USER_PROPERTY" => array(
			0 => "UF_INN",
			1 => "UF_OPF",
			2 => "UF_ADR_UR",
			3 => "UF_ADR_POST",
			4 => "UF_ADR_FACT",
			5 => "UF_OGRN",
			6 => "UF_RUKOVODITEL",
			7 => "UF_REKV",
			8 => "UF_DOC_FILE",
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "company_user_profile"
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