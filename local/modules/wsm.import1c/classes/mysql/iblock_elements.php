<?php

IncludeModuleLangFile(__FILE__);

class WsmImport1cIBlockElements extends WsmImport1cIBlockHelper
{
    function OnBeforeIBlockElementAddUpdateHandler(&$arFields)
    {
        $IBLOCK_ID = $arFields['IBLOCK_ID'];
        $CML2_ATTRIBUTES_ID = 0;

		//check $arFields['TMP_ID']
        if($_REQUEST['mode'] != 'import') //strlen($arFields['XML_ID']) == 0
        {
            self::Log('chenge on site, exit');
            return true;
        }

        if(!CModule::IncludeModule('iblock'))
            return;

		if($arFields['ID'])
			self::Log('ADD element Id='.$arFields['ID'].' name='.$arFields['NAME'].' tmp_id='.$arFields['TMP_ID']);
		else
			self::Log('UPDATE element Id='.$arFields['ID'].' name='.$arFields['NAME'].' tmp_id='.$arFields['TMP_ID']);

        #get settings
        $IBLOCK_TYPE = self::getIBlockType1C();

        self::Log('IBLOCK_TYPE = '.$IBLOCK_TYPE);

        //get iblock type for iblock
        if(!$arFields['IBLOCK_TYPE_ID'])
            $arFields["IBLOCK_TYPE_ID"] = self::getIBlockType ($arFields["IBLOCK_ID"]);

        self::Log('$arFields["IBLOCK_TYPE_ID"] = '.$arFields["IBLOCK_TYPE_ID"]);

        # is catalog 1C?
        #if($arFields['IBLOCK_TYPE_ID'] != $IBLOCK_TYPE)
        #    return true;

        self::Log('is 1C katalog');

        #запретить перенос между разделами при обновлении из 1С
        if(intval($arFields['ID']) > 0) //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        {
            self::Log('clear section');

            if(array_key_exists('IBLOCK_SECTION', $arFields))
                unset($arFields['IBLOCK_SECTION']); // список разделов

            if(array_key_exists('IBLOCK_SECTION_ID', $arFields))
                unset($arFields['IBLOCK_SECTION_ID']);
        }

        $update_dis_fields = self::getDisabledFields($IBLOCK_ID);
        $update_dis_prop = self::getDisabledProps($IBLOCK_ID);

        $characteristic_need_processing = self::getProperyNeedProcessing($IBLOCK_ID);

        self::Log('$update_dis_prop res = ', $update_dis_prop);

        if(!in_array($IBLOCK_ID, $_SESSION[self::SID]['IBLOCK_ID']))
            $_SESSION[self::SID]['IBLOCK_ID'][] = $IBLOCK_ID;

        #$_SESSION[self::SID]['IBLOCK_ID'] = $IBLOCK_ID;
        $_SESSION[self::SID]['IBLOCK_USED_PROPS'] = array();

        # ==========================================================================
        # disabled update fields
        # ==========================================================================
        if(count($update_dis_fields) && $arFields['ID'] > 0)
        {
            foreach($update_dis_fields as $field)
                if(array_key_exists($field, $arFields))
                    unset($arFields[$field]);
        }

        # ==========================================================================
        # update disabled props
        # ==========================================================================
        if(count($update_dis_prop) > 0)
        {
            $tmp_update_dis_prop = array();

            # ====================
            # check prop in iblock
            # ====================
            foreach($arFields['PROPERTY_VALUES'] as $index => $val)
            {
                if(in_array($index, $update_dis_prop))
                    $tmp_update_dis_prop[] = $index;
            }

            $update_dis_prop = $tmp_update_dis_prop;
            unset($tmp_update_dis_prop);
        }

        # ========================================
        #check: need save properies?
        # ========================================
        if(count($update_dis_prop) > 0)
        {
            # ==================================================
            # get props values from base and replace new values
            # ==================================================
            foreach($update_dis_prop as $prop_id)
                unset($arFields['PROPERTY_VALUES'][$prop_id]);

            $db_props = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array("sort" => "asc"), Array("ID" => $update_dis_prop));
            while($ar_props = $db_props->Fetch())
            {
                $arFields['PROPERTY_VALUES'][$ar_props['ID']][$ar_props['PROPERTY_VALUE_ID']] = array(
                    'VALUE' => $ar_props['VALUE'],
                    'DESCRIPTION' => $ar_props['DESCRIPTION'],
                );
            }

        }

        #===================================================================================================
        #get ID property CML2_ATTRIBUTES
        #===================================================================================================
        if(!isset($_SESSION[self::SID]['CML2_ATTRIBUTES_'.$IBLOCK_ID]) && $characteristic_need_processing == "Y")
        {
            self::Log('search CML2_ATTRIBUTES');

            $properties = CIBlockProperty::GetList(Array("sort"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID, "CODE" => 'CML2_ATTRIBUTES'));
            if ($prop_fields = $properties->GetNext())
            {
                $CML2_ATTRIBUTES_ID = $_SESSION[self::SID]['CML2_ATTRIBUTES_'.$IBLOCK_ID] = $prop_fields['ID'];
                if($CML2_ATTRIBUTES_ID == 0)
                {
                    self::Log('CML2_ATTRIBUTES not found');
                    return true;
                }
            }
        }
        elseif($characteristic_need_processing == "Y")
        {
            self::Log('CML2_ATTRIBUTES has in cache ');
            $CML2_ATTRIBUTES_ID = $_SESSION[self::SID]['CML2_ATTRIBUTES_'.$IBLOCK_ID];
        }

        self::Log('CML2_ATTRIBUTES ID = '.$CML2_ATTRIBUTES_ID);

        #==========================================================================================================
        # prop CML2_ATTRIBUTES processing
        #==========================================================================================================
        if($CML2_ATTRIBUTES_ID > 0 && $characteristic_need_processing == "Y")
        {
            self::Log('property CML2_ATTRIBUTES values array', $arFields['PROPERTY_VALUES'][$CML2_ATTRIBUTES_ID]);

            foreach($arFields['PROPERTY_VALUES'][$CML2_ATTRIBUTES_ID] as $index => $info)
            {
                //UTF
                $name = $info['DESCRIPTION'];
                $value = $info['VALUE'];

                if(strlen($name) <= 0)
                    continue;

                if(!isset($_SESSION[self::SID][$P][$name]))
                {
                    self::Log('search prop '. $name);

                    #search prop
                    $rsProp = CIBlockProperty::GetList(Array("sort"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID, "NAME" => $info['DESCRIPTION']));
                    if ($arProp = $rsProp->GetNext())
                    {
                        $arProp['VALUES'] = array();
                        #save prop in session
                        $PROP = $_SESSION[self::SID][$P][$name] = $arProp;
                    }
                }
                else
                {
                    #prop in cache
                    $PROP = $_SESSION[self::SID][$P][$name];
                    self::Log('prop in cache'. $name);

                    #if not values, create array
                    if(!isset($PROP['VALUES']))
                        $PROP['VALUES'] = array();
                }

                #Update field forbidden?
                if(in_array($PROP['ID'], $update_dis_prop) || $PROP['ID'] <= 0)
                    continue;

                #save used fields ID
                if(!in_array($PROP['ID'], $_SESSION[self::SID]['IBLOCK_USED_PROPS']))
                    $_SESSION[self::SID]['IBLOCK_USED_PROPS'][] = $PROP['ID'];


                switch($PROP['PROPERTY_TYPE'])
                {
                    case 'L':

                        if(!isset($PROP['VALUES'][$value]))
                        {
                            self::Log('get value from base');

                            $rs_enum_list = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID, "CODE"=>$PROP['CODE'], "VALUE"=>$info['VALUE']));
                            if($arEnum = $rs_enum_list->GetNext())
                            {
                                # if value founded
                                $ValueID = $arEnum['ID'];
                                self::Log('value founded ValueID =', $ValueID);
                            }
                            elseif($rs_enum_list->SelectedRowsCount() == 0)
                            {
                                # if value not founded, add new
                                $ibpenum = new CIBlockPropertyEnum;
                                $ValueID = $ibpenum->Add(Array('PROPERTY_ID'=>$PROP['ID'], 'VALUE'=>$info['VALUE']));
                                self::Log('add new value, ValueID =', $ValueID);
                            }

                            $_SESSION[self::SID][$P][$name]['VALUES'][$value] = $ValueID;
                        }
                        else
                        {
                            # get from cache
                            $ValueID = $_SESSION[self::SID][$P][$name]['VALUES'][$value];
                            self::Log('get value in cahce');
                        }

                        self::Log('name='.$name.' val='.$value.' val_id='.$ValueID);

                        break;

                    case 'E':
                    case 'G':

                        break;

                    case 'N':
                    case 'S':

                        $ValueID = $value;
                        break;

                    default:
                        $ValueID = $value;
                        break;
                }

                # multi
                $p_index = $PROP['MULTIPLE'] == 'N' ? 0 : count($arFields['PROPERTY_VALUES'][$PROP['ID']]);
                $arFields['PROPERTY_VALUES'][$PROP['ID']]['n'.$p_index] = $ValueID;

                //unset prop value
                unset($arFields['PROPERTY_VALUES'][$CML2_ATTRIBUTES_ID][$index]);
            }
        }

        self::Log('END UPDATE');

        return $arFields;
    }

    function OnSuccessCatalogImport1CHandler()
    {
        $remove_not_used_enums_characteristic_prop = COption::GetOptionString(self::MODULE_ID, 'remove_not_used_enums_characteristic_prop', '');

        #=============================================================================
        # remove not used enum values for props from charakteristik
        #=============================================================================
        if($remove_not_used_enums_characteristic_prop == 'Y' && CModule::IncludeModule('iblock'))
        {
            #!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $IBLOCK_ID = $_SESSION[self::SID]['IBLOCK_ID'];
            #!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

            self::Log('OnSuccessCatalogImport1CHandler remove not used enum');
            self::Log('used prop = ', $_SESSION[self::SID]['IBLOCK_USED_PROPS']);

            foreach($_SESSION[self::SID]['IBLOCK_USED_PROPS'] as $prop_id)
            {
                $arPropFilter = Array(
                    "ID"            => $prop_id,
                    //"IBLOCK_ID"     =>  $IBLOCK_ID,
                    "PROPERTY_TYPE" => 'L',
                    "ACTIVE"        => "Y",
                );

                //search prop
                $rsProp = CIBlockProperty::GetList(array(), $arPropFilter);

                if ($arProp = $rsProp->GetNext())
                {
                    self::Log('get enum for '.$arProp['ID'].' '.$arProp['NAME']);


                    $rs_enum_list = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arProp["IBLOCK_ID"], "PROPERTY_ID"=>$arProp['ID']));
                    while($arEnum = $rs_enum_list->GetNext())
                    {
                        $arSelect = array("ID","IBLOCK_ID", "PROPERTY_".$arProp['ID']);

                        $arFilter = Array(
                            "IBLOCK_ID"               => $arProp['IBLOCK_ID'],
                            "PROPERTY_".$arProp['ID'] => $arEnum['ID'],
                        );

                        $rsElements = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                        if (intval($rsElements->SelectedRowsCount())==0)
                        {
                            self::Log('search - not found - remove enum '.$arEnum['ID']);
                            $Cenum = new CIBlockPropertyEnum;
                            $Cenum->Delete($arEnum['ID']);
                        }
                    }
                }
            }
        }

        # =====================================================================================
        # inform
        # =====================================================================================

        self::Log('Inform', $_SESSION[self::SID]);

        if(!empty($_SESSION[self::SID]['IBLOCK_ID']) && is_array($_SESSION[self::SID]['IBLOCK_ID']))
        {
            foreach($_SESSION[self::SID]['IBLOCK_ID'] as $iblock_id)
            {
                $email = COption::GetOptionString(self::MODULE_ID, 'user_sructure_inform_ib'.$iblock_id, '');
                $section_id = self::getSectionForNew ($iblock_id);

                if(trim($email)=='' || $section_id == 0)
                    continue;

                $ELEMENTS = array();
                $arSelect = Array("ID", "IBLOCK_ID", "NAME", "IBLOCK_SECTION_ID");
                $arFilter = Array(
                    "IBLOCK_ID"             =>  $iblock_id,
                    "SECTION_ID"            =>  $section_id,
                    "INCLUDE_SUBSECTIONS"   =>  "Y",
                    );

                $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                while($el = $res->GetNext())
                    $ELEMENTS[$el['IBLOCK_SECTION_ID']][] = $el;

                $data = '';

                if($res->SelectedRowsCount() > 0)
                {
                    $arSections = self::getSectionTree($iblock_id);

                    if(count($ELEMENTS) > 0)
                    {
                        foreach($ELEMENTS as $section_id => $elements)
                        {
                            $data .= GetMessage('WSM_IMPORT1C_EVENT_F_SECTION').': '.$arSections[$section_id]['NAME'].' ( '.GetMessage('WSM_IMPORT1C_EVENT_F_ALL_COUNT').' '.count($elements).')'.chr(13).chr(13);

                            foreach($elements as $el)
                                $data .= $el['ID'].' '.$el['NAME'].chr(13);

                            $data .= '--------------------------'.chr(13).chr(13);
                        }

                    }

                    $arEventFields = array(
                        'EMAIL' => $email,
                        'THEME' => GetMessage('WSM_IMPORT1C_EVENT_F_THEME'),
                        'DATA'  => $data
                        );

                    CEvent::Send("WSM_IMPORT1C_STRUCTURE_NEW", 's1', $arEventFields);
                }

            }
        }

        self::clearCashe();
    }
}