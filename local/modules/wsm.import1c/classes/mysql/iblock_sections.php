<?php

IncludeModuleLangFile(__FILE__);


class WsmImport1cIBlockSections extends WsmImport1cIBlockHelper
{

    function OnBeforeIBlockSectionAddHandler(&$arFields)
    {
        if(!CModule::IncludeModule('iblock'))
            return $arFields;
		
		self::Log($arFields);
		
		$section_for_new = self::getSectionForNew($arFields["IBLOCK_ID"]);
		 
		if($section_for_new <= 0)
		{
			self::Log('not set section for new elements');
			return $arFields;
		}
            

        #get settings for 1C
        $IBLOCK_TYPE = self::getIBlockType1C();

        //get iblock type for iblock
        if(!$arFields['IBLOCK_TYPE_ID'])
            $arFields["IBLOCK_TYPE_ID"] = self::getIBlockType ($arFields["IBLOCK_ID"]);

        self::Log('IBLOCK_TYPE_ID from fields = '.$arFields['IBLOCK_TYPE_ID'] , 'IBLOCK_TYPE from settings '.$IBLOCK_TYPE);

        # is catalog 1C?
        if($arFields['IBLOCK_TYPE_ID'] != $IBLOCK_TYPE)
		{
			self::Log('is not a 1C catalog, exit');
			return $arFields;
		}

        $USE_AS = self::getIBlockUse($arFields["IBLOCK_ID"]);

        self::Log('USE_AS = ', $USE_AS);

        if($USE_AS != self::IS_PRODUCT)
		{
			self::Log('is not a product, exit');
			return true;
		}

        if(!in_array($arFields["IBLOCK_ID"], $_SESSION[self::SID]['IBLOCK_ID']))
            $_SESSION[self::SID]['IBLOCK_ID'][] = $arFields["IBLOCK_ID"];

        $is_in_section_for_new = self::CheckSectionInSection($arFields['IBLOCK_ID'], $arFields['IBLOCK_SECTION_ID'], $section_for_new);

        $is_1c_import = strlen($arFields['XML_ID']) > 1 ? true : false ;

        self::Log('is_1c_import = ', $is_1c_import, 'is_in_section_for_new = ',$is_in_section_for_new);

        if(!$is_1c_import && $is_in_section_for_new)
        {
			self::Log('Error: '.GetMessage('WSM_IMPORT1C_CREATE_NEW_IN_1C_DISABLED'));
            $GLOBALS['APPLICATION']->throwException(GetMessage('WSM_IMPORT1C_CREATE_NEW_IN_1C_DISABLED'));
            return false;
        }

        # if section in not in for new
        if($is_1c_import && !$is_in_section_for_new)
		{
			self::Log('move to section for new: '.$section_for_new);
			$arFields['IBLOCK_SECTION_ID'] = $section_for_new;
		}
            

        return $arFields;
    }

    function OnBeforeIBlockSectionUpdateHandler(&$arFields)
    {
		if(!CModule::IncludeModule('iblock'))
            return $arFields;
		
		self::Log($arFields);
		
		$section_for_new = self::getSectionForNew($arFields["IBLOCK_ID"]);
		
		if($section_for_new <= 0)
		{
			self::Log('not set section for new elements');
			return $arFields;
		}

        #get settings
        $IBLOCK_TYPE = self::getIBlockType1C();

        //get iblock type for iblock
        if(!$arFields['IBLOCK_TYPE_ID'])
            $arFields["IBLOCK_TYPE_ID"] = self::getIBlockType ($arFields["IBLOCK_ID"]);

        # is catalog 1C?
        if($arFields['IBLOCK_TYPE_ID'] != $IBLOCK_TYPE)
		{
			self::Log('IBLOCK_TYPE is not a 1C catalog, SAVE');
			return true;
		}

        $USE_AS = self::getIBlockUse($arFields["IBLOCK_ID"]);

        if($USE_AS != self::IS_PRODUCT)
		{
			self::Log('is not a product, SAVE');
			return true;
		}

        if(!in_array($arFields["IBLOCK_ID"], $_SESSION[self::SID]['IBLOCK_ID']))
            $_SESSION[self::SID]['IBLOCK_ID'][] = $arFields["IBLOCK_ID"];


        $res = CIBlockSection::GetByID($arFields['ID']);
        if(!($arSection = $res->GetNext(false, false)))
		{
			self::Log('section not found, SAVE');
			return true;
		}

        $is_1c_import = strlen($arSection['EXTERNAL_ID']) > 0 ? true : false ;
		
        $is_in_section_for_new = self::CheckSectionInSection($arFields['IBLOCK_ID'], $arSection['IBLOCK_SECTION_ID'], $section_for_new);
		$new_is_in_section_for_new = self::CheckSectionInSection($arFields['IBLOCK_ID'], $arFields['IBLOCK_SECTION_ID'], $section_for_new);

        self::Log($arFields, (int)$is_in_section_for_new, (int)$new_is_in_section_for_new);

        if($arSection['IBLOCK_SECTION_ID'] > 0 && ($is_in_section_for_new || $new_is_in_section_for_new))
            $arFields['ACTIVE'] = 'N';


        if($is_in_section_for_new && $new_is_in_section_for_new)
			return $arFields;

        //echo ' ## '.$arFields['IBLOCK_SECTION_ID'];

        if($arFields['IBLOCK_SECTION_ID'] >= 0 && $is_in_section_for_new && !$new_is_in_section_for_new)
        {
			if($_REQUEST['mode'] == 'import')
			{
				self::Log('move FROM 1c section disabled, recovery section');
				$arFields['IBLOCK_SECTION_ID'] = $arSection['IBLOCK_SECTION_ID'];	
				return $arFields;
			}

			self::Log('move FROM 1c section disabled, CANCEL SAVE');
			
            $GLOBALS['APPLICATION']->throwException(GetMessage('WSM_IMPORT1C_MOVE_FROM_SECTION_1C_DISABLED'));
            return false;
            
        }
		elseif($arFields['IBLOCK_SECTION_ID'] > 0 && !$is_in_section_for_new && $new_is_in_section_for_new)
        {
			if($_REQUEST['mode'] == 'import')
			{
				self::Log('move FROM 1c section disabled, recovery section');
				$arFields['IBLOCK_SECTION_ID'] = $arSection['IBLOCK_SECTION_ID'];
				return $arFields;
			}

			self::Log('move TO 1c section disabled, CANCEL SAVE');
			
            $GLOBALS['APPLICATION']->throwException(GetMessage('WSM_IMPORT1C_MOVE_TO_SECTION_1C_DISABLED'));
            return false;
        }
        

        # if section in not in for new
        if(!$is_in_section_for_new && $is_1c_catalog)
            $arFields['IBLOCK_SECTION_ID'] = $section_for_new;


        return $arFields;
    }

    function OnAfterIBlockSectionAddHandler(){
        #remove saved data
        unset($_SESSION[self::SID]['SECTIONS_PRODUCT_BLOCK']);
    }

    function OnAfterIBlockSectionUpdateHandler(){
        #remove saved data
        unset($_SESSION[self::SID]['SECTIONS_PRODUCT_BLOCK']);
    }

    function OnBeforeIBlockSectionDeleteHandler($ID)
    {
        $res = CIBlockSection::GetByID($ID);
        if($ar_res = $res->GetNext())
            $section_for_new = self::getSectionForNew($ar_res['IBLOCK_ID']);

		$is_in_section_for_new = self::CheckSectionInSection($arFields['IBLOCK_ID'], $arFields['IBLOCK_SECTION_ID'], $section_for_new);
		
		if($_REQUEST['mode'] == 'import' && (!$is_in_section_for_new || $ID==$section_for_new))
		{
			self::Log('1C delete CANCEL for 1C: '.$ar_res['NAME']);
			return false;
		}

		if($ID == $section_for_new)
		{
			self::Log('delete CANCEL: '.$ar_res['NAME']);
			$GLOBALS['APPLICATION']->throwException(GetMessage('WSM_IMPORT1C_SECTION_USED'));
			return false;
		}
			
    }

}