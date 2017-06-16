<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "вакансии транзит ойл");
$APPLICATION->SetPageProperty("description", "Раздел с вакансиями компании ООО \"Транзит Ойл\". Мы заинтересованы в привлечении профессиональных и талантливых специалистов.");
$APPLICATION->SetTitle("Вакансии");
?><p>
	 Компания «Транзит-Ойл» заинтересована в привлечении профессиональных и талантливых специалистов.
</p>
<p>
	 Если Вы хотите присоединиться к команде наших сотрудников, пожалуйста, заполните анкету кандидата и отправьте её нам на почту, с указанием желаемой должности, резюме будет рассмотрено в ближайшее время, и даже если в данный момент мы не будем готовы сделать Вам предложение, Ваше резюме останется в базе данных.
</p>
<p>
	<!--noindex--><a href="/upload/files/anketa_kandidata.doc">Анкета кандидата</a><!--/noindex--></p>
 <br>
 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"vacancy",
	Array(
		"ACTIVE_DATE_FORMAT" => "",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "16800",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "tranzit_oil",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"NEWS_COUNT" => "5",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"SALARY",1=>"RESPONS",2=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC"
	)
);?> Свое резюме или заполненную анкету кандидата необходимо отправить менеджерам отдела персонала, а также&nbsp;вы можете&nbsp;задать&nbsp;все интересующие вопросы по следующим контактным данным:<br>
 <br>
<table style="height: 80px;" width="600">
<tbody>
<tr>
	<td width="300" height="75" style="text-align: left;">
 <b>Руководитель&nbsp;отдела кадров<br>
 </b>Моисеев Дмитрий<br>
		 тел. 8 (843) 222-85-90<br>
		<!--noindex--><a href="mailto:e-mail: ok@tranzit-oil.ru" rel="nofollow"> e-mail: ok@tranzit-oil.ru</a><!--/noindex--></td>
	<td width="300" style="text-align: left;">
 <b>Менеджер отдела кадров<br>
 </b>Самотой Римма<br>
		 тел. 8 (843) 222-85-90<br>
 <a href="mailto:e-mail: hr@tranzit-oil.ru">e-mail: hr@tranzit-oil.ru</a> <br>
	</td>
</tr>
</tbody>
</table><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>