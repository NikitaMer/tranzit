<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!function_exists("showFilePropertyField"))
{

	function showFilePropertyField($name, $property_fields, $values, $max_file_size_show=50000, $city = 0)
	{
		$res = "";

		if (!is_array($values) || empty($values))
			$values = array(
				"n0" => 0,
			);

		if ($property_fields["MULTIPLE"] == "N")
		{
			$res = "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[0]\" id=\"".$name."[0]\"></label>";
		}
		else
		{
			$res = '
			<script type="text/javascript">
				function addControl(item)
				{
					var current_name = item.id.split("[")[0],
						current_id = item.id.split("[")[1].replace("[", "").replace("]", ""),
						next_id = parseInt(current_id) + 1;

					var newInput = document.createElement("input");
					newInput.type = "file";
					newInput.name = current_name + "[" + next_id + "]";
					newInput.id = current_name + "[" + next_id + "]";
					newInput.onchange = function() { addControl(this); };

					var br = document.createElement("br");
					var br2 = document.createElement("br");

					BX(item.id).parentNode.appendChild(br);
					BX(item.id).parentNode.appendChild(br2);
					BX(item.id).parentNode.appendChild(newInput);
				}
			</script>
			';

			$res .= "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[0]\" id=\"".$name."[0]\"></label>";
			$res .= "<br/><br/>";
			$res .= "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[1]\" id=\"".$name."[1]\" onChange=\"javascript:addControl(this);\"></label>";
		}

		return $res;
	}
}

if (!function_exists("PrintPropsForm"))
{
	function PrintPropsForm($arSource = array(), $locationTemplate = ".default", $counter = 10000)
	{
		if (!empty($arSource))
		{

			foreach ($arSource as $code => $arProperties)
			{

                if(CSaleLocation::isLocationProMigrated())
                {
                    $propertyAttributes = array(
                        'type' => $arProperties["TYPE"],
                        'valueSource' => $arProperties['SOURCE'] == 'DEFAULT' ? 'default' : 'form'
                    );

                    if(intval($arProperties['IS_ALTERNATE_LOCATION_FOR']))
                        $propertyAttributes['isAltLocationFor'] = intval($arProperties['IS_ALTERNATE_LOCATION_FOR']);

                    if(intval($arProperties['INPUT_FIELD_LOCATION']))
                        $propertyAttributes['altLocationPropId'] = intval($arProperties['INPUT_FIELD_LOCATION']);

                    if($arProperties['IS_ZIP'] == 'Y')
                        $propertyAttributes['isZip'] = true;
                }

				if ($arProperties["TYPE"] == "CHECKBOX")
				{
					?>
					<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">

					<div class="bx_block r1x3 pt8">
						<?=$arProperties["NAME"]?>
						<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
							<span class="bx_sof_req">*</span>
						<?endif;?>
					</div>

					<div class="bx_block r1x3 pt8">
						<input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>

						<?
						if (strlen(trim($arProperties["DESCRIPTION"])) > 0):
						?>
						<div class="bx_description">
							<?=$arProperties["DESCRIPTION"]?>
						</div>
						<?
						endif;
						?>
					</div>

					<div style="clear: both;"></div>
					<?
				}
				elseif ($arProperties["TYPE"] == "TEXT")
				{
					#echo $arProperties["CODE"];
                    //arshow($arProperties);
                    $app = \Bitrix\Main\Application::getInstance();
                    $contex = $app->getContext();
                    $request = $contex->getRequest();

					if(!$request->isPost() &&
                        ($arProperties["CODE"] == 'NAME' ||
                        $arProperties["CODE"] == 'CAR_MARKA' ||
						$arProperties["CODE"] == 'CAR_YEAR' ||
						$arProperties["CODE"] == 'CAR_ENGINE') &&
						$GLOBALS['USER']->IsAuthorized() &&
						is_object($GLOBALS['USER'])
					)
					{
						$rsUser = CUser::GetList($by, $order,
							array(
								"ID" => $GLOBALS['USER']->GetID(),
							),
							array(
								"SELECT" => array(
                                    "NAME", 'LOGIN',
									"UF_CAR_ENGINE",
                                    "UF_CAR_YEAR",
                                    "UF_CAR_MARKA"
								),
							)
						);

						if($arUser = $rsUser->Fetch())
						{

                            if($arProperties["CODE"] == 'NAME') // && $arUser[$arProperties["CODE"]]
                                $arProperties["VALUE"] = $arUser[$arProperties["CODE"]];
                            else
							    $arProperties["VALUE"] = $arUser['UF_'.$arProperties["CODE"]];
						}
					}
					$rsUser2 = CUser::GetByID($GLOBALS['USER']->GetID());
					$arUser2 = $rsUser2->Fetch();
					if($arProperties["NAME"] == "Контактный телефон") $arProperties["VALUE"] = $arUser2['PERSONAL_PHONE'];
					if($arProperties["NAME"] == "Email") $arProperties["VALUE"] = $arUser2['EMAIL'];
					
					if(CSite::InGroup (array(9))) {
						if($arProperties["NAME"] == "Контактный телефон") $arProperties["VALUE"] = $arUser2['WORK_PHONE'];
						if($arProperties["CODE"] == 'NAME') $arProperties["VALUE"] = $arUser2['WORK_COMPANY'];	
					}
                    
					?>
					<div class="field<?if($counter == 0 || $arProperties["CODE"] == 'DELIVERY_ADRES'):?> w480p<?endif;?>">
						<label><?=$arProperties["NAME"]?><?if ($arProperties["REQUIED_FORMATED"]=="Y"):?><span class="red">*</span><?endif;?></label>
						<input type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"></label>
						<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
						<div class="info"><?=$arProperties["DESCRIPTION"]?></div>
						<?endif;?>
					</div>
					<?
				}
				elseif ($arProperties["TYPE"] == "SELECT")
				{
                    if($arProperties["CODE"] == 'SHOP')
                    {
                        # echo '***'.$GLOBALS['LOCATION'];
                        # 1568 - Казань
                        # 1569 - Набережные челны

						# удаление магазинов для оптовиков
						global $USER;
						$arUGroup = $USER->GetUserGroupArray();
						
						if(in_array(9, $arUGroup))
						{
							# это оптовик, удаляем все кроме оптового склада
							foreach($arProperties["VARIANTS"] as $i => $arVariants)
							{
								if(in_array($arVariants["VALUE"], array('kazan_1','kazan_2')))
									unset($arProperties["VARIANTS"][$i]);
							}
						}

                    }
					?>
					<div class="field w480p">
						<!-- code = <?=$arProperties["CODE"]?>-->
						<label><?=$arProperties["NAME"]?>
							<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
								<span class="bx_sof_req">*</span>
							<?endif;?>
						</label>


                        <?#_print_r($arProperties["VARIANTS"])?>
						<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
							<?
							foreach($arProperties["VARIANTS"] as $arVariants):
                                if(($GLOBALS['LOCATION'] == 1568 && strpos($arVariants['VALUE'], 'kazan_') === false)
                                ||
                                    ($GLOBALS['LOCATION'] == 1569 && strpos($arVariants['VALUE'], 'chelny_') === false)
                                )
                                    continue;
								?>
								<option
                                    value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y")
                                    echo " selected";?>><?=htmlspecialcharsback($arVariants["NAME"])?></option>
							    <?
							endforeach;
							?>
						</select>
					</div>

					<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
					<div class="info"><?=$arProperties["DESCRIPTION"]?></div>
					<?endif;?>
					<?
				}
				elseif ($arProperties["TYPE"] == "MULTISELECT")
				{
					?>
					<div class="field w480p">
						<label><?=$arProperties["NAME"]?>
							<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
								<span class="bx_sof_req">*</span>
							<?endif;?>
						</label>
						<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
							<?
							foreach($arProperties["VARIANTS"] as $arVariants):
							?>
								<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
							<?
							endforeach;
							?>
						</select>

						<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
							<div class="info"><?=$arProperties["DESCRIPTION"]?></div>
						<?endif;?>
					</div>
					<?
				}
				elseif ($arProperties["TYPE"] == "TEXTAREA")
				{
					$rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
					?>
					<div class="field w480p">
						<label><?=$arProperties["NAME"]?>
							<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
								<span class="bx_sof_req">*</span>
							<?endif;?>
						</label>

						<textarea rows="<?=$rows?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>

						<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
							<div class="info"><?=$arProperties["DESCRIPTION"]?></div>
						<?endif;?>
					</div>
					<?
				}
                elseif ($arProperties["TYPE"] == "LOCATION")
                {
 
					?>
                    <div class="field w480p">
                        <label><?=$arProperties["NAME"]?>
                        <?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
                            <span class="red req">*</span>
                        <?endif;?></label>

                        <div class="input location" style="float: left;">

                            <?
                            $value = 0;
                            if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
                            {
                                foreach ($arProperties["VARIANTS"] as $arVariant)
                                {
                                    if ($arVariant["SELECTED"] == "Y")
                                    {
                                        $value = $arVariant["ID"];
                                        break;
                                    }
                                }
                            }

                            #_print_r($arProperties);
                            #echo $value."\n";;
                            //echo $locationTemplate."\n";

                            #для фильтрации магазинов
                            $GLOBALS['LOCATION'] = $value;

                            #echo $_REQUEST['PERMANENT_MODE_STEPS'] == 1 ? 'steps' : $locationTemplate;
                            ?>

                            <?CSaleLocation::proxySaleAjaxLocationsComponent(array(
                                "AJAX_CALL" => "N",
                                "COUNTRY_INPUT_NAME" => "COUNTRY",
                                "REGION_INPUT_NAME" => "REGION",
                                "CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
                                "CITY_OUT_LOCATION" => "Y",
                                "LOCATION_VALUE" => $value,
                                "ORDER_PROPS_ID" => $arProperties["ID"],
                                "ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
                                "SIZE1" => $arProperties["SIZE1"],
                            ),
                                array(
                                    "ID" => $arProperties["VALUE"],
                                    "CODE" => "",
                                    "SHOW_DEFAULT_LOCATIONS" => "Y",

                                    // function called on each location change caused by user or by program
                                    // it may be replaced with global component dispatch mechanism coming soon
                                    "JS_CALLBACK" => "submitFormProxy", //($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitFormProxy" : "",

                                    // function window.BX.locationsDeferred['X'] will be created and lately called on each form re-draw.
                                    // it may be removed when sale.order.ajax will use real ajax form posting with BX.ProcessHTML() and other stuff instead of just simple iframe transfer
                                    "JS_CONTROL_DEFERRED_INIT" => intval($arProperties["ID"]),

                                    // an instance of this control will be placed to window.BX.locationSelectors['X'] and lately will be available from everywhere
                                    // it may be replaced with global component dispatch mechanism coming soon
                                    "JS_CONTROL_GLOBAL_ID" => intval($arProperties["ID"]),

                                    "DISABLE_KEYBOARD_INPUT" => 'Y'
                                ),
                                $_REQUEST['PERMANENT_MODE_STEPS'] == 1 ? 'steps' : $locationTemplate,
                                true,
                                'location-block-wrapper'
                            )?>

                        </div>
                        <div style="clear: both;"></div>
                    </div>
                <?
                }
				elseif ($arProperties["TYPE"] == "RADIO")
				{
					?>
					<div class="field">
						<label><?=$arProperties["NAME"]?>
							<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
								<span class="bx_sof_req">*</span>
							<?endif;?>
						</label>

						<?
						if (is_array($arProperties["VARIANTS"]))
						{
							foreach($arProperties["VARIANTS"] as $arVariants):
							?>
								<input
									type="radio"
									name="<?=$arProperties["FIELD_NAME"]?>"
									id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"
									value="<?=$arVariants["VALUE"]?>" <?if($arVariants["CHECKED"] == "Y") echo " checked";?> />

								<label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label></br>
							<?
							endforeach;
						}
						?>

						<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
							<?=$arProperties["DESCRIPTION"]?>
						<?endif;?>
					</div>
					<?
				}
				elseif ($arProperties["TYPE"] == "FILE")
				{
					?>

					<div class="field file<?if($arProperties["CODE"] == 'DETAILS'):?> details<?endif;?>">
						<?=showFilePropertyField("ORDER_PROP_".$arProperties["ID"], $arProperties, $arProperties["VALUE"], $arProperties["SIZE1"])?>
						<div class="file_search">
							<div class="file_field">

								<input type="text" name="<?="ORDER_PROP_S_".$arProperties["ID"].'[0]'?>" readonly class="text search_file">
								<button class="search_file round yellow" onclick="searchFileDoc(); return false;">Обзор...</button>

								<div class="clear"></div>
								<div class="desc"><?=$arProperties["NAME"]?>
									<?/*if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
										<span class="bx_sof_req">*</span>
									<?endif;*/?>
								</div>
							</div>
						</div>

					</div>
					<?
				}
			}
            ?>

            <?if(CSaleLocation::isLocationProEnabled()):?>
            <script>
                (window.top.BX || BX).saleOrderAjax.addPropertyDesc(<?=CUtil::PhpToJSObject(array(
                        'id' => intval($arProperties["ID"]),
                        'attributes' => $propertyAttributes
                    ))?>);
            </script>
            <?endif?>
            <?
		}
	}
}
?>