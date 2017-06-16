<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

function processOrderProperty($arFields) {
	if($arFields["ID"] > 0) {
		CSaleOrderPropsValue::Update($arFields["ID"], array("VALUE"=>$arFields["VALUE"]));
	} elseif($arFields["ORDER_ID"] > 0) CSaleOrderPropsValue::Add($arFields);
}
function getOwnerEmail($order)
   {
      $res = CSaleOrderPropsValue::GetOrderProps($order);
      while ($row = $res->fetch()) {
         if ($row['IS_EMAIL']=='Y' && check_email($row['VALUE'])) {
            return $row['VALUE'];
         }
      }
      if ($order = CSaleOrder::getById($order)) {
         if ($user = CUser::GetByID($order['USER_ID'])->fetch()) {
            return $user['EMAIL'];
         }
      }
      return false;
   }
$intOrderID = intval($_REQUEST["ORDER_ID"]);
if(($USER -> IsAdmin() || in_array(8, $USER->GetUserGroupArray()))) {
	if($intOrderID > 0 && CModule::IncludeModule("sale")) {
		$arOrder = CSaleOrder::GetByID($intOrderID);

		if($arOrder["ID"] > 0) {
			$arOrderProps = array();
			$rsProps = CSaleOrderPropsValue::GetOrderProps($arOrder["ID"]);
			while ($arProps = $rsProps->Fetch())
				$arOrderProps[$arProps["ORDER_PROPS_ID"]] = $arProps;

			if($_POST["SAVE_DA"] == "Y") {
				if ($_POST["ID_USER"] == 24) {
				// delivery date
				$arFields = array(
					"ID" => $arOrderProps[24]["ID"],
					"ORDER_ID" => $arOrder["ID"],
					"ORDER_PROPS_ID" => 24,
					"NAME" => "Доставка на дату",
					"CODE" => "f10",
					"VALUE" =>  iconv("utf-8", "windows-1251", $_POST["FORM_DA_DATE"])
				);
				processOrderProperty($arFields);
				} elseif($_POST["ID_USER"] == 25){
				$arFields = array(
					"ID" => $arOrderProps[25]["ID"],
					"ORDER_ID" => $arOrder["ID"],
					"ORDER_PROPS_ID" => 25,
					"NAME" => "Доставка на дату",
					"CODE" => "f10",
					"VALUE" =>  iconv("utf-8", "windows-1251", $_POST["FORM_DA_DATE"])
				);
				processOrderProperty($arFields);
				}
				$arEventFields = array(
					"ORDER_ID" => $arOrder["ID"],
					"ORDER_DATE" => $arOrder["DATE_INSERT"],
					"EMAIL" => getOwnerEmail($arOrder["ID"]),
					"SALE_EMAIL" => "noreply@tranzit-oil.ru",
					"DELIVERY_DATE" => iconv("utf-8", "windows-1251", $_POST["FORM_DA_DATE"]),
					"DEFAULT_EMAIL_FROM" =>  "noreply@tranzit-oil.ru",
					"SITE_NAME" => "Транзит ойл",
					"SERVER_NAME" => "http://tranzit-oil.ru"
				);
				CEvent::Send("SALE_ORDER_DELIVERY","s1", $arEventFields);
				die();
			}
		}
	}

	if($arOrder["ID"] > 0) {
	$text_props = $arOrderProps[25]["VALUE"];
	if (!isset($arOrderProps[25]["VALUE"])) {
		$text_props = $arOrderProps[24]["VALUE"];
	}	
		?>
	<div id="popup_form_delivery_addon" class="sale_popup_form adm-workarea" style="display:none; font-size:13px;">
		<table>
			<tr>
				<td class="head">Доставка на дату:</td>
				<td>

					<div class="adm-input-wrap adm-input-wrap-calendar">
						<input class="adm-input adm-input-calendar" type="text" id="FORM_DA_DATE" name="FORM_DA_DATE" size="13" value="<?=$text_props?>">
						<span class="adm-calendar-icon" title="Нажмите для выбора даты" onclick="BX.calendar({node:this, field:'FORM_DA_DATE', form: '', bTime: false, bHideTime: false});"></span>
					</div>
				</td>
			</tr>
		</table>
	</div><?
	}
}
?>