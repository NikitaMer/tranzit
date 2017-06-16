<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("review");
?><?$APPLICATION->IncludeComponent("bitrix:forum.topic.reviews", "reviews", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"FORUM_ID" => "1",	// ID форума для отзывов
		"IBLOCK_TYPE" => "catalog",	// Тип информационного блока (используется только для проверки)
		"IBLOCK_ID" => "73",	// Код информационного блока
		"ELEMENT_ID" => "1628",	// ID элемента
		"URL_TEMPLATES_READ" => "",	// Страница чтения темы форума
		"URL_TEMPLATES_DETAIL" => "",	// Страница элемента инфоблока
		"URL_TEMPLATES_PROFILE_VIEW" => "",	// Страница пользователя
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "0",	// Время кеширования (сек.)
		"MESSAGES_PER_PAGE" => "10",	// Количество сообщений на одной странице
		"PAGE_NAVIGATION_TEMPLATE" => "",	// Название шаблона для вывода постраничной навигации
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",	// Формат показа даты и времени
		"NAME_TEMPLATE" => "",	// Формат имени
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",	// Путь относительно корня сайта к папке со смайлами
		"EDITOR_CODE_DEFAULT" => "N",	// По умолчанию показывать невизуальный режим редактора
		"SHOW_AVATAR" => "Y",	// Показывать аватары пользователей
		"SHOW_RATING" => "",	// Включить рейтинг
		"RATING_TYPE" => "",	// Вид кнопок рейтинга
		"SHOW_MINIMIZED" => "N",	// Сворачивать форму добавления отзыва
		"USE_CAPTCHA" => "Y",	// Использовать CAPTCHA
		"PREORDER" => "Y",	// Выводить сообщения в прямом порядке
		"SHOW_LINK_TO_FORUM" => "N",	// Показать ссылку на форум
		"FILES_COUNT" => "2",	// Максимальное количество файлов, прикрепленных к одному сообщению
		"AJAX_POST" => "Y",	// Использовать AJAX в диалогах
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>