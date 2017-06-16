<span class="section_title">Подразделы</span>

<?$APPLICATION->IncludeComponent(
    "wsm:menu.2dir",
    "left",
    array(
        "MENU_DIR" => "/okompanii/",
        "ROOT_MENU_TYPE" => "left",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "N",
        "MENU_CACHE_GET_VARS" => array(
        ),
        "MAX_LEVEL" => "3",
        "CHILD_MENU_TYPE" => "left",
        "USE_EXT" => "N",
        "DELAY" => "Y",
        "ALLOW_MULTI_SELECT" => "N"
    ),
    false
);?>

<?/*$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"left",
	Array(
		"ROOT_MENU_TYPE" => "left",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => "",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	)
);*/?>