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


if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID'])
{
	$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
	$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

	?><h1
		class="<? echo $arCurView['TITLE']; ?>"
		id="<? echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>"
	><a href="<? echo $arResult['SECTION']['SECTION_PAGE_URL']; ?>"><?
		echo (
			isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
			? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
			: $arResult['SECTION']['NAME']
		);
	?></a></h1><?
}

if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<ul class="catalog-section-list">
<?
		$intCurrentDepth = 1;
		$boolFirst = true;
		foreach ($arResult['SECTIONS'] as &$arSection)
		{
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

			if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
			{
				if (0 < $intCurrentDepth)
					echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']),'<ul>';
			}
			elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL'])
			{
				if (!$boolFirst)
					echo '</li>';
			}
			else
			{
				while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
				{
					echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
					$intCurrentDepth--;
				}
				echo str_repeat("\t", $intCurrentDepth-1),'</li>';
			}

			echo (!$boolFirst ? "\n" : ''),str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
			$img = CFile::ResizeImageGet($arSection['PICTURE'], array('width'=>146, 'height'=>146), BX_RESIZE_IMAGE_PROPORTIONAL, true);

			?><li id="<?=$this->GetEditAreaId($arSection['ID']);?>">
				<a href="<? echo $arSection["SECTION_PAGE_URL"]; ?>">
					<div class="image" style="background-image: url(<?=$img['src']?>);"></div>
					<span><? echo $arSection["NAME"];?>
						<?
						if ($arParams["COUNT_ELEMENTS"])
						{
							?> <span>(<? echo $arSection["ELEMENT_CNT"]; ?>)</span><?
						}
						?>
					</span>
				</a>
			</li>
			<?

			$intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
			$boolFirst = false;
		}

		unset($arSection);

		while ($intCurrentDepth > 1)
		{
			echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
			$intCurrentDepth--;
		}
		if ($intCurrentDepth > 0)
		{
			echo '</li>',"\n";
		}

?></ul><?
}
?>