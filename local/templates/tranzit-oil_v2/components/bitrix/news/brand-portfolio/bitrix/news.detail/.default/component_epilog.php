<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
#print_r($arResult);

$this->__template->SetViewTarget('h1_info');?>
	<span class="date"><?=$arResult['DATE_ACTIVE_FROM']?></span>
<?$this->__template->EndViewTarget();

#GLOBAL $APPLICATION;
#$APPLICATION->SetDirProperty("HIDE_LEFT_COLUMN", "Y1");
#$APPLICATION->SetPageProperty("HIDE_LEFT_COLUMN", "Y");
#echo ' 0='.$APPLICATION->GetPageProperty("HIDE_LEFT_COLUMN");