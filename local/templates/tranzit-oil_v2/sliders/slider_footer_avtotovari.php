<?php
/**
 * Created by PhpStorm.
 * User: domackii
 * Date: 21.11.2014
 * Time: 23:27
 */
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"footer_slider", 
	array(
		"IBLOCK_TYPE" => "tranzit_oil",
		"IBLOCK_ID" => "14",
		"NEWS_COUNT" => "200",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "SITE",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "/okompanii/klinenty/#ELEMENT_CODE#/",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>

<?/*
<div class="partner" id="partner-slider">
    <ul>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/arbakam.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/elecon.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/pozis.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/tatvtorchermet.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/pco_kazan.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/nignekamskneftehim.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/estel.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/rusbiznesauto.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/akos.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/kanavto.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/lukoil.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span><img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/tatneft.png"/></span>
            </div>
        </li>
        <li>
            <div>
                <span>
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/slide_clients/megastroi.png"/></span>
            </div>
        </li>
    </ul>
</div>*/?>