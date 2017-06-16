<?php


class WsmImport1cIBlockHelper
{
    const MODULE_ID = 'wsm.import1c';
    const SID = 'wsm_import1c';

    const IS_OFFER = 'OFFER';
    const IS_PRODUCT = 'PRODUCT';


    function Log()
    {
        return true;

        $path = dirname(__FILE__).'/1c-import-'.date('Y-m-d').'.log'; 

        $arArgs = func_get_args();
		
		$trace = debug_backtrace();
        $trace = $trace[1];

        $sResult = $trace['class'].'::'.$trace['function'].', line: '.$trace['line'].': ';

        foreach($arArgs as $arArg)
            $sResult .= print_r($arArg, true).' / ';

        $sResult = date('H:i:s  ').$sResult.chr(13)."----".chr(13);

        $hfile = fopen($path, "a");
        fwrite($hfile, $sResult);
        fclose($hfile);
        return true;
    }

    function getIBlockType1C ()
    {
        if(!isset($_SESSION[self::SID]['IBLOCK_TYPE']))
        {
            self::Log('detect IBLOCK_TYPE');

            //get iblock type from options

            $IBLOCK_TYPE = COption::GetOptionString('catalog', "1C_IBLOCK_TYPE", "-");

            #iblock type not set
            if($IBLOCK_TYPE == '-')
            {
                //if iblock type not set
                $rsType = CIBlockType::GetByID("1c_catalog");
                if($arType = $rsType->Fetch())
                    $IBLOCK_TYPE = $arType["ID"];
            }

            $_SESSION[self::SID]['IBLOCK_TYPE'] = $IBLOCK_TYPE;
        }
        else
        {
            $IBLOCK_TYPE = $_SESSION[self::SID]['IBLOCK_TYPE'];
        }

        //self::Log('getIBlockType1C', $IBLOCK_TYPE);
        return $IBLOCK_TYPE;
    }



    function getIBlockType ($iblock_id)
    {
        self::Log('get iblock for ', $iblock_id);

        $type = '';

        if(isset($_SESSION[self::SID]['TYPE_OF_IBLOCK_ID']))
        {
            if(isset($_SESSION[self::SID]['TYPE_OF_IBLOCK_ID'][$iblock_id]))
                $type = trim($_SESSION[self::SID]['TYPE_OF_IBLOCK_ID'][$iblock_id]);
        }

        if(strlen($type) > 0)
            return $type;

        $res = CIBlock::GetByID($iblock_id);
        if($ar_res = $res->fetch())
            $type = $_SESSION[self::SID]['TYPE_OF_IBLOCK_ID'][$iblock_id] = $ar_res['IBLOCK_TYPE_ID'];

        return $type;
    }

    function getIBlockUse($iblock_id)
    {
        if(!CModule::IncludeModule('catalog'))
            return;

        $mxResult = CCatalogSKU::GetInfoByOfferIBlock($iblock_id);
        if(is_array($mxResult))
            return self::IS_OFFER;
        else
            return self::IS_PRODUCT;
    }


    function getSectionTree($iblock_id)
    {
        $arSections = array();

        if(!isset($_SESSION[self::SID]['SECTIONS_PRODUCT_BLOCK'][$iblock_id]))
        {

            if(!CModule::IncludeModule('iblock'))
                return $arSections;

            $arFilter = array(
                'IBLOCK_ID' => intval($iblock_id),
                );

            $rs = CIBlockSection::GetList(Array("left_margin"=>"desc"), $arFilter);
            while($s = $rs->GetNext())
            {
                $arSections[$s['ID']] = array(
                    'ID' => $s['ID'],
                    'IBLOCK_ID' => $s['IBLOCK_ID'],
                    'NAME' => $s['NAME'],
                    'IBLOCK_SECTION_ID' => $s['IBLOCK_SECTION_ID'],
                    'DEPTH_LEVEL' => $s['DEPTH_LEVEL'],
                    );
            }

            $_SESSION[self::SID]['SECTIONS_PRODUCT_BLOCK'][$iblock_id] = $arSections;

        }

        return $_SESSION[self::SID]['SECTIONS_PRODUCT_BLOCK'][$iblock_id];
    }

    function CheckSectionInSection($iblock_id, $searchable_id, $need_id)
    {
        $iblock_id = intval($iblock_id);
        $searchable_id = intval($searchable_id);
        $need_id = intval($need_id);

        $arSections = self::getSectionTree($iblock_id);

        $found = false; // раздел найден в структуре

        foreach($arSections as $s)
        {
            if($searchable_id == intval($s['ID']))
                $found = true;

            if($found == true && intval($s['ID']) == $need_id)
            {
                # раздел в находится в разделе для новых элементов
                return true;
            }

            # if up to root section
            if($found == true && intval($s['IBLOCK_SECTION_ID']) == 0)
                break;
        }

        return false;
    }

    function getSectionForNew ($iblock_id)
    {
        if(!isset($_SESSION[self::SID]['SECTION_1C'][$iblock_id]))
        {
            //$user_sructure  = COption::GetOptionString($module_id, 'user_sructure', '');
            $_SESSION[self::SID]['SECTION_1C'][$iblock_id] = COption::GetOptionString(self::MODULE_ID, 'user_sructure_section_1c_ib'.$iblock_id, 0);
        }

        return $_SESSION[self::SID]['SECTION_1C'][$iblock_id];
    }

    function getProperyNeedProcessing($iblock_id)
    {
        if(!isset($_SESSION[self::SID]['ATTR_POCESSING'][$iblock_id]))
        {
            $USE_AS = self::getIBlockUse($iblock_id); //$arFields["IBLOCK_ID"]

            if($USE_AS == self::IS_OFFER)
                $_SESSION[self::SID]['ATTR_POCESSING'][$iblock_id] = COption::GetOptionString(self::MODULE_ID, 'characteristic_processing_offer_ib'.$iblock_id, '');
            elseif($USE_AS == self::IS_PRODUCT)
                $_SESSION[self::SID]['ATTR_POCESSING'][$iblock_id] = COption::GetOptionString(self::MODULE_ID, 'characteristic_processing_product_ib'.$iblock_id, '');

        }

        return $_SESSION[self::SID]['ATTR_POCESSING'][$iblock_id] == 'Y' ? true : false ;
    }


    function getDisabledFields($iblock_id)
    {
        if(!isset($_SESSION[self::SID]['DISABLED_FIELDS'][$iblock_id]) || !is_array($_SESSION[self::SID]['DISABLED_FIELDS'][$iblock_id]))
        {
            $update_dis = COption::GetOptionString(self::MODULE_ID, 'update_dis_fields_ib'.$iblock_id, '');
            $_SESSION[self::SID]['DISABLED_FIELDS'][$iblock_id] = trim($update_dis) == '' ? array() :  explode(',', $update_dis);
        }

        return $_SESSION[self::SID]['DISABLED_FIELDS'][$iblock_id];
    }

    function getDisabledProps($iblock_id)
    {
        if(!isset($_SESSION[self::SID]['DISABLED_PROPS'][$iblock_id]) || !is_array($_SESSION[self::SID]['DISABLED_PROPS'][$iblock_id]))
        {
            $update_dis = COption::GetOptionString(self::MODULE_ID, 'update_dis_prop_ib'.$iblock_id, '');
            $_SESSION[self::SID]['DISABLED_PROPS'][$iblock_id] = trim($update_dis) == '' ? array() :  explode(',', $update_dis);
        }

        return $_SESSION[self::SID]['DISABLED_PROPS'][$iblock_id];
    }

    public static function clearCashe($code = '')
    {
        if($code == '')
            unset($_SESSION[self::SID]);
        else
            unset($_SESSION[self::SID][$code]);
    }

}