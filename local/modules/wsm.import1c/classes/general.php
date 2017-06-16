<?php
#AddEventHandler("search", "BeforeIndex", Array("MyClass", "BeforeIndexHandler"));

class WsmImport1cIBlockSearch extends WsmImport1cIBlockHelper
{
    private static $section_for_new = array();

    function BeforeIndexHandler($arFields) 
    {
        if($arFields["MODULE_ID"] == "iblock")
        {
            $IBLOCK_ID = (int)$arFields["PARAM2"];

            if(!isset(self::$section_for_new[$IBLOCK_ID]) || self::$section_for_new[$IBLOCK_ID] === null)
                self::$section_for_new[$IBLOCK_ID] = self::getSectionForNew($IBLOCK_ID);

            # раздел для новых элементов из 1С задан
            if(isset(self::$section_for_new[$IBLOCK_ID]) && self::$section_for_new[$IBLOCK_ID] > 0)
            {
                parse_str($arFields['URL'], $output);

                if($output['IBLOCK_SECTION_ID'] > 0)
                {
                    $is_in_section_for_new = self::CheckSectionInSection($IBLOCK_ID, $output['IBLOCK_SECTION_ID'], self::$section_for_new);

                    if($is_in_section_for_new)
                    {
                        $arFields["TITLE"] = '';
                        $arFields["BODY"] = '';
                    }

                }

            }

        }

        return $arFields;
    }
}