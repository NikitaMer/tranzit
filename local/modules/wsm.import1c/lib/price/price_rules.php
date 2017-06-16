<?php

namespace WSM\Import1c\Price;

use Bitrix\Main;
use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);


class RulesTable extends  Entity\DataManager
{
    const MARGIN_ABSOLUTE = 'A';
    const MARGIN_PERSENT = 'P';

    public static function getFilePath()
    {
        return __FILE__;
    }

    public static function getTableName()
    {
        return 'b_wsm_import_1c_pricerules';
    }

    public static function getMap()
    {
        /*
        DATE_CREATE datetime, WSM_IMPORT1C_RULES_F_DATE_CREATE
        DATE_CHANGE timestamp, WSM_IMPORT1C_RULES_F_DATE_CHANGE
        */

        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                ),

            'ACTIVE' => array(
                'data_type' => 'boolean',
                'required' => true,
                'title' => Loc::getMessage("WSM_IMPORT1C_RULES_F_ACTIVE"),
                'values' => array('Y','N'),
                ),

            'IBLOCK_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => Loc::getMessage("WSM_IMPORT1C_RULES_F_IBLOCK_ID"),
                ),

            'IBLOCK' => array(
                'data_type' => 'Bitrix\Iblock\IblockTable',
                'reference' => array('=this.IBLOCK_ID' => 'ref.LID'),
            ),

            'SECTION_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => Loc::getMessage("WSM_IMPORT1C_RULES_F_SECTION_ID"),
                ),

            'SECTION' => array(
                'data_type' => 'Bitrix\Iblock\SectionTable',
                'reference' => array('=this.SECTION_ID' => 'ref.LID'),
                ),

            'SUB_SECTIONS' => array(
                'data_type' => 'boolean',
                'required' => true,
                'title' => Loc::getMessage("WSM_IMPORT1C_RULES_F_SUB_SECTIONS"),
                'values' => array('Y','N'),
                ),

            'PRICE_ID_FROM' => array(
                'data_type' => 'integer',
                'required' => true,
				'title' => Loc::getMessage("WSM_IMPORT1C_RULES_F_PRICE_ID_FROM"),
                ),

            'PRICE_ID_TO' => array(
                'data_type' => 'integer',
                'required' => true,
				'title' => Loc::getMessage("WSM_IMPORT1C_RULES_F_PRICE_ID_TO"),
                ),

            'MARGE_TYPE' => array(
                'data_type' => 'boolean',
                'required' => true,
                'values' => array_keys(self::getMargeType()),
				'title' => Loc::getMessage("WSM_IMPORT1C_RULES_F_MARGE_TYPE"),
                ),

            'VALUE' => array(
                'data_type' => 'float',
                'required' => true,
				'title' => Loc::getMessage("WSM_IMPORT1C_RULES_F_VALUE"),
            ),
        );
    }

    protected function ProcessFields($arFields, $need = false)
    {
        $changedFields = array();

        $arFloatFields = array(
            'VALUE',
            );

        foreach($arFloatFields as $F)
        {
            if(array_key_exists($F, $arFields))
            {
                $a = str_replace(',', '.', $arFields[$F]);
                $a = round(abs($a),2);

                if($arFields[$F] != $a)
                    $changedFields[$F] = $a;
            }
        }

        return $changedFields;
    }

    protected function mCheckFields($arFields, $add = false)
    {
        $errors = array();
        $result = new Entity\Result();
        $changed_fields = array();

        if(array_key_exists('MARGE_TYPE', $arFields) || $add)
        {
            if(!array_key_exists($arFields['MARGE_TYPE'], self::getMargeType()))
                $errors[] = new Entity\EntityError(Loc::getMessage("programm_marge_not_correct"));
        }

        if(array_key_exists('VALUE', $arFields) || $add)
        {
            if($arFields['VALUE'] == 0)
                $errors[] = new Entity\EntityError(Loc::getMessage("programm_marge_value_not_correct"));
        }

        if($arFields['PRICE_ID_FROM'] == $arFields['PRICE_ID_TO'])
            $errors[] = new Entity\EntityError(Loc::getMessage("programm_prices_not_correct"));



        if(!empty($errors))
            $result->addErrors($errors);
        else
            $result->setData($changed_fields);

        return $result;
    }


    public static function OnBeforeAdd(Entity\Event $event)
    {
        $result = new Entity\EventResult();

        $errors = array();
        $fields = $event->getParameter('fields');

        //process fields
        $changedFields1 = self::ProcessFields($fields);

        //check fields
        $res = self::mCheckFields($fields, true);
        if($res->getErrorMessages())
        {
            foreach($res->getErrorMessages() as $err)
                $errors[] = new Entity\EntityError($err);
        }
        else
        {
            $changedFields2 = $res->getData();
        }


        if(!empty($errors))
        {
            $result->setErrors($errors);
        }
        else
        {
            //merge changedFields
            $changedFields = array_merge($changedFields1, $changedFields2);

            $result->modifyFields($changedFields);
            //$result->unsetFields($unsetFields);
        }

        return $result;
    }

    public static function OnBeforeUpdate(Entity\Event $event)
    {
        $result = new Entity\EventResult();

        $errors = array();
        $fields = $event->getParameter('fields');

        //process fields
        $changedFields1 = self::ProcessFields($fields);

        //check fields
        $res = self::mCheckFields($fields, false);
        if($res->getErrorMessages())
        {
            foreach($res->getErrorMessages() as $err)
                $errors[] = new Entity\EntityError($err);
        }
        else
        {
            $changedFields2 = $res->getData();
        }

        $unsetFields = array('DATE_CREATE');


        if(!empty($errors))
        {
            $result->setErrors($errors);
        }
        else
        {
            //merge changedFields
            $changedFields = array_merge($changedFields1, $changedFields2);

            $result->modifyFields($changedFields);
            $result->unsetFields($unsetFields);
        }

        return $result;
    }

    public static function getMargeType()
    {
        return array(
            self::MARGIN_ABSOLUTE => Loc::getMessage("WSM_IMPORT1C_RULES_MARGIN_ABSOLUTE"),
            self::MARGIN_PERSENT => Loc::getMessage("WSM_IMPORT1C_RULES_MARGIN_PERSENT"),
            );
    }
	


}

