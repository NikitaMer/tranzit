<?php

namespace WSM\Import1c;

use Bitrix\Main;
use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

use Bitrix\Main\Data\Cache;

Loc::loadMessages(__FILE__);

class Price
{
	
	const MODULE_ID = 'wsm.import1c';
	const CACHE_TIME = 36000;
	
    const SECT_CACHE_ID = 'wsm_import1c_sections_';
    const SECT_CACHE_DIR = '/import1c/sections';
	
	const RULES_CACHE_ID = 'wsm_import1c_sections_';
    const RULES_CACHE_DIR = '/import1c/rules';
	
	const DEBUG = false;

    private static $last_section_id = 0;
    public static $is_rules_update = false;

	
    public function log()
    {
        if(!self::DEBUG)
            return false;

        $arArgs = func_get_args();
        $trace = debug_backtrace();
        $trace = $trace[1];

        $sResult = $trace['class'].'::'.$trace['function'].', line: '.$trace['line']. ' do: ';

        foreach($arArgs as $arArg)
            $sResult .= print_r($arArg, true).' / ';

        $sResult = date('H:i:s ').$sResult.chr(13);

        $hfile = fopen($_SERVER['DOCUMENT_ROOT'].'/local/import1c_price-'.date('Y-m-d').".log","a");
        fwrite($hfile, $sResult);
        fclose($hfile);
    }

	public static function OnAfterIBlockSectionAddHandler($arFields)
	{
		if($arFields["ID"]>0)
		{
			self::clearSectionCache($arFields["IBLOCK_ID"]);
			self::log('OnAfterIBlockSectionAdd');
		}
	}

	public static function OnAfterIBlockSectionUpdateHandler($arFields)
	{
		if($arFields["RESULT"])
		{
            self::log('OnAfterIBlockSectionUpdate');
            self::clearSectionCache($arFields["IBLOCK_ID"]);
		}
	}

	function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        if(strlen($arFields["CODE"])<=0)
        {
            self::log('OnBeforeIBlockElementUpdate', $arFields);

            static::$last_section_id = $arFields['IBLOCK_SECTION_ID'];
			
			// TODO: определение раздела
        }
    }

    function OnAfterIBlockElementUpdateHandler(&$arFields)
    {
        if($arFields["RESULT"])
		{
			self::log('OnAfterIBlockElementUpdate', $arFields);

            // TODO: если раздел изменился, то получаем правила и меняем цены

            if(static::$last_section_id != $arFields['IBLOCK_SECTION_ID'])
            {
                self::log('OnAfterIBlockElementUpdate', 'Раздел изменился');
            }
			

		}
    }

    function OnAfterIBlockElementAddHandler(&$arFields)
    {
        if($arFields["ID"]>0)
		{
			self::log('OnAfterIBlockElementAdd', $arFields);
		}
    }

    public static function OnBeforePriceUpdateHandler($ID, $arFields)
    {
        //self::log('OnBeforePriceUpdate *********************** is_rules_update=', static::$is_rules_update, $ID, $arFields['PRICE']);

        //$aPriceFields = \CPrice::GetByID($ID);

        /*
        if($aPriceFields['PRODUCT_ID'] == 3033 && $ID == 11925)
        {
            #self::log('OnBeforePriceUpdate *********************** ', static::$is_rules_update, 'Цена = ' . $ID, $aPriceFields['PRICE']);

            #====================================
            # поиск раздела товара
            #====================================
            $rsElem = \Bitrix\Iblock\ElementTable::getList(array(
                'filter' => array(
                    'ID' => $aPriceFields['PRODUCT_ID'],
                ),
                'select' => array('ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'NAME')
            ));

            if ($aElement = $rsElem->fetch()) {

                //self::log('OnBeforePriceUpdate $aElement=', $aElement);

                # получение правил формирования цен
                $aRules = array();

                $aRules = \Wsm\Import1c\Price::getSectionPriceRule($aElement['IBLOCK_ID'], $aElement['IBLOCK_SECTION_ID']);

                //self::log('OnBeforePriceUpdate $aRules = ', $aRules);

                foreach($aRules as $r)
                {
                    self::log('OnBeforePriceUpdate $aRules = ', static::$is_rules_update, $aPriceFields['CATALOG_GROUP_ID'], $r['PRICE_ID_TO']);

                    if($aPriceFields['CATALOG_GROUP_ID'] == $r['PRICE_ID_TO'] && !static::$is_rules_update) // && !(boolean)static::$is_rules_update
                    {
                        self::log('Цена найдена в правилах', 'Цена = '.$ID, $arFields);
                        static::$is_rules_update = false;
                        return $arFields;
                    }

                }

                return $arFields;

            }
            else
            {
                self::log('Товар не найден !!!!!!!!!!!!!!!');
            }
        }*/

        return $arFields;
    }

	public static function OnPriceUpdateHandler($ID, $arFields)
	{
        /*
        PRODUCT_ID - код товара;
        EXTRA_ID - код наценки;
        CATALOG_GROUP_ID - код типа цены;
        PRICE
        */

        if($arFields['PRODUCT_ID'] == 3033)
        {
            self::log('OnPriceUpdate >>>>>>>>>>>>>>>>> ', 'Цена = '.$ID, $arFields['CATALOG_GROUP_ID'], $arFields['PRICE']);

            #====================================
            # поиск раздела товара
            #====================================
            $rsElem = \Bitrix\Iblock\ElementTable::getList(array(
                'filter' => array(
                    'ID' => $arFields['PRODUCT_ID'],
                ),
                'select' => array('ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'NAME')
            ));

            if($aElement = $rsElem->fetch())
            {
                //self::log('OnPriceUpdate $aElement=', $aElement);

                # получение правил формирования цен
                $aRules = array();

                $aRules = \Wsm\Import1c\Price::getSectionPriceRule($aElement['IBLOCK_ID'], $aElement['IBLOCK_SECTION_ID']);

                //self::log('OnPriceUpdate aRules=', $aRules);

                if(!empty($aRules))
                {
                    foreach($aRules as $r)
                    {
                        if($arFields['CATALOG_GROUP_ID'] == $r['PRICE_ID_FROM'] && $arFields['CATALOG_GROUP_ID'] != $r['PRICE_ID_TO'])
                        {
                            $price = 0;

                            if($r['MARGE_TYPE'] == \Wsm\Import1c\Price\RulesTable::MARGIN_PERSENT)
                                $price = $arFields['PRICE'] + ceil($arFields['PRICE'] * $r['VALUE'] / 100);
                            elseif($r['MARGE_TYPE'] == \Wsm\Import1c\Price\RulesTable::MARGIN_ABSOLUTE)
                                $price = $arFields['PRICE'] + $r['VALUE'];

                            static::$is_rules_update = true;

                            $arPriceFields=array(
                                'PRODUCT_ID'        => $arFields["PRODUCT_ID"],
                                'CATALOG_GROUP_ID'  => $r['PRICE_ID_TO'],
                                'PRICE'             => (float)$price,
                                'CURRENCY'          => $arFields["CURRENCY"],
                                //"QUANTITY_FROM"     => false,
                                //"QUANTITY_TO"       => false,
                                "EXTRA_ID"          => ''
                                );

                            self::log('OnPriceUpdate price=', $price, 'PRICE_ID = '.$r['PRICE_ID_TO']);

                            $res = \CPrice::GetList(
                                array(),
                                array(
                                    "PRODUCT_ID"        => $arFields["PRODUCT_ID"],
                                    "CATALOG_GROUP_ID"  => $r['PRICE_ID_TO']
                                )
                            );

                            if ($arPrice = $res->Fetch())
                            {
                                self::log('OnPriceUpdate Цена найдена', $arPrice["ID"], static::$is_rules_update);
                                $rs = \CPrice::Update($arPrice["ID"], array('PRICE'=>$price));
                            }
                            else
                            {
                                self::log('OnPriceUpdate Цена НЕ найдена', static::$is_rules_update);

                                $obPrice = new \CPrice();
                                $rs = $obPrice->Add($arPriceFields);
                            }

                            //static::$is_rules_update = false;

                            //self::log('OnPriceUpdate, GetException = ', $GLOBALS['APPLICATION']->GetException());


                        }
                    }
                }
            }

        }

	}

	public function changePrice($element_id, array $aRules)
	{
		
	}

	private function getSectionsCasheID($iblock_id)
	{
		return self::SECT_CACHE_ID.$iblock_id;
	}

	private function getRulesCasheID($iblock_id)
	{
		return self::RULES_CACHE_ID.$iblock_id;
	}

	public static function getSectionTree($iblock_id, $sort = 'asc')
	{
		//self::clearSectionCache($iblock_id);

        $sort = strtolower($sort) == 'asc' ? 'asc' : 'desc';
		
        //$start_time = microtime();
		
		$cache_id = self::getSectionsCasheID($iblock_id.'_'.$sort);
        $sections = array();

		$CCahce = Cache::createInstance();

		if($CCahce->initCache(self::CACHE_TIME, $cache_id, self::SECT_CACHE_DIR))
		{
			$sections = $CCahce->getVars();
			//echo 'cache';
		}
		else
		{
			$CCahce->startDataCache(self::CACHE_TIME, $cache_id, self::SECT_CACHE_DIR);

			if(\Bitrix\Main\Loader::includeModule("iblock"))
			{
				$arFilter = array(
					'IBLOCK_ID' => $iblock_id,
                    'ACTIVE' => 'Y',
                    'GLOBAL_ACTIVE' => 'Y',
					);
					
				$rsSect = \CIBlockSection::GetList(
                    array("left_margin"=>$sort),
                    $arFilter,
                    false,
                    array('ID', 'ACTIVE', 'NAME', 'DEPTH_LEVEL', 'LEFT_MARGIN', 'RIGHT_MARGIN', 'IBLOCK_SECTION_ID')
                );

				while($aSection = $rsSect->GetNext(false, false))
				{
					$sections[] = $aSection;
				}
			}
			
			$CCahce->EndDataCache($sections);
		}

        //echo (microtime() - $start_time);

        return $sections;
	}
	
	public static function getRules($iblock_id, array $sections = array())
	{
		self::clearRulesCache($iblock_id);
		
		$cache_id = self::getRulesCasheID($iblock_id.implode('',$sections));
        $rules = array();

		$CCahce = Cache::createInstance();

		if($CCahce->initCache(self::CACHE_TIME, $cache_id, self::RULES_CACHE_DIR))
		{
			$rules = $CCahce->getVars();
		}
		else
		{
			$CCahce->startDataCache(self::CACHE_TIME, $cache_id, self::RULES_CACHE_DIR);

			$rs = Price\RulesTable::getList(array('filter' => array(
				'IBLOCK_ID' => $iblock_id,
				'SECTION_ID' => $sections,
				'ACTIVE' => 'Y'
				)));
				
			while($aRule = $rs->fetch())
			{
				if($aRule['SUB_SECTIONS'] == 'Y'){}

				$rules[$aRule['SECTION_ID']][] = $aRule;
			}
		
			$CCahce->EndDataCache($rules);
		}

        return $rules;
	}

    public function inSection($iblock_id, $searchable_section_id, $need_section_id)
    {
        $iblock_id = intval($iblock_id);
        $searchable_id = intval($searchable_section_id);
        $need_id = intval($need_section_id);

        $arSections = self::getSectionTree($iblock_id, 'desc');

        $found = false; // раздел найден в структуре

        foreach($arSections as $s)
        {
            #echo str_repeat(' .', $s['DEPTH_LEVEL']).' '.$s['NAME'].'<br>';

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
	
	
	public static function getSectionPriceRule($iblock_id, $section_id)
	{
		$aRules = array();
        $aSectionsID = array($section_id);

        $arSections = self::getSectionTree($iblock_id, 'desc');

		$found = false;
		$found_level = null;
		
        foreach($arSections as $s)
        {
            # сначало ищем раздел
            if(!$found && $section_id == intval($s['ID']))
			{
				$found_level = $s['DEPTH_LEVEL'];
				$found = true;
				
				continue;
			}

			if(!$found || $s['DEPTH_LEVEL'] > $found_level)
				continue;

            #если раздел найден, собираем все разделы вверх по иерархи
            if($found == true && $found_level > $s['DEPTH_LEVEL'])
            {
                $aSectionsID[] = $s['ID'];
            }

            if($found == true && intval($s['IBLOCK_SECTION_ID']) == 0)
                break;

        }

		$aRules = self::getRules($iblock_id, $aSectionsID);

        #_print_r($aSectionsID);
        #_print_r($arSections);
        #_print_r($aRules);

        $rules = array();

        //echo 'price search: '.$section_id.'<br>';
		$found = false;
		
		
		#============================================
		# ищем правила
		#============================================
		
        foreach($arSections as $s)
        {
			if(!in_array($s['ID'], $aSectionsID))
				continue;
			
			#echo "исследуем > ".str_repeat('. ',$s['DEPTH_LEVEL']-1).$s['NAME']." L=".$s['DEPTH_LEVEL']."<br>";
			
			if(array_key_exists($s['ID'], $aRules))
			{
				#echo "для ".$s['NAME']." правила есть <br>";
				
				foreach($aRules[$s['ID']] as $index => $r)
				{
					$code = $r['PRICE_ID_FROM'].$r['PRICE_ID_TO'];

					#_print_r($r);					
					#echo "код = ".$code."<br>";
					
					if(($r['SECTION_ID'] == $section_id || $r['SUB_SECTIONS'] == 'Y') && !array_key_exists($code, $rules))
						$rules[$code] = $r;
				}
			}
		
        }
		
		return $rules;
		
	}
	
	public static function clearSectionCache($iblock_id)
	{
		#$cache_id = self::getSectionsCasheID($iblock_id);

		$CCahce = Cache::createInstance();
		$CCahce->cleanDir(self::SECT_CACHE_DIR);		
	}
	
	public static function clearRulesCache($iblock_id)
	{
		#$cache_id = self::getRulesCasheID($iblock_id);

		$CCahce = Cache::createInstance();
		$CCahce->cleanDir(self::RULES_CACHE_DIR);		
	}
	
	
}