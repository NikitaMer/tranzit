<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

if ($_POST["action"] == "m1") {
    $q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "NAME"=>$_POST["m1"], "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER"));
    $aResult = Array();
    while ($a = $q->GetNext()) {
        $aResult[] = $a["PROPERTY_MODEL_VALUE"];
    }
    $aResult = array_unique($aResult);
    echo '<option value="Модель">Модель</option>';
    foreach ($aResult as $v) {
        echo '<option>'.$v.'</option>';
    }
}

if ($_POST["action"] == "m2") {
    $q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "NAME"=>$_POST["m1"], "=PROPERTY_MODEL"=>$_POST["m2"], "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER"));
    $aResult = Array();
    while ($a = $q->GetNext()) {
        $aResult[] = $a["PROPERTY_YEAR_VALUE"];
    }
    $aResult = array_unique($aResult);
    echo '<option value="Год выпуска">Год выпуска</option>';
    foreach ($aResult as $v) {
        echo '<option>'.$v.'</option>';
    }
}

if ($_POST["action"] == "m3") {
    $q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "NAME"=>$_POST["m1"], "PROPERTY_MODEL"=>$_POST["m2"], "PROPERTY_YEAR"=>$_POST["m3"], "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER"));
    $aResult = Array();
    while ($a = $q->GetNext()) {
        $aResult[] = $a["PROPERTY_VOLUME_VALUE"];
    }
    $aResult = array_unique($aResult);
    echo '<option value="Объем">Объем</option>';
    foreach ($aResult as $v) {
        echo '<option>'.$v.'</option>';
    }
}

if ($_POST["action"] == "m4") {
    $q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "NAME"=>$_POST["m1"], "PROPERTY_MODEL"=>$_POST["m2"], "PROPERTY_YEAR"=>$_POST["m3"], "PROPERTY_VOLUME"=>$_POST["m4"], "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER"));
    $aResult = Array();
    while ($a = $q->GetNext()) {
        $aResult[] = $a["PROPERTY_POWER_VALUE"];
    }
    $aResult = array_unique($aResult);
    echo '<option value="Мощность">Мощность</option>';
    foreach ($aResult as $v) {
        echo '<option>'.$v.'</option>';
    }
}

if ($_POST["action"] == "m5") {

    $q = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>90, "NAME"=>$_POST["m1"], "PROPERTY_MODEL"=>$_POST["m2"], "PROPERTY_YEAR"=>$_POST["m3"], "PROPERTY_VOLUME"=>$_POST["m4"], "PROPERTY_POWER"=>$_POST["m5"], "ACTIVE"=>"Y"), false, false, Array("ID", "NAME", "PROPERTY_MODEL", "PROPERTY_YEAR", "PROPERTY_VOLUME", "PROPERTY_POWER", "PREVIEW_TEXT"));
    $aArticul = Array();
    if ($a = $q->GetNext()) {
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

    if ($_POST["section"] > 0) {
        if (is_array($aParents[$_POST["section"]])) {
            $aTMP = $aParents[$_POST["section"]];
            unset($aParents[$_POST["section"]]);
            $aParents = array_merge(Array($_POST["section"]=>$aTMP), $aParents);
        }
    }

    if ($q->SelectedRowsCount()) {

        echo '<div class="conf-result">';

        foreach ($aParents as $aGroup) {
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
                            <div class="availability"><span>В наличии</span></div>
                        </div>
                    </div>
                    <div class="line2">

                        <div class="articul">Артикул: <span><?=$arItem["PROPERTY_CML2_ARTICLE_VALUE"]?></span></div>

                        <div class="action-block">
                            <a class="icon icon16 compare link" data-action="add2compare" data-id="<?=$arItem['ID']?>" href="#"><span>К сравнению</span></a>
                            <a class="icon icon16 favorite link add2favorite" data-action="add2favorite" data-id="<?=$arItem['ID']?>" href="#"><span>В закладки</span></a>
                            <a  style="background:#99CC33;border: 1px solid #99CC33;"  class="buy button yellow" data-action="add2basket" href="/catalog/avtomasla/?action=ADD2BASKET&id=<?=$arItem['ID']?>" rel="nofollow">Купить</a>
                        </div>
                    </div>
                </div>
            </li>
        
            <? } ?>
            </ul>

            <?

        }

        echo '</div>';

    }

}

if ($_POST["action"] == "save_conf") {
    $PREVIEW_TEXT = $_POST["m1"].",".$_POST["m2"].",".$_POST["m3"].",".$_POST["m4"].",".$_POST["m5"];
    $q = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>91, "=NAME"=>$USER->GetID(), "PREVIEW_TEXT"=>$PREVIEW_TEXT), false, Array("nTopCount"=>1), Array("ID"));
    if (!$q->SelectedRowsCount()) {
        $aElementFields = Array(
            "IBLOCK_ID" => 91,
            "IBLOCK_SECTION_ID" => false,
            "NAME" => $USER->GetID(),
            "PREVIEW_TEXT" => $PREVIEW_TEXT,
            "DETAIL_TEXT" => $_POST["id"]
        );
        $element = new CIBlockElement;
        $element->Add($aElementFields);
    }
}

if ($_POST["action"] == "clear_garage") {
    $q = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>91, "=NAME"=>$USER->GetID()), false, false, Array("ID"));
    while ($a = $q->GetNext()) {
        CIBlockElement::Delete($a["ID"]);
    }
}

if ($_POST["action"] == "clear_car") {
    $q = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>91, "=NAME"=>$USER->GetID(), "ID"=>$_POST["id"]), false, Array("nTopCount"=>1), Array("ID"));
    if ($a = $q->GetNext()) {
        CIBlockElement::Delete($a["ID"]);
    }
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>