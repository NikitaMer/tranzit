<?require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');?>

<?

use Bitrix\Main;

$out = array(
	'ORDER_ID' => null,
	'MESSAGE' => array(),
	'ERROR' => false,
	);

$app = Main\HttpApplication::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

if(!\Bitrix\Main\Loader::includeModule('sale'))
{
	$out['ERROR'] = true;
	$out['MESSAGE']['module'] = 'Модуль не установлен';

	echo json_encode($out);
	die();
}


if($request->getQuery('ajax') == 'Y' && $request->getQuery('create_order') == 'Y')
{

	if(!$request->getQuery('PHONE') || strlen($request->getQuery('PHONE')) == 0)
	{
		$out['ERROR'] = true;
		$out['MESSAGE']['PHONE'] = 'Не введен номер теелфона';
	}
	elseif(strlen($request->getQuery('PHONE')) <5)
	{
		$out['ERROR'] = true;
		$out['MESSAGE']['PHONE'] = 'Введен не корректный номер телефона';
	}
    $strOrderList = "";

	if(!$out['ERROR'])
	{
		$PRICE = 0;
		$USER_ID = 0;

		$dbBasketItems = CSaleBasket::GetList(
			array(
				"NAME" => "ASC",
				"ID" => "ASC"
			),
			array(
				"FUSER_ID" => CSaleBasket::GetBasketUserID(),
				"LID" => SITE_ID,
				"ORDER_ID" => "NULL",
				"CAN_BUY" => 'Y',
			),
			false,
			false,
			array("ID", "CALLBACK_FUNC", "MODULE",
				"PRODUCT_ID", "QUANTITY", "DELAY", "NAME",
				"CAN_BUY", "PRICE", "WEIGHT")
			);

		while ($arItems = $dbBasketItems->Fetch())
		{
			$PRICE += $arItems['PRICE'] * $arItems['QUANTITY'];

            $measure = (isset($arItems["MEASURE_TEXT"])) ? $arItems["MEASURE_TEXT"] : GetMessage("SOA_SHT");
            $strOrderList .= $arItems["NAME"]." - ".$arItems["QUANTITY"]." ".$measure.": ".SaleFormatCurrency($arItems["PRICE"], 'RUB');
            $strOrderList .= "\n";
		}

		if($GLOBALS['USER']->IsAuthorized())
		{
			$USER_ID = $GLOBALS['USER']->GetID();
		}
		else
		{
			$arFilter = array();

			$first = substr($request->getQuery('PHONE'), 0, 1);

			if($first == '8' || $first == '7')
				$phone = '+7'.substr($request->getQuery('PHONE'), 1);
			elseif(substr($request->getQuery('PHONE'), 0, 2) == '+7')
				$phone = '8'.substr($request->getQuery('PHONE'), 2);

			if($phone != '')
			{
				$arFilter = array(
					'LOGIN' => array($request->getQuery('PHONE'), $phone),
					);
			}
			else
			{
				$arFilter = array(
					'LOGIN' => $request->getQuery('PHONE'),
					);
			}

			$rsUser = \Bitrix\Main\UserTable::getList(array(
				'filter' => $arFilter,
				'limit' => 1,
				));

			if($aUser = $rsUser->fetch())
			{
				$USER_ID = $aUser['ID'];
				$out['USER_RES'] = 'found';
			}
			else
			{
				$pass = "12d43.dfFDfsg".rand(122123,3233223);

				$user = new CUser;
				$arUserFields = Array(
					"NAME"              => $request->getQuery('NAME'),
					"LAST_NAME"         => "",
					"EMAIL"             => $request->getQuery('PHONE')."-phone@tranzit-oil.ru",
					"LOGIN"             => $request->getQuery('PHONE'),
					"LID"               => SITE_ID,
					"ACTIVE"            => "Y",
					"PASSWORD"          => $pass,
					"CONFIRM_PASSWORD"  => $pass,
					//"PERSONAL_PHOTO"    => $request->getQuery('PHONE')
                    "GROUP_ID"          => array(13),
				);

				$USER_ID = $user->Add($arUserFields);

				if(!$USER_ID)
				{
					$out['ERROR'] = true;
					$out['MESSAGE']['PHONE'] = $user->err_mess();

					echo json_encode($out);
					die();
				}

				$out['USER_RES'] = 'create';
			}



		}

		$arFields = array(
			"LID" => SITE_ID,
			"PERSON_TYPE_ID" => 1,
			"PAYED" => "N",
			"CANCELED" => "N",
			"STATUS_ID" => "N",
			"PRICE" => $PRICE,
			"CURRENCY" => "RUB",
			"USER_ID" => $USER_ID, //IntVal($GLOBALS['USER']->GetID()),
			"PAY_SYSTEM_ID" => 1,
			"PRICE_DELIVERY" => 0,
			"DELIVERY_ID" => 1,
			"DISCOUNT_VALUE" => 0,
			"TAX_VALUE" => 0,
			"USER_DESCRIPTION" => "Заказ создан через форму быстрого заказа"
			);

		$out[] = $arFields;

		$ORDER_ID = CSaleOrder::Add($arFields);
		$ORDER_ID = IntVal($ORDER_ID);

		if($ORDER_ID)
		{
			CSaleBasket::OrderBasket($ORDER_ID, $_SESSION["SALE_USER_ID"], SITE_ID);

			$out['ORDER_ID'] = $ORDER_ID;
			$out['MESSAGE'][] = 'Заказ №'.$ORDER_ID.' оформлен.<br>Менеджер свяжется с Вами <br>для уточнения деталей .';

            $arOrderNew = CSaleOrder::GetByID($ID);
            /*
            //send mail
            $arFields = array(
                "ORDER_ID" => $ORDER_ID,
                "ORDER_DATE" => Date($GLOBALS['DB']->DateFormatToPHP(CLang::GetDateFormat("SHORT"))),
                "ORDER_USER" => $arUserFields['LOGIN'],
                "PRICE" => SaleFormatCurrency($PRICE, 'RUB'),
                "BCC" => \COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
                "EMAIL" => 'no-adres@tranzit-oil.ru',
                "ORDER_LIST" => $strOrderList,
                "SALE_EMAIL" => \COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
                "DELIVERY_PRICE" => 0,
            );

            $eventName = "SALE_NEW_ORDER";

            $event = new \CEvent;
            $event->Send($eventName, 's1', $arFields, "N");
            */
		}

	}

	echo json_encode($out);
	die();
}

?>
<div class="auth_form_login">
	<form class="mForm ajax" id="buy_oneclick_form" name="system_auth_form6zOYVN" method="post" target="_top" action="/local/ajax/auth.php?login=yes">
		<input type="hidden" name="create_order" value="Y">
		<h3>Покупка в один клик</h3>

		<div class="field login">
			<input type="text" name="NAME" maxlength="50" value="" placeholder="Имя">
		</div>

		<div class="field phone">
			<input type="text" name="PHONE" maxlength="50" placeholder="Телефон">
		</div>

		<div class="error_text" style="display: none;"></div>

		<div >
			<p style="text-align:justify;font-size: 10px;line-height: 12px;">	Нажимая кнопку «Отправить», я даю свое согласие на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», <a href="/documents/agreement_.pdf" target="_blank">на условиях и для целей, определенных в Согласии на обработку персональных данных</a></p>
		</div>
		<div class="buttons">
			<button class="yellow round" type="submit" name="create_order" value="Y">Отправить</button>
		</div>

	</form>
</div>

<script>
$(function(){
	$('#buy_oneclick_form').submit(function(){

		var data = $(this).serialize(),
			_form = $(this);

		data += '&ajax=Y';

		$.ajax({
			url: '/local/ajax/buy_one_click.php',
			type: 'get',
			data: data,
			dataType: 'json',
			success: function(data){

				if(typeof data.MESSAGE != 'object')
					data.MESSAGE = [];

				_form.find('.field').removeClass('error');
				_form.find('.error_text').hide();

				//console.log('data = ', data);

				if(typeof UpdateCartMini == 'function')
					UpdateCartMini();
				else
					console.warn('function UpdateCartMini not found');

				if(data.ERROR == true)
				{
					_form.find('.error_text').html('В форме есть ошибки').show();

					for(i in data.MESSAGE)
						_form.find('input[name='+i+']').parents('.field').addClass('error');

				}
				else
				{
					_form.html('<div class="ajax_form_result mini"><span>' + data.MESSAGE[0] + '</span></div>');

				}

				} //success

			});

		return false;

		});

	});
</script>
