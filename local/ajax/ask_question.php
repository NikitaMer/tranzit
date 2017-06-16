<?require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');?>
<div class="theme-yellow">
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"ajax", 
	array(
		"START_PAGE" => "new",
		"SHOW_LIST_PAGE" => "N",
		"SHOW_EDIT_PAGE" => "N",
		"SHOW_VIEW_PAGE" => "Y",
		"SUCCESS_URL" => "Спасибо.<br>Ваш запрос принят.",
		"WEB_FORM_ID" => 2,
		"RESULT_ID" => $_REQUEST[RESULT_ID],
		"SHOW_ANSWER_VALUE" => "N",
		"SHOW_ADDITIONAL" => "N",
		"SHOW_STATUS" => "Y",
		"EDIT_ADDITIONAL" => "N",
		"EDIT_STATUS" => "Y",
		"NOT_SHOW_FILTER" => array(
			0 => "",
			1 => "",
		),
		"NOT_SHOW_TABLE" => array(
			0 => "",
			1 => "",
		),
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"SEF_FOLDER" => "/test/",
		"LIST_URL" => "ask_question_result.php",
		"EDIT_URL" => "",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>
</div>