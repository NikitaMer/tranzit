<?
$module_id = 'wsm.import1c';

IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/options.php');
IncludeModuleLangFile(__FILE__);

$MODULE_RIGHT = $APPLICATION->GetGroupRight($module_id);

if(!CModule::IncludeModule('iblock') || !CModule::IncludeModule($module_id) || !CModule::IncludeModule('catalog'))
    return;


if ($MODULE_RIGHT >='R'):

    $aTabs = array( 
        array(
            'DIV' => 'tab1',
            'TAB' => GetMessage('WSM_IMPORT1C_OPT_TAB_STRUCTURE'),
            'ICON' => 'wsm_import1c_settings',
            'TITLE' => GetMessage('WSM_IMPORT1C_OPT_TAB_STRUCTURE_TITLE')
            ),
        array(
            'DIV' => 'tab_iblock',
            'TAB' => GetMessage('WSM_IMPORT1C_OPT_TAB_IBLOCK'),
            'ICON' => 'wsm_import1c_iblock',
            'TITLE' => GetMessage('WSM_IMPORT1C_OPT_TAB_IBLOCK_TITLE')
            ),
        array(
            'DIV' => 'tab_right',
            'TAB' => GetMessage('WSM_IMPORT1C_OPT_TAB_RIGHT'),
            'ICON' => 'wsm_import1c_right',
            'TITLE' => GetMessage('WSM_IMPORT1C_OPT_TAB_RIGHT_TITLE')
            )
        );

    $tabControl = new CAdminTabControl('tabControl', $aTabs);

    $arIB = array();
    $arIB_OFFERS = array();

    $arIB_FIELDS = array(
        'NAME'          => GetMessage('WSM_IMPORT1C_IB_F_NAME'),
		'CODE'          => GetMessage('WSM_IMPORT1C_IB_F_CODE'),
        'ACTIVE'        => GetMessage('WSM_IMPORT1C_IB_F_ACTIVE'),

        'PREVIEW_TEXT'  => GetMessage('WSM_IMPORT1C_IB_F_PREVIEW_TEXT'),
        'DETAIL_TEXT'   => GetMessage('WSM_IMPORT1C_IB_F_DETAIL_TEXT'),

        'PREVIEW_PICTURE' => GetMessage('WSM_IMPORT1C_IB_F_PREVIEW_PICTURE'),
        'DETAIL_PICTURE'  => GetMessage('WSM_IMPORT1C_IB_F_DETAIL_PICTURE'),
        );

    $arIB_PROPS = array();
    $arIB_SECTIONS = array();

    $IBLOCK_TYPE = WsmImport1cIBlockHelper::getIBlockType1C();

    $res = CIBlock::GetList(array(), array('TYPE'=>$IBLOCK_TYPE),true);
    while($ar = $res->Fetch())
    {
        $mxResult = CCatalogSKU::GetInfoByOfferIBlock($ar['ID']);

        #=========================================
        # $arIB_PROPS
        #=========================================
        $rsProp = CIBlockProperty::GetList(Array("sort"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$ar['ID']));
        while ($arProp = $rsProp->GetNext())
            $arIB_PROPS[$ar['ID']][] = $arProp;

        #=========================================
        # $arIB_SECTIONS
        #=========================================

        if(is_array($mxResult))
        {
            $arIB_OFFERS[$mxResult['PRODUCT_IBLOCK_ID']][$ar['ID']] = $ar;
        }
        else
        {
            $arIB[$ar['ID']] = $ar;

            $arFilter = array(
                'IBLOCK_ID' => $ar['ID'],
                'DEPTH_LEVEL' => 1,
                );

            $rs = CIBlockSection::GetList(Array("left_margin"=>"asc"), $arFilter);
            while($s = $rs->GetNext())
            {
                $arIB_SECTIONS[$ar['ID']][$s['ID']] = array(
                    'ID' => $s['ID'],
                    'NAME' => $s['NAME'],
                    'IBLOCK_SECTION_ID' => $s['IBLOCK_SECTION_ID'],
                    'DEPTH_LEVEL' => $s['DEPTH_LEVEL'],
                );
            }
        }


    }



    if($REQUEST_METHOD=='POST' && strlen($Update.$Apply.$RestoreDefaults)>0 && $MODULE_RIGHT >= 'W' && check_bitrix_sessid())
    {
        if(strlen($RestoreDefaults)>0)
        {
            COption::RemoveOption($module_id);
            $APPLICATION->DelGroupRight($module_id);
        }
        else
        { 
            foreach($arIB as $IBLOCK_ID => $ib)
            {

                # =================================================================================
                # structure settings
                # =================================================================================
                $user_sructure = $user_sructure_ib[$IBLOCK_ID] == 'Y' ? 'Y' : 'N' ;
                $user_sructure_section_1c = $user_sructure_ib[$IBLOCK_ID] == 'Y' ? intval($user_sructure_section_1c_ib[$IBLOCK_ID]) : 0 ;
                $user_sructure_inform = htmlspecialchars($user_sructure_inform_ib[$IBLOCK_ID]);

                COption::SetOptionString($module_id, 'user_sructure_ib'.$IBLOCK_ID, $user_sructure, '');
                COption::SetOptionInt($module_id, 'user_sructure_section_1c_ib'.$IBLOCK_ID, $user_sructure_section_1c, '');
                COption::SetOptionString($module_id, 'user_sructure_inform_ib'.$IBLOCK_ID, $user_sructure_inform, '');

                # =================================================================================
                #iblock settings
                # =================================================================================
                $characteristic_processing_product = $characteristic_processing_product_ib[$IBLOCK_ID] == 'Y' ? 'Y' : 'N' ;
                $characteristic_processing_offer = $characteristic_processing_offer_ib[$IBLOCK_ID] == 'Y' ? 'Y' : 'N' ;
                $remove_not_used_enums_characteristic_prop = $remove_not_used_enums_characteristic_prop_ib[$IBLOCK_ID] == 'Y' ? 'Y' : 'N' ;

                COption::SetOptionString($module_id, 'characteristic_processing_product_ib'.$IBLOCK_ID, $characteristic_processing_product, '');
                COption::SetOptionString($module_id, 'characteristic_processing_offer_ib'.$IBLOCK_ID, $characteristic_processing_offer, '');
                COption::SetOptionString($module_id, 'remove_not_used_enums_characteristic_prop_ib'.$IBLOCK_ID, $remove_not_used_enums_characteristic_prop, '');

                COption::SetOptionString($module_id, 'update_dis_prop_ib'.$IBLOCK_ID, implode(',', $update_dis_prop_ib[$IBLOCK_ID]), '');
                COption::SetOptionString($module_id, 'update_dis_fields_ib'.$IBLOCK_ID, implode(',', $update_dis_fields_ib[$IBLOCK_ID]), '');


                foreach($arIB_OFFERS[$IBLOCK_ID] as $IBLOCK_OFFER_ID => $ib_offer)
                {
                    COption::SetOptionString($module_id, 'update_dis_prop_ib'.$IBLOCK_OFFER_ID, implode(',', $update_dis_prop_ib[$IBLOCK_OFFER_ID]), '');
                }

            }

            WsmImport1cIBlockHelper::clearCashe();
            // $update_dis_prop = serialize($update_dis_prop);
            // COption::SetOptionString($module_id, 'update_dis_prop', $update_dis_prop, '');

        }
    }
    ?>

    <?$tabControl->Begin();?>

    <form method='post' action='<?=$APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?=LANGUAGE_ID?>'>
    <script>
        function ChangeUseStructure(obj, block)
        {
            if(obj.checked)
            {
                BX(block).style.display = '';
                BX(block+'s').style.display = '';
            }
            else
            {
                BX(block).style.display = 'none';
                BX(block+'s').style.display = 'none';
            }

        }
    </script>
    <?$tabControl->BeginNextTab();?>

        <?foreach($arIB as $IBLOCK_ID => $IB):?>
            <?
            $user_sructure  = COption::GetOptionString($module_id, 'user_sructure_ib'.$IBLOCK_ID, '');
            $user_sructure_section_1c = COption::GetOptionInt($module_id, 'user_sructure_section_1c_ib'.$IBLOCK_ID, '');
            $user_sructure_inform = COption::GetOptionInt($module_id, 'user_sructure_inform_ib'.$IBLOCK_ID, '');

            ?>
            <tr class='heading'>
                <td align='center' colspan='2' nowrap><?=GetMessage('WSM_IMPORT1C_OPT_USER_STRUCTURE')?>: <?=$IB['NAME']?> [<?=$IBLOCK_ID?>]</td>
            </tr>
            <tr>
                <td width="50%"><?=GetMessage("WSM_IMPORT1C_OPT_USE_USER_STRUCTURE") ?></td>
                <td><input type="checkbox" name="user_sructure_ib[<?=$IBLOCK_ID?>]" value="Y" <?if($user_sructure == 'Y'):?>checked<?endif;?> onchange="ChangeUseStructure(this, 'tr_SECTION_1C_<?=$IBLOCK_ID?>');"/></td>
            </tr>
            <tr id="tr_SECTION_1C_<?=$IBLOCK_ID?>" style="<?if($user_sructure != 'Y'):?>display: none;<?endif;?>">
                <td width="50%"><?=GetMessage("WSM_IMPORT1C_OPT_1C_CATALOG") ?></td>
                <td>
                    <select name="user_sructure_section_1c_ib[<?=$IBLOCK_ID?>]">
                        <?foreach($arIB_SECTIONS[$IBLOCK_ID] as $s):?>
                            <option value="<?=$s['ID']?>" <?if($s['ID'] == $user_sructure_section_1c):?>selected<?endif;?>><?=$s['NAME']?></option>
                        <?endforeach;?>
                    </select>
                </td>
            </tr>
            <tr id="tr_SECTION_1C_<?=$IBLOCK_ID?>s" style="<?if($user_sructure != 'Y'):?>display: none;<?endif;?>">
                <td width="50%"><?=GetMessage("WSM_IMPORT1C_OPT_USER_STRUCTURE_INFORM") ?></td>
                <td><input type="text" size="50" name="user_sructure_inform_ib[<?=$IBLOCK_ID?>]" value="<?=$user_sructure_inform?>"/></td>
            </tr>
        <?endforeach;?>

        <?$tabControl->BeginNextTab();?>

        <?foreach($arIB as $IBLOCK_ID => $IB):?>

            <?
            $characteristic_processing_product = COption::GetOptionString($module_id, 'characteristic_processing_product_ib'.$IBLOCK_ID, '');
            $characteristic_processing_offer = COption::GetOptionString($module_id, 'characteristic_processing_offer_ib'.$IBLOCK_ID, '');
            $remove_not_used_enums_characteristic_prop = COption::GetOptionString($module_id, 'remove_not_used_enums_characteristic_prop_ib'.$IBLOCK_ID, '');
            ?>
            <tr class='heading'>
                <td align='center' colspan='2' nowrap><?=GetMessage('WSM_IMPORT1C_OPT_CHARACTERISTIC_PROCESSING')?>: <?=$IB['NAME']?> [<?=$IBLOCK_ID?>]</td>
            </tr>
            <tr>
                <td width="50%"><?=GetMessage("WSM_IMPORT1C_OPT_PROP_FROM_CHARACTERISTIC_PRODUCTS") ?></td>
                <td><input type="checkbox" name="characteristic_processing_product_ib[<?=$IBLOCK_ID?>]" value="Y" <?if($characteristic_processing_product == 'Y'):?>checked<?endif;?>/></td>
            </tr>
            <tr>
                <td><?=GetMessage("WSM_IMPORT1C_OPT_PROP_FROM_CHARACTERISTIC_OFFERS")?></td>
                <td><input type="checkbox" name="characteristic_processing_offer_ib[<?=$IBLOCK_ID?>]" value="Y" <?if($characteristic_processing_offer == 'Y'):?>checked<?endif;?>/></td>
            </tr>
            <tr>
                <td><?=GetMessage("WSM_IMPORT1C_OPT_REMOVE_NOTUSE_CHAR_PROP_ENUMS_VALUE")?></td>
                <td><input type="checkbox" name="remove_not_used_enums_characteristic_prop_ib[<?=$IBLOCK_ID?>]" value="Y" <?if($remove_not_used_enums_characteristic_prop == 'Y'):?>checked<?endif;?>/></td>
            </tr>


            <?
            $update_dis_fields = COption::GetOptionString($module_id, 'update_dis_fields_ib'.$IBLOCK_ID, '');
            $update_dis_fields = explode(',',$update_dis_fields);
            $update_dis_fields = is_array($update_dis_fields) ? $update_dis_fields : array() ;
            ?>

            <tr>
                <td width="50%"><?=GetMessage("WSM_IMPORT1C_OPT_IBLOCK_SETTINGS_DISABLE_CHANGE_FROM_1C_FIELDS")?></td>
                <td>
                    <select name="update_dis_fields_ib[<?=$IBLOCK_ID?>][]" multiple size="7" style="min-width: 250px;">
                        <?foreach($arIB_FIELDS as $fid => $field):?>
                            <option value="<?=$fid?>"<?if(in_array($fid, $update_dis_fields)) echo " selected";?>>[ <?=$fid?> ] <?=$field?></option>
                        <?endforeach;?>
                    </select>
                </td>
            </tr>
            <?
            $update_dis_prop = COption::GetOptionString($module_id, 'update_dis_prop_ib'.$IBLOCK_ID, '');
            $update_dis_prop = explode(',',$update_dis_prop);
            $update_dis_prop = is_array($update_dis_prop) ? $update_dis_prop : array() ;
            ?>
            <tr>
                <td width="50%"><?=GetMessage("WSM_IMPORT1C_OPT_IBLOCK_SETTINGS_DISABLE_CHANGE_FROM_1C_PROP")?></td>
                <td>
                    <select name="update_dis_prop_ib[<?=$IBLOCK_ID?>][]" multiple size="7" style="min-width: 250px;">
                    <?foreach($arIB_PROPS[$IBLOCK_ID] as $prop):?>
                        <option value="<?=$prop['ID']?>"<?if(in_array($prop['ID'],$update_dis_prop)) echo " selected";?>>[<?=$prop['ID']?>] <?=$prop['NAME']?></option>
                    <?endforeach;?>
                    </select>
                </td>
            </tr>

            <?foreach($arIB_OFFERS[$IBLOCK_ID] as  $IBLOCK_ID_OFFERS => $IB_OFFERS):
                # propertyes of offers
                $update_dis_prop = COption::GetOptionString($module_id, 'update_dis_prop_ib'.$IBLOCK_ID_OFFERS, '');
                $update_dis_prop = explode(',',$update_dis_prop);
                $update_dis_prop = is_array($update_dis_prop) ? $update_dis_prop : array() ;
                ?>
                <tr>
                    <td width="50%"><?=GetMessage("WSM_IMPORT1C_OPT_IBLOCK_SETTINGS_DISABLE_CHANGE_FROM_1C_PROP_OFFERS")?></td>
                    <td>
                        <select name="update_dis_prop_ib[<?=$IBLOCK_ID_OFFERS?>][]" multiple size="7" style="min-width: 250px;">
                            <?foreach($arIB_PROPS[$IBLOCK_ID_OFFERS] as $prop):?>
                                <option value="<?=$prop['ID']?>"<?if(in_array($prop['ID'],$update_dis_prop)) echo " selected";?>>[<?=$prop['ID']?>] <?=$prop['NAME']?></option>
                            <?endforeach;?>
                        </select>
                    </td>
                </tr>
            <?endforeach;?>

        <?endforeach;?>

    <?$tabControl->BeginNextTab();?>

        <?$Update = $_POST["Update"].$_POST["Apply"];?>
        <?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>

    <?
    if($REQUEST_METHOD=='POST' && strlen($Update.$Apply.$RestoreDefaults)>0 && check_bitrix_sessid())
    {
        if(strlen($Update)>0 && strlen($_REQUEST['back_url_settings'])>0)
            LocalRedirect($_REQUEST['back_url_settings']);
        else
            LocalRedirect($APPLICATION->GetCurPage().'?mid='.urlencode($mid).'&lang='.urlencode(LANGUAGE_ID).'&back_url_settings='.urlencode($_REQUEST['back_url_settings']).'&'.$tabControl->ActiveTabParam());
    }
    ?>

    <?$tabControl->Buttons();?>
        <input <?if ($MODULE_RIGHT<'W') echo 'disabled' ?> type='submit' name='Update' value='<?=GetMessage('MAIN_SAVE')?>' title='<?=GetMessage('MAIN_OPT_SAVE_TITLE')?>'>
        <input <?if ($MODULE_RIGHT<'W') echo 'disabled' ?> type='submit' name='Apply' value='<?=GetMessage('MAIN_OPT_APPLY')?>' title='<?=GetMessage('MAIN_OPT_APPLY_TITLE')?>'>
        <?if(strlen($_REQUEST['back_url_settings'])>0):?>
            <input type='button' name='Cancel' value='<?=GetMessage('MAIN_OPT_CANCEL')?>' title='<?=GetMessage('MAIN_OPT_CANCEL_TITLE')?>' onclick='window.location='<?=htmlspecialchars(CUtil::addslashes($_REQUEST['back_url_settings']))?>''>
            <input type='hidden' name='back_url_settings' value='<?=htmlspecialchars($_REQUEST['back_url_settings'])?>'>
        <?endif?>
        <input <?if ($MODULE_RIGHT<'W') echo 'disabled' ?> type='submit' name='RestoreDefaults' title='<?=GetMessage('MAIN_HINT_RESTORE_DEFAULTS')?>' OnClick='confirm('<?=AddSlashes(GetMessage('MAIN_HINT_RESTORE_DEFAULTS_WARNING'))?>')' value='<?=GetMessage('MAIN_RESTORE_DEFAULTS')?>'>
        <?=bitrix_sessid_post();?>
    <?$tabControl->End();?>
    </form>

<?else:?>
    <?=CAdminMessage::ShowMessage(GetMessage('NO_RIGHTS_FOR_VIEWING'));?>
<?endif;?>