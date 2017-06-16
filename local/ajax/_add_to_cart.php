<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arParams["ACTION_VARIABLE"] = 'action';
$arParams["PRODUCT_ID_VARIABLE"] = 'id';
$arParams["USE_PRODUCT_QUANTITY"] = 'Y';
$arParams["QUANTITY_FLOAT"] = 'N';
$arParams["PRODUCT_QUANTITY_VARIABLE"] = 'quantity';
$arParams["PRODUCT_PROPERTIES"] = array();
$arParams["OFFERS_CART_PROPERTIES"] = array("CML2_ARTICLE","CML2_BASE_UNIT");

$out = array(
	'ERROR' => false,
	);
	
if (array_key_exists($arParams["ACTION_VARIABLE"], $_REQUEST) && array_key_exists($arParams["PRODUCT_ID_VARIABLE"], $_REQUEST))
{
	if(array_key_exists($arParams["ACTION_VARIABLE"]."BUY", $_REQUEST))
		$action = "BUY";
	elseif(array_key_exists($arParams["ACTION_VARIABLE"]."ADD2BASKET", $_REQUEST))
		$action = "ADD2BASKET";
	else
		$action = strtoupper($_REQUEST[$arParams["ACTION_VARIABLE"]]);

	$productID = intval($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]);
	if (($action == "ADD2BASKET" || $action == "BUY" || $action == "SUBSCRIBE_PRODUCT") && $productID > 0)
	{
		if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog") && CModule::IncludeModule('iblock'))
		{
			$QUANTITY = 0;
			if($arParams["USE_PRODUCT_QUANTITY"])
			{
				if ('Y' == $arParams['QUANTITY_FLOAT'])
				{
					$QUANTITY = doubleval($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]);
					if ($QUANTITY <= 0)
						$QUANTITY = 1;
				}
				else
				{
					$QUANTITY = intval($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]);
					if($QUANTITY <= 1)
						$QUANTITY = 1;
				}
			}

			$product_properties = array();
			$rsItems = CIBlockElement::GetList(array(), array('ID' => $productID), false, false, array('ID', 'IBLOCK_ID'));
			if ($arItem = $rsItems->Fetch())
			{
				$arItem['IBLOCK_ID'] = intval($arItem['IBLOCK_ID']);
				if ($arItem['IBLOCK_ID'] == $arParams["IBLOCK_ID"])
				{
					if (!empty($arParams["PRODUCT_PROPERTIES"]))
					{
						if (
							array_key_exists($arParams["PRODUCT_PROPS_VARIABLE"], $_REQUEST)
							&& is_array($_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]])
						)
						{
							$product_properties = CIBlockPriceTools::CheckProductProperties(
								$arParams["IBLOCK_ID"],
								$productID,
								$arParams["PRODUCT_PROPERTIES"],
								$_REQUEST[$arParams["PRODUCT_PROPS_VARIABLE"]]
							);
							if (!is_array($product_properties))
								$strError = GetMessage("CATALOG_ERROR2BASKET").".";
						}
						else
						{
							$strError = GetMessage("CATALOG_ERROR2BASKET").".";
						}
					}
				}
				else
				{
					if (!empty($arParams["OFFERS_CART_PROPERTIES"]))
					{
						$product_properties = CIBlockPriceTools::GetOfferProperties(
							$productID,
							$arParams["IBLOCK_ID"],
							$arParams["OFFERS_CART_PROPERTIES"]
						);
					}
				}
			}
			else
			{
				$strError = GetMessage('CATALOG_ELEMENT_NOT_FOUND').".";
			}

			$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
			$arNotify = unserialize($notifyOption);
			$arRewriteFields = array();
			
			if ($action == "SUBSCRIBE_PRODUCT" && $arNotify[SITE_ID]['use'] == 'Y')
			{
				$arRewriteFields["SUBSCRIBE"] = "Y";
				$arRewriteFields["CAN_BUY"] = "N";
			}
			
			if($strError || !Add2BasketByProductID($productID, $QUANTITY, $arRewriteFields, $product_properties))
			{
				if ($ex = $APPLICATION->GetException())
					$strError = $ex->GetString();
				else
					$strError = GetMessage("CATALOG_ERROR2BASKET").".";
			}
		}
	}
}

if($strError)
	$out['ERROR'] = $strError;
	
echo json_encode($out);
die ();
?>
