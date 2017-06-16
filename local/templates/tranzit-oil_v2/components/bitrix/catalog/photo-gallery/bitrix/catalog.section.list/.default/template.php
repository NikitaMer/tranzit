<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>
<ul class="photo-galery-albums">
    <?foreach ($arResult['SECTIONS'] as &$arSection):

    $this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

    $link_title = isset($arSection["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arSection["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
        ? $arSection["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
        : $arResult['SECTION']['NAME'];

    $alt = $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
        ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
        : $arSection["NAME"];

    $title = $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
        ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
        : $arSection["NAME"];

    #echo '<pre>'.print_r($arSection["IPROPERTY_VALUES"], true).'</pre>';

    $image = $arSection["ALBUM_PICTURE"] ? ' style = "background: url('.$arSection["ALBUM_PICTURE"]['src'].')"' : '';
    ?>
    <li id="<? echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>">
        <a class="foto" href="<?=$arSection["SECTION_PAGE_URL"]?>" title="<?=$link_title?>"<?=$image?>>
        </a>
        <div class="desc">
            <h2><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></h2>
            <div class="text">
                <? #echo '<pre>'.print_r($arSection, true).'</pre>'?>
                <?=$arSection['DESCRIPTION'];?>
            </div>
        </div>
    </li>
    <?endforeach;?>
</ul>