<?require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');?>

<?$APPLICATION->IncludeComponent("virtuoz:main.register", "ajax_form", Array(
	"USER_PROPERTY_NAME" => "", 
	 "SHOW_FIELDS" => Array("WORK_COMPANY","PROPERTY_UF_INN","PROPERTY_UF_CONTRAGENT","PROPERTY_UF_DOC_FILE"), 
	 "REQUIRED_FIELDS" => Array("PROPERTY_UF_CONTRAGENT"), 
    ),
    false
);?>
