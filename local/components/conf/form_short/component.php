<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

$aOptions = Array();
$q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER"));
while ($a = $q->GetNext()) {
    $aOptions[$a["NAME"]][$a["PROPERTY_MODEL_VALUE"]][$a["PROPERTY_YEAR_VALUE"]][$a["PROPERTY_VOLUME_VALUE"]] = $a["PROPERTY_POWER_VALUE"];
}

?>

<div class="conf_form_short clearfix">
    <div class="conf_form_title">Подбор автотоваров по автомобилю</div>
    <form action="/catalog/avtomasla/motornye/" method="GET">
      <input type="hidden" name="section" value="128" />
      <div class="conf_form_body clearfix">
          <div class="conf_form_select">
              <select class="select" name="m1">
                  <option value="Марка">Марка</option>
                  <? foreach ($aOptions as $k=>$v) { ?><option value="<?=$k?>"><?=$k?></option><? } ?>
              </select>
          </div>
          <div class="conf_form_select">
              <select class="select" name="m2">
                  <option>Модель</option>
              </select>
          </div>
          <div class="conf_form_select">
              <select class="select" name="m3">
                  <option>Год выпуска</option>
              </select>
          </div>
          <div class="conf_form_select">
              <select class="select" name="m4">
                  <option>Объем</option>
              </select>
          </div>
          <div class="conf_form_select">
              <select class="select" name="m5">
                  <option>Мощность</option>
              </select>
          </div>
          <input class="podbor-button disabled" type="button" value="Подобрать" />
      </div>
    </form>
</div>

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
.conf_form_short {
    position: relative;
    width: 100%;
    margin: 0 0 20px;
    background-color: #ffc236;
    padding: 14px; 
}
.conf_form_title {
    font-family: "gotham_probold";
    font-size: 20px;
    line-height: 24px;
    margin: 0 0 10px;
    color: #2a2723;
}
.conf_form_select {
    float: left;
    margin-bottom: 10px;
}
.conf_form_select:nth-child(1) {
	width: 223px;
}
.conf_form_select:nth-child(2) {
	width: 223px;
}
.conf_form_select:nth-child(3) {
	width: 106px;
  margin-right: 10px;
}
.conf_form_select:nth-child(4) {
	width: 106px;
  margin-right: 10px;
}
.conf_form_select:nth-child(5) {
	width: 106px;
  margin-right: 10px;
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
.podbor-button {
  float: left;
  font-size: 13px;
  line-height: 26px;
  height: 27px;
  background-color: #727271;
  border: 0 none;
  color: #fff;
  text-transform: uppercase;
  width: 106px;
  cursor: pointer;
}
.podbor-button:hover {
  color: #ffc236;
}
.podbor-button.disabled {
  opacity: 0.5;
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
    	/*$("[name=m3]").html('<option>Год выпуска</option>').selectBoxIt('refresh');
        $("[name=m4]").html('<option>Объем</option>').selectBoxIt('refresh');
        $("[name=m5]").html('<option>Мощность</option>').selectBoxIt('refresh');*/
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
        $(".podbor-button").removeClass("disabled");
    });

    $(".podbor-button").click(function() {
      if (!$(this).hasClass("disabled")) {
        $(this).parents("form").submit();
      }
    });

    /*$(".result_save_button").click(function() {
      var m1 = $("[name=m1]").find(":selected").val();
      var m2 = $("[name=m2]").find(":selected").val();
      var m3 = $("[name=m3]").find(":selected").val();
      var m4 = $("[name=m4]").find(":selected").val();
      var m5 = $("[name=m5]").find(":selected").val();
      $.post("/include/functions.php", {action:"save_conf", m1:m1, m2:m2, m3:m3, m4:m4, m5:m5});
      $(this).fadeOut(250);
      return false;
    });*/

    $(document).on("click", ".selectboxit-option-anchor", function() {
      $(".selectboxit-options").hide();
      return false;
    });

});
</script>