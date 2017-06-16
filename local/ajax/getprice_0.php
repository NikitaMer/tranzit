<?require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');?>

<?$APPLICATION->IncludeComponent(
    "bitrix:form",
    "get_price",
    Array(
        "START_PAGE" => "new",
        "SHOW_LIST_PAGE" => "N",
        "SHOW_EDIT_PAGE" => "N",
        "SHOW_VIEW_PAGE" => "Y",
        "SUCCESS_URL" => "",
        "WEB_FORM_ID" => "1",
        "RESULT_ID" => $_REQUEST[RESULT_ID],
        "SHOW_ANSWER_VALUE" => "N",
        "SHOW_ADDITIONAL" => "N",
        "SHOW_STATUS" => "Y",
        "EDIT_ADDITIONAL" => "N",
        "EDIT_STATUS" => "Y",
        "NOT_SHOW_FILTER" => array(0=>"",1=>"",),
        "NOT_SHOW_TABLE" => array(0=>"",1=>"",),
        "IGNORE_CUSTOM_TEMPLATE" => "N",
        "USE_EXTENDED_ERRORS" => "Y",
        "SEF_MODE" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CHAIN_ITEM_TEXT" => "",
        "CHAIN_ITEM_LINK" => "",
        "AJAX_OPTION_ADDITIONAL" => "",
        "SEF_URL_TEMPLATES" => array("new"=>"#WEB_FORM_ID#/","list"=>"#WEB_FORM_ID#/list/","edit"=>"#WEB_FORM_ID#/edit/#RESULT_ID#/","view"=>"#WEB_FORM_ID#/view/#RESULT_ID#/",)
        )
    );?>
