<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");

#?confirm_registration=yes&confirm_user_id=23&confirm_code=crA5OVhi
#?change_password=yes&lang=ru&USER_CHECKWORD=#CHECKWORD#&USER_LOGIN=#URL_LOGIN#

/*if($GLOBALS['USER']->IsAuthorized())
	echo 'IsAuthorized';
else
	echo 'not IsAuthorized';*/

if(!isset($_REQUEST['confirm_registration']) && !isset($_REQUEST['change_password']))
{
	if(!isset($_GET['backurl']))
		LocalRedirect("/shop/personal/orders/");
	else
		LocalRedirect($_GET['backurl']);
}
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>