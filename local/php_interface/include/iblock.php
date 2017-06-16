<?

#AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("TranziOilIBlock", "OnBeforeIBlockElementUpdateHandler"), 10);
#AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("TranziOilIBlock", "OnBeforeIBlockElementUpdateHandler"), 10);
#AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("TranziOilIBlock", "OnBeforeIBlockElementDeleteHandler"), 10);

#AddEventHandler("iblock", "OnBeforeIBlockSectionAdd", Array("TranziOilIBlock", "OnBeforeIBlockSectionAddUpdateHandler"));

class TranziOilIBlock
{
	function OnBeforeIBlockElementUpdateHandler(&$arFields)
	{
		
	}

	function OnBeforeIBlockElementDeleteHandler($ID)
	{
		
	}
}
