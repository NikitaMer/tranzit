<?
AddEventHandler("iblock", "OnBeforeIBlockSectionAdd", Array("MyClass", "OnBeforeIBlockSectionAddUpdateHandler"));
AddEventHandler("iblock", "OnBeforeIBlockSectionUpdate", Array("MyClass", "OnBeforeIBlockSectionAddUpdateHandler"));

class MyClass
{
    // создаем обработчик события "OnBeforeIBlockSectionAdd"
    
    function Log()
    {
        $path = dirname(__FILE__).'/import-'.date('Y-m-d').'.log';

        $arArgs = func_get_args();
        $sResult = ''; 

        foreach($arArgs as $arArg)
            $sResult .= print_r($arArg, true).' / ';

        $sResult = date('Y-m-d H:i:s  ').$sResult.chr(13)."----".chr(13);

        $hfile = fopen($path, "a");
        fwrite($hfile, $sResult);
        fclose($hfile);
        return true;
    }

    function getSectionTree()
    {
        $arSections = array();

        if(!CModule::IncludeModule('iblock'))
            return $arSections;

        $arFilter = array(
            'IBLOCK_ID' => 1,
            );

        $rs = CIBlockSection::GetList(Array("left_margin"=>"desc"), $arFilter);
        while($s = $rs->GetNext())
        {
            $arSections[$s['ID']] = array(
                'ID' => $s['ID'],
                'IBLOCK_SECTION_ID' => $s['IBLOCK_SECTION_ID'],
                'DEPTH_LEVEL' => $s['DEPTH_LEVEL'],
            );
        }

        return $arSections;
    }

    function OnBeforeIBlockSectionAddUpdateHandler(&$arFields)
    {
        if(!CModule::IncludeModule('iblock'))
            return;

        self::Log('section Id='.$arFields['ID'].' name='.$arFields['NAME'].' tmp_id='.$arFields['TMP_ID'], $arFields);

        //check $arFields['TMP_ID']
        if(intval($arFields['TMP_ID']) == 0)
        {
            self::Log('chenge on site, exit');
            //return true;
        }

        $arSections = self::getSectionTree();
		self::Log('sections = ', $arSections);

        $found = false; // раздел найден в структуре
		$is_new = intval($arFields['ID']) ? treu : false ; 
        $section_for_new = 1;
        $is_in_section_for_new = false;

        foreach($arSections as $s)
        {
            #is new element
			if($is_new && $arFields['IBLOCK_SECTION_ID'] == $s['ID'])
				$found = true;
				
			if($found == true && $s['ID'] == $section_for_new)
            {
                # раздел в находится в разделе для новых элементов
                $is_in_section_for_new = true;
                break;
            }

			#is NOT new section
            if(!$is_new && $arFields['ID'] == $s['ID'])
                $found = true;

            # if root section
            if(intval($s['IBLOCK_SECTION_ID']) == 0)
                break;
        }

		self::Log('is_in_section_for_new = ', $is_in_section_for_new);
		self::Log('IBLOCK_SECTION_ID = ', $arFields['IBLOCK_SECTION_ID']);

        # if section in not in for new
        if(!$is_in_section_for_new)
            $arFields['IBLOCK_SECTION_ID'] = $section_for_new;
			
		self::Log('IBLOCK_SECTION_ID = ', $arFields['IBLOCK_SECTION_ID']);

        return $arFields;
    }

}
?>