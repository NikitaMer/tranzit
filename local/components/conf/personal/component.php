<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

if (!$USER->IsAuthorized()) {
  LocalRedirect("/404.php");
  die();
}

$aGarage = Array();
$q = CIBlockElement::GetList(Array("ID"=>"DESC"), Array("IBLOCK_ID"=>91, "=NAME"=>$USER->GetID()), false, Array("nTopCount"=>3), Array("ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT"));
while ($a = $q->GetNext()) {
  $aGarage[$a["ID"]] = explode(",", $a["PREVIEW_TEXT"]);
  $aGarage[$a["ID"]][] = $a["DETAIL_TEXT"];
}

?>

<? if (!count($aGarage)) { ?><p>Здесь сохраняются результаты подбора для Вашего автомобиля.</p><? } ?>

<? if (count($aGarage)) { ?>
<div class="garage_table">
  
  <h2>Гараж</h2>
  <div class="options-line options-1">
      <div class="expand-all">Развернуть все</div>
      <div class="collapse-all">Свернуть все</div>
      <div class="delete-all">Удалить</div>
    </div>


  <?
  foreach ($aGarage as $id=>$car) {

    $q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "ID"=>$car[5], "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER", "PREVIEW_TEXT"));
    $aArticul = Array();
    if ($a = $q->GetNext()) {
      $aArticul = explode(",", $a["PREVIEW_TEXT"]);
    } else {
      continue;
    }
    foreach ($aArticul as $k=>$v) {
      $aArticul[$k] = trim($v);
    }

    $aProducts = Array();
    $aParents = Array();
    $q = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>73, "=PROPERTY_CML2_ARTICLE"=>$aArticul, "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "IBLOCK_SECTION_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "DETAIL_PAGE_URL", "PREVIEW_TEXT", "CATALOG_GROUP_2", "PROPERTY_CML2_ARTICLE"));
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

    if ($q->SelectedRowsCount()) {
  ?>

  <div class="garage_table_car">

    <div class="garage_table_car_title">
      <div class="garage_table_car_switch_toggle"></div>
      <div class="name"><?=implode(" / ", $car);?></div>
      <div class="garage_table_car_delete" data-id="<?=$id?>"></div>
    </div>

    <div class="garage_table_car_elements">

      <div class="options-line options-2">
        <div class="expand-all">Развернуть все</div>
        <div class="collapse-all">Свернуть все</div>
      </div>
      <div class="conf-result">
      <?
      $aCustomSection = Array(269, 270, 166, 305, 168, 169, 319, 323, 170, 381);
      foreach ($aCustomSection as $section) {
      foreach ($aParents as $aGroup) {
        if ($section != $aGroup["ID"]) {
          continue;
        }
      ?>

          <div class="group-switch" style="background-image:url(<?=CFile::GetPath($aGroup["DETAIL_PICTURE"])?>);">
            <div class="group-switch-toggle"></div>
            <div class="group-switch-title"><?=$aGroup["NAME"]?></div>
          </div>

          <ul class="catalog-element-list">
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

          <? } } ?>
          </div>
    </div>



  </div>

  <? } ?>

  <? } ?>

</div>
<? } ?>

<style type="text/css">
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
.garage_table_car {
  margin: 0 0 5px;
}
.garage_table_car h2 {
  font-family: "gotham_probold";
  font-size: 22px;
  line-height: 100%;
  padding-bottom: 15px;
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
.delete-all {
  display: inline-block;
  background: url(/local/templates/tranzit-oil_v2/img/delete2.png) 0 0 no-repeat;
  font-size: 12px;
  line-height: 14px;
  font-weight: bold;
  padding: 2px 3px 3px 24px;
  cursor: pointer;
  margin: 0 15px 0 0;
}
.garage_table_car_title {
  border: 1px solid #dadbdb;
  border-radius: 3px;
  background-color: #dadcdb;
  color: #31302f;
  font-size: 16px;
  text-transform: uppercase;
  line-height: 50px;
}
.garage_table_car_title .name {
  display: inline-block;
}
.garage_table_car_switch_toggle {
    width: 19px;
    height: 19px;
    background: url(/local/templates/tranzit-oil_v2/img/plus.png) 0 0 no-repeat;
    position: relative;
    float: left;
    margin: 16px 14px;
    cursor: pointer;
}
.garage_table_car_switch_toggle.active {
    background-image: url(/local/templates/tranzit-oil_v2/img/minus.png);
}
.garage_table_car_delete {
   width: 17px;
    height: 17px;
    float: right;
    cursor: pointer;
    margin: 16px 14px;
    position: relative;
  background-image: url(/local/templates/tranzit-oil_v2/img/delete.png);
}
.garage_table_car_elements {
  padding: 40px;
  border: 1px solid #d9d9d9;
  border-radius: 3px;
}
/* RESULT TABLE */
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
    background: url(/local/templates/tranzit-oil_v2/img/minus.png) 0 0 no-repeat;
    position: relative;
    float: left;
    margin: 12px 14px;
    cursor: pointer;
}
.group-switch-toggle.active {
    background-image: url(/local/templates/tranzit-oil_v2/img/plus.png);
}
.result_save_button {
  display: none;
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

    /*$(".select").selectBoxIt();*/

    /*$(document).on("click", ".group-switch-toggle", function() {
        $(this).toggleClass("active");
        $(this).parent().next(".catalog-element-list").fadeToggle(250);
    });*/

    $(".garage_table_car_switch_toggle").click(function() {
        $(this).toggleClass("active");
        $(this).parent().next(".garage_table_car_elements").fadeToggle(250);
    });

    $(".options-1 .expand-all").click(function() {
      $(".garage_table_car_title .garage_table_car_switch_toggle.active").click();
      return false;
    });

    $(".options-1 .collapse-all").click(function() {
      $(".garage_table_car_title .garage_table_car_switch_toggle").not(".active").click();
      return false;
    });

    $(".options-1 .delete-all").click(function() {
      $.post("/include/functions.php", {action:"clear_garage"});
      $(".garage_table_car").html('<p>Список автомобилей очищен.</p>');
      return false;
    });

    $(".options-2 .expand-all").click(function() {
      $(this).parent().next().find(".group-switch-toggle.active").click();
      return false;
    });

    $(".options-2 .collapse-all").click(function() {
      $(this).parent().next().find(".group-switch-toggle").not(".active").click();
      return false;
    });

    $(".garage_table_car_delete").click(function() {
      var id = $(this).attr("data-id");
      $.post("/include/functions.php", {action:"clear_car", id:id});
      $(this).parent().next().remove();
      $(this).parent().remove();
      return false;
    });

});
</script>