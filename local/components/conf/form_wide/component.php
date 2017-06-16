<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

global $aURI;

$aOptions = Array();
$q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER"));
while ($a = $q->GetNext()) {
    $aOptions[$a["NAME"]][$a["PROPERTY_MODEL_VALUE"]][$a["PROPERTY_YEAR_VALUE"]][$a["PROPERTY_VOLUME_VALUE"]][$a["PROPERTY_POWER_VALUE"]] = $a["PROPERTY_POWER_VALUE"];
}

/*foreach ($aOptions[$_GET["m1"]][$_GET["m2"]][$_GET["m3"]][$_GET["m4"]] as $key=>$value) {
  pre($key);
  pre($value);
}*/

$section = 0;
if ($aURI[2] && !$aURI[3]) {
  $q = CIBlockSection::GetList(Array(), Array("IBLOCK_ID"=>73, "CODE"=>$aURI[2]));
  if ($a = $q->GetNext()) {
    $section = $a["ID"];
  }
}
if ($aURI[3]) {
  $q = CIBlockSection::GetList(Array(), Array("IBLOCK_ID"=>73, "CODE"=>$aURI[3]));
  if ($a = $q->GetNext()) {
    $section = $a["ID"];
  }
}
?>

<div class="conf_form_wide">
    <div class="conf_form_title">Подобрать по автомобилю</div>
    <form action="<?=$APPLICATION->GetCurDir();?>" method="GET">
    <input type="hidden" name="section" value="<?=$section?>" />
      <div class="conf_form_body">
          <div class="conf_form_select">
              <select class="select" name="m1">
                  <option value="Марка">Марка</option>
                  <? foreach ($aOptions as $k=>$v) { ?>
                    <option value="<?=$k?>" <?=$_GET["m1"]==$k?"selected":"";?>><?=$k?></option>
                  <? } ?>
              </select>
          </div>
          <div class="conf_form_select">
              <select class="select" name="m2">
                  <option>Модель</option>
                  <?
                  if ($_GET["m1"]) {
                    foreach ($aOptions[$_GET["m1"]] as $key=>$value) {
                      ?>
                      <option value="<?=$key?>" <?=$_GET["m2"]==$key?"selected":"";?>><?=$key?></option>
                      <?
                    }
                  }
                  ?>
              </select>
          </div>
          <div class="conf_form_select">
              <select class="select" name="m3">
                  <option>Год выпуска</option>
                  <?
                  if ($_GET["m2"]) {
                    foreach ($aOptions[$_GET["m1"]][$_GET["m2"]] as $key=>$value) {
                      ?>
                      <option value="<?=$key?>" <?=$_GET["m3"]==$key?"selected":"";?>><?=$key?></option>
                      <?
                    }
                  }
                  ?>
              </select>
          </div>
          <div class="conf_form_select">
              <select class="select" name="m4">
                  <option>Объем</option>
                  <?
                  if ($_GET["m3"]) {
                    foreach ($aOptions[$_GET["m1"]][$_GET["m2"]][$_GET["m3"]] as $key=>$value) {
                      ?>
                      <option value="<?=$key?>" <?=$_GET["m4"]==$key?"selected":"";?>><?=$key?></option>
                      <?
                    }
                  }
                  ?>
              </select>
          </div>
          <div class="conf_form_select">
              <select class="select" name="m5">
                  <option>Мощность</option>
                  <?
                  if ($_GET["m4"]) {
                    foreach ($aOptions[$_GET["m1"]][$_GET["m2"]][$_GET["m3"]][$_GET["m4"]] as $key=>$value) {
                      ?>
                      <option value="<?=$key?>" <?=$_GET["m5"]==$key?"selected":"";?>><?=$key?></option>
                      <?
                    }
                  }
                  ?>
              </select>
          </div>
      </div>
    </form>
    <? if ($_GET["m1"]&&$_GET["m2"]&&$_GET["m3"]&&$_GET["m4"]&&$_GET["m5"]) { ?>
    <a href="#save_form" class="result_save_button fancybox">Сохранить</a>
    <? } ?>
</div>

<div style="display:none;">
	<div id="success_save">
		<h2>Данные подбора сохранены в Вашем личном кабинете</h2>
		<a href="/shop/personal/podbor/">Личный кабинет</a>
		<a href="#">Продолжить покупки</a>
	</div>
</div>

<? if ($_GET["m1"]&&$_GET["m2"]&&$_GET["m3"]&&$_GET["m4"]&&$_GET["m5"]) { ?>

<?
$q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "NAME"=>$_GET["m1"], "PROPERTY_MODEL"=>$_GET["m2"], "PROPERTY_YEAR"=>$_GET["m3"], "PROPERTY_VOLUME"=>$_GET["m4"], "PROPERTY_POWER"=>$_GET["m5"], "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER", "PREVIEW_TEXT"));
  $aArticul = Array();
  if ($a = $q->GetNext()) {
    ?><input type="hidden" name="id" value="<?=$a["ID"]?>"><?
    $aArticul = explode(",", $a["PREVIEW_TEXT"]);
  }
  foreach ($aArticul as $k=>$v) {
    $aArticul[$k] = trim($v);
  }
  $aProducts = Array();
  $aParents = Array();
  $q = CIBlockElement::GetList(Array("PROPERTY_CSORT"=>"DESC"), Array("IBLOCK_ID"=>73, "=PROPERTY_CML2_ARTICLE"=>$aArticul, "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "IBLOCK_SECTION_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "DETAIL_PAGE_URL", "PREVIEW_TEXT", "CATALOG_GROUP_2", "PROPERTY_CML2_ARTICLE"));
    while ($a = $q->GetNext()) {

      $q_s = CIBlockSection::GetByID($a["IBLOCK_SECTION_ID"]);
      $a_s = $q_s->GetNext();

      $target_section = $a["IBLOCK_SECTION_ID"]; 
      if ($a_s["DEPTH_LEVEL"] == 3) {
        $target_section = $a_s["IBLOCK_SECTION_ID"]; 
      }

      $aLevel2 = Array(270, 305, 381, 319, 269);
      if (in_array($target_section, $aLevel2)) {

        $q_section = CIBlockSection::GetByID($target_section);
        if ($a_section = $q_section->GetNext()) {
          $aParents[$a_section["ID"]] = $a_section;
          $aProducts[$a_section["ID"]][] = $a;
        }

      } else {

        $q_nav = CIBlockSection::GetNavChain(73, $a["IBLOCK_SECTION_ID"]);
        while ($a_nav = $q_nav->GetNext()) {
          if ($a_nav["ID"] == 270 || $a_nav["ID"] == 305 || $a_nav["ID"] == 381 || $a_nav["ID"] == 319) {
              $aParents[$a_nav["ID"]] = $a_nav;
              $aProducts[$a_nav["ID"]][] = $a;
          } else {
            if ($a_nav["DEPTH_LEVEL"] == 1 && $a_nav["ACTIVE"] == "Y") {
              $aParents[$a_nav["ID"]] = $a_nav;
              $aProducts[$a_nav["ID"]][] = $a;
            }
          }
        }
        
      }

    }

  if ($_GET["section"] > 0) {
    if (is_array($aParents[$_GET["section"]])) {
      $aTMP = $aParents[$_GET["section"]];
      unset($aParents[$_GET["section"]]);
      $aParents = array_merge(Array($_GET["section"]=>$aTMP), $aParents);
    }
  }

  if ($q->SelectedRowsCount()) {

    echo '<div class="options-line options-2">
        <div class="expand-all">Развернуть все</div>
        <div class="collapse-all">Свернуть все</div>
      </div><div class="conf-result">';

      $aCustomSection = Array(269, 270, 166, 305, 168, 169, 319, 323, 170, 381);

    foreach ($aCustomSection as $section) {
    foreach ($aParents as $aGroup) {

    	if ($section != $aGroup["ID"]) {
    		continue;
    	}

      $active = false;
      if ($_GET["section"] == $aGroup["ID"]) {
        $active = " active";
      }
      if ($_GET["section"] == 128 && ($aGroup["ID"] == 269 || $aGroup["ID"] == 270)) {
      	$active = " active";
      }

      ?>

      <div class="group-switch" style="background-image:url(<?=CFile::GetPath($aGroup["DETAIL_PICTURE"])?>);">
        <div class="group-switch-toggle<?=$active?>"></div>
        <div class="group-switch-title"><?=$aGroup["NAME"]?></div>
      </div>

      <ul class="catalog-element-list" style="display:<?=$active?"block":"none";?>;">
      <?
      foreach ($aProducts[$aGroup["ID"]] as $arItem) {

        $pict = null;

        if($arItem['DETAIL_PICTURE'])
          $pict = $arItem['DETAIL_PICTURE'];

        if($arItem['PREVIEW_PICTURE'])
          $pict = $arItem['PREVIEW_PICTURE'];

        $img = CFile::ResizeImageGet($pict, array('width'=>103, 'height'=>103), BX_RESIZE_IMAGE_PROPORTIONAL, true);

        $productTitle = $arItem["PROPERTY_ELEMENT_PAGE_TITLE_VALUE"];
        if (!$productTitle) {
          $productTitle = $arItem["NAME"];
        }

        $prev_text_len = 95;
        if(strlen($arItem['NAME']) > 45)
          $prev_text_len = 45;

      ?>

      <li>
        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="image" style="background-image: url(<?=$img['src']; ?>);"></a>
        <div class="desc">
          <div class="line1">
            
            <div class="left-block">
              <a href="<?=$arItem['DETAIL_PAGE_URL']; ?>" class="name" title="<? echo $productTitle; ?>"><?=TruncateText($productTitle, 95);?></a>
              <?if($arItem['PREVIEW_TEXT']):?>
              <div class="info"><?=TruncateText(HTMLToTxt($arItem['PREVIEW_TEXT']), $prev_text_len);?></div>
              <?endif;?>
            </div>
            
            <div class="right-block">
              <div class="price-block"><?=number_format($arItem["CATALOG_PRICE_2"], 0, "", " ")?><span>руб.</span></div>
              <? if ($arItem["CATALOG_QUANTITY"] >= 10) { ?>
              	<div class="availability"><span>В наличии</span></div>
              <? } elseif ($arItem["CATALOG_QUANTITY"] < 10 && $arItem["CATALOG_QUANTITY"] > 0) { ?>
              	<div class="availability"><span class="red">Меньше 10</span></div>
              <? } else { ?>
              	<div class="availability"><span class="no">Нет в наличии</span></div>
              <? } ?>
            </div>
          </div>
          <div class="line2">

                  <div class="articul">Артикул: <span><?=$arItem["PROPERTY_CML2_ARTICLE_VALUE"]?></span></div>

            <div class="action-block">
              <a class="icon icon16 compare link" data-action="add2compare" data-id="<?=$arItem['ID']?>" href="#"><span>К сравнению</span></a>
              <a class="icon icon16 favorite link add2favorite" data-action="add2favorite" data-id="<?=$arItem['ID']?>" href="#"><span>В закладки</span></a>
              
              <? if ($arItem["CATALOG_QUANTITY"]) { ?>
                <a  style="background:#99CC33;border: 1px solid #99CC33;"  class="buy button yellow" data-action="add2basket" href="/catalog/avtomasla/?action=ADD2BASKET&id=<?=$arItem['ID']?>" rel="nofollow">Купить</a>
              <? } else { ?>
                <a class="buy button yellow" data-action="add2basket" href="/catalog/avtomasla/motornye/?action=ADD2BASKET&amp;id=5107" rel="nofollow">Заказать</a>
              <? } ?>

            </div>
          </div>
        </div>
      </li>
    
      <? } ?>
      </ul>

  <?
    } }
    echo '</div>';
  }
  ?>

<? } ?>

<style type="text/css">
#success_save {
	width: 360px;
	margin: 20px;
	padding: 20px;
	text-align: center;
}
#success_save h2 {
	text-align: center;
	font-family: "gotham_probold";
	font-size: 22px;
	line-height: 100%;
	padding-bottom: 20px;	
}
#success_save a {
	background-color: #ffc236;
	display: block;
	width: 200px;
	padding: 14px 10px;
	margin: 16px auto;
	text-align: center;
	font-size: 14px;
	text-transform: uppercase;
	color: #272524;
	text-decoration: none;
}
#success_save a:hover {
	color: #fff;
	text-decoration: none;
}
.clearfix:after {
  display: block;
  content: ".";
  display: block;
  clear: both;
  visibility: hidden;
  line-height: 0;
  height: 0;
  font-size: 0;
}
.conf_form_wide {
    position: relative;
    /* width: 100%; */
    min-height: 70px;
    max-width: 1000px;
    margin: 0 0 20px;
    background-color: #ffc236;
    padding: 18px; 
}
.conf_form_title {
    font-family: "gotham_probold";
    font-size: 24px;
    line-height: 26px;
    margin: 0 0 10px;
    color: #2a2723;
}
.conf_form_select {
    float: left;
    margin-right: 10px;
}
.conf_form_select:nth-child(1) {
	width: 20%;
}
.conf_form_select:nth-child(2) {
	width: 20%;
}
.conf_form_select:nth-child(3) {
	width: 15%;
}
.conf_form_select:nth-child(4) {
	width: 14%;
}
.conf_form_select:nth-child(5) {
	width: 20%;
}
.select {
  max-width: none !important;
  width: 100% !important;
}
.selectboxit-container {
  position: relative;
  display: block;
}
.selectboxit-container * {
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
  white-space: nowrap;
}
.selectboxit {
  cursor: pointer;
  overflow: hidden;
  display: block;
  position: relative;
  background: #ffffff;
  width: auto !important;
  border: 1px solid #e1e1e2;
  color: #a4a4a3;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
.selectboxit-container span, .selectboxit-options a {
  height: 27px;
  line-height: 27px;
  display: block;
  font-size: 12px;
}
.selectboxit.selectboxit-disabled, .selectboxit-options .selectboxit-disabled {
  -moz-opacity: 0.5;
  -webkit-opacity: 0.5;
  opacity: 0.5;
  filter: alpha(opacity=50);
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  cursor: default;
}
.selectboxit-text {
  overflow: hidden;
  display: block;
  padding: 0 25px 0 8px;
  max-width: none !important;
}
.selectboxit-options {
  background: #ffffff;
  width: auto !important;
  overflow: auto !important;
  left: 0;
  right: 0;
  top: 100%;
  margin-top: -1px;
  border: 1px solid #dce0e3;
  min-width: 100%;
  position: absolute;
  cursor: pointer;
  display: none;
  z-index: 500;
  text-align: left;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
.selectboxit-option-anchor {
  padding: 0 25px 0 8px;
  color: #525252;
  text-decoration: none;
}
.selectboxit-selected .selectboxit-option-anchor {
  background-color: #eeeeee;
  color: #525252;
}
.selectboxit-option-anchor:hover {
  color: #ed0000;
}
.selectboxit-arrow-container {
  width: 25px;
  position: absolute;
  right: 0;
  top: 0;
}
.selectboxit-arrow {
  position: absolute;
  top: 50%;
  left: 9px;
  width: 8px;
  height: 5px;
  margin-top: -2px;
  background: url(/local/templates/tranzit-oil_v2/img/sb_toggle.png) 0 0 no-repeat;
}
.selectboxit-option-icon-container {
  float: left;
}
.selectboxit-rendering {
  display: inline-block !important;
  visibility: visible !important;
  position: absolute !important;
  top: -9999px !important;
  left: -9999px !important;
}

/* RESULT TABLE */
.conf-result {
  margin: 0 0 35px;
}
.options-line {
  margin: 0 0 7px 14px;
}
.expand-all {
  display: inline-block;
  background: url(/local/templates/tranzit-oil_v2/img/plus.png) 0 0 no-repeat;
  font-size: 12px;
  line-height: 14px;
  font-weight: bold;
  padding: 2px 3px 3px 24px;
  cursor: pointer;
  margin: 0 15px 0 0;
}
.collapse-all {
  display: inline-block;
  background: url(/local/templates/tranzit-oil_v2/img/minus.png) 0 0 no-repeat;
  font-size: 12px;
  line-height: 14px;
  font-weight: bold;
  padding: 2px 3px 3px 24px;
  cursor: pointer;
  margin: 0 15px 0 0;
}
.group-switch {
    width: 100%;
    height: 44px;
    line-height: 44px;
    position: relative;
    background-color: #ffc236;
    background-repeat: no-repeat;
    background-position: 95% bottom;
    border-radius: 5px;
    margin: 0 0 5px;
}
.group-switch-title {
    float: left;
    color: #2a2723;
    font-family: "gotham_probold";
    font-size: 24px;
    line-height: 26px;
    margin: 7px 0 10px;
}
.group-switch-toggle {
    width: 19px;
    height: 19px;
    background: url(/local/templates/tranzit-oil_v2/img/plus.png) 0 0 no-repeat;
    position: relative;
    float: left;
    margin: 12px 14px;
    cursor: pointer;
}
.group-switch-toggle.active {
    background-image: url(/local/templates/tranzit-oil_v2/img/minus.png);
}
.result_save_button {
  position: absolute;
  top: -45px;
  right: 55px;
  font-size: 14px;
  line-height: 31px;
  height: 31px;
  background-color: #80c452;
  color: #fff;
  text-decoration: none;
  text-align: center;
  padding: 0 10px;
  border-radius: 5px;
  text-transform: uppercase; 
}
.result_save_button:hover {
  color: #fff;
  text-decoration: none;
  opacity: 0.8;
}
</style>

<script src="/local/templates/tranzit-oil_v2/js/jquery-ui.min.js"></script>
<script src="/local/templates/tranzit-oil_v2/js/jquery.selectBoxIt.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

    $(".select").selectBoxIt();

    $("[name=m1]").change(function() {
    	var m1 = $("[name=m1]").find(":selected").val();
    	if (m1 != "Марка") {
    		$.post("/include/functions.php", {action:"m1", m1:m1}, function(response) {
	            if (response) {
	                $("[name=m2]").html(response);
	                $("[name=m2]").selectBoxIt('refresh');
	            }
	        });
    	}
    	$("[name=m3]").html('<option>Год выпуска</option>').selectBoxIt('refresh');
        $("[name=m4]").html('<option>Объем</option>').selectBoxIt('refresh');
        $("[name=m5]").html('<option>Мощность</option>').selectBoxIt('refresh');
    });

    $("[name=m2]").change(function() {
    	var m1 = $("[name=m1]").find(":selected").val();
        var m2 = $("[name=m2]").find(":selected").val();
        if (m2 != "Модель") {
            $.post("/include/functions.php", {action:"m2", m1:m1, m2:m2}, function(response) {
                if (response) {
                    $("[name=m3]").html(response).selectBoxIt('refresh');
                }
            });
        }
        $("[name=m4]").html('<option>Объем</option>').selectBoxIt('refresh');
        $("[name=m5]").html('<option>Мощность</option>').selectBoxIt('refresh');
    });

    $("[name=m3]").change(function() {
    	var m1 = $("[name=m1]").find(":selected").val();
        var m2 = $("[name=m2]").find(":selected").val();
        var m3 = $("[name=m3]").find(":selected").val();
        if (m3 != "Год выпуска") {
            $.post("/include/functions.php", {action:"m3", m1:m1, m2:m2, m3:m3}, function(response) {
                if (response) {
                    $("[name=m4]").html(response).selectBoxIt('refresh');
                    
                }
            });
        }
        $("[name=m5]").html('<option>Мощность</option>').selectBoxIt('refresh');
    });

    $("[name=m4]").change(function() {
    	var m1 = $("[name=m1]").find(":selected").val();
        var m2 = $("[name=m2]").find(":selected").val();
        var m3 = $("[name=m3]").find(":selected").val();
        var m4 = $("[name=m4]").find(":selected").val();
        if (m4 != "Объем") {
            $.post("/include/functions.php", {action:"m4", m1:m1, m2:m2, m3:m3, m4:m4}, function(response) {
                if (response) {
                    $("[name=m5]").html(response).selectBoxIt('refresh');
                }
            });
        }
    });

    $("[name=m5]").change(function() {
        var m1 = $("[name=m1]").find(":selected").val();
        var m2 = $("[name=m2]").find(":selected").val();
        var m3 = $("[name=m3]").find(":selected").val();
        var m4 = $("[name=m4]").find(":selected").val();
        var m5 = $("[name=m5]").find(":selected").val();
        var section = $("[name=section]").val();
        if (m5 != "Мощность") {
        	/*$.post("/include/functions.php", {action:"m5", m1:m1, m2:m2, m3:m3, m4:m4, m5:m5, section:section}, function(response) {
              $(".conf-result").remove();
	            if (response) {
	                $(".conf_form_wide").after(response);
                  $(".result_save_button").show();
	            }
	        });*/
          $(this).parents("form").submit();
        }
    });

    $(document).on("click", ".expand-all", function() {
      $(this).parent().next().find(".group-switch-toggle").not(".active").click();
      return false;
    });

    $(document).on("click", ".collapse-all", function() {
      $(this).parent().next().find(".group-switch-toggle.active").click();
      return false;
    });

    $(document).on("click", ".group-switch-toggle", function() {
        $(this).toggleClass("active");
        $(this).parent().next(".catalog-element-list").fadeToggle(250);
    });

    $("#success_save a").eq(1).click(function() {
    	$(".fancybox-close").click();
    	return false;
    });

    $(".result_save_button").click(function() {

      <? if (!$USER->IsAuthorized()) { ?>
      $(".auth_form_login h3").text("Для сохранения данных подбора войдите в личный кабинет");
      $(".auth_form_login .buttons").append('<p>или</p><button class="yellow open_ajax registr" type="button" name="Register" value="Y">Зарегистрироваться</button>');
      $(".open_ajax.login").click();
      <? } ?>

      <? if ($USER->IsAuthorized()) { ?>
      $.fancybox.open("#success_save");

      var m1 = "<?=$_GET["m1"]?>";
      var m2 = "<?=$_GET["m2"]?>";
      var m3 = "<?=$_GET["m3"]?>";
      var m4 = "<?=$_GET["m4"]?>";
      var m5 = "<?=$_GET["m5"]?>";
      var id = $("[name=id]").val();
      $.post("/include/functions.php", {action:"save_conf", m1:m1, m2:m2, m3:m3, m4:m4, m5:m5, id:id});
      //$(this).fadeOut(250);
      <? } ?>

      return false;
    });

    $(document).on("click", ".selectboxit-option-anchor", function() {
    	$(".selectboxit-options").hide();
    	return false;
    });

});
</script>