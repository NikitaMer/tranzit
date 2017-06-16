<?require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');?>

<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "ajax_form", Array(
        "REGISTER_URL" => "/shop/personal/orders/?register=yes",	// Страница регистрации
        "FORGOT_PASSWORD_URL" => "/shop/personal/orders/?forgot_password=yes",	// Страница забытого пароля
        "PROFILE_URL" => "/shop/personal/",	// Страница профиля
        "SHOW_ERRORS" => "Y",	// Показывать ошибки
    ),
    false
);?>