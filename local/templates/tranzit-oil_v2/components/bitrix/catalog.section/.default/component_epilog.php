<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;


?>

<? $APPLICATION->AddHeadString('<link href="https://www.'.SITE_SERVER_NAME.$arResult['SECTION_PAGE_URL'].'" rel="canonical" />',true);
?>