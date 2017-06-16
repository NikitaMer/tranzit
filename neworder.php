<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); ?>
<?
/*$f=fopen($_SERVER["DOCUMENT_ROOT"].'/log.txt','a');
fwrite($f," Начало \r\n");
fclose($f);*/
?>

<?

CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

global $DB;

$SQL="SELECT * FROM order_agent WHERE status=0 order by user ASC LIMIT 0,1000;";

$results=$DB->Query($SQL);



$iu=0; if ($_REQUEST[r]<=0) $r=0;
while ($row = $results->Fetch())
{
	
	
	$r=$r+1;

	// Обнулить статус в таблице
	
$SQL="UPDATE order_agent SET status=1 WHERE id=$row[id];";
$DB->Query($SQL);

$pay=$row[PAY_SYSTEM_ID];
$del=$row[DELIVERY_ID];

if ($iu!=$row[user]) 
	{

$OrderList='';
	
if ($iu>0)		{
	
	// Оформление заказа из корзины 
	
	$arFields = array(
   "LID" => 's1',
   "PERSON_TYPE_ID" => 1,
   "PAYED" => "N",
   "CANCELED" => "N",
   "STATUS_ID" => "N",
   "PRICE" => $allsum,
   "CURRENCY" => "RUB",
   "USER_ID" => $iu,
   "PAY_SYSTEM_ID" => $orow[PAY_SYSTEM_ID],
   "DELIVERY_ID" => $orow[DELIVERY_ID],
   
);

echo "Order Start";

$ORDER_ID = CSaleOrder::Add($arFields);

	CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID()); // Чистка корзины

	$orow=$row;
}
	
$allsum=0;
	
	// Новый заказ для пользователя	
	CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID()); // Чистка корзины
	$iu=$row[user];
//	echo "$iu<br>";
	}
	
	$res = CIBlockElement::GetByID($row[product]);
    $ar_res = $res->GetNext();
	
	
	
	// Добавим в корзину товар
	
 
  $arFields = array(    
			"PRODUCT_ID" => $row[product],    
			"PRICE" => $row[PRICE],    
			"CURRENCY" => "RUB",    
			"LID" => 's1',    
			"NAME" =>  $ar_res[NAME], 
            "QUANTITY"=>$row[QUANTITY],
			"DETAIL_PAGE_URL"=>$ar_res[DETAIL_PAGE_URL],
);
  
#$f=fopen($_SERVER["DOCUMENT_ROOT"].'/log.txt','a');
#fwrite($f,"Корзина ".print_r($arFields,true)."\r\n");
#fclose($f);


$OrderList=$OrderList.$arFields[NAME]." - ".$row[QUANTITY]." шт.: ".CurrencyFormat($row[PRICE]*$row[QUANTITY], "RUB")." <br>";


 $res=CSaleBasket::Add($arFields);

$allsum=$allsum+$row[QUANTITY]*$row[PRICE];

}


if ($r>0) {
	
	$arFields = array(
   "LID" => 's1',
   "PERSON_TYPE_ID" => 1,
   "PAYED" => "N",
   "CANCELED" => "N",
   "STATUS_ID" => "N",
   "PRICE" => $allsum,
   "TAX_VALUE" => 0.0,
   "CURRENCY" => "RUB",
   "USER_ID" => $iu,
   "PAY_SYSTEM_ID" => $pay,
   "DELIVERY_ID" => $del,

   
);


#$f=fopen($_SERVER["DOCUMENT_ROOT"].'/log.txt','a');
#fwrite($f,"Заказ ".print_r($arFields,true)."\r\n");
#fclose($f);

$ORDER_ID = CSaleOrder::Add($arFields);

CSaleBasket::OrderBasket($ORDER_ID, $_SESSION["SALE_USER_ID"], 's1'); // Добавление товаров из корзины к заказу

#$f=fopen($_SERVER["DOCUMENT_ROOT"].'/log.txt','a');
#fwrite($f,"Конец ".$ORDER_ID."\r\n");
#fclose($f);

// Почтовые события
$POST=array();
$POST[ORDER_DATE]=date('d-m-Y H:i:s',time());
$POST[ORDER_ID]=$ORDER_ID;

$rsUser = CUser::GetByID($iu);
$arUser = $rsUser->Fetch();

$POST[ORDER_USER]=$arUser[NAME];
$POST[EMAIL]=$arUser[EMAIL];
$POST[PRICE]=$allsum." руб.";
$POST[ORDER_LIST]=$OrderList;

CEvent::Send('PREORDER_SHOP','s1',$POST); // Владельцу магазина
CEvent::Send('PREORDER','s1',$POST); // Покупателю


}

if ( ($ORDER_ID>0) && ($iu>0) )
{
	
	$od=$ORDER_ID-1;
	
// Определяем список свойств для предыдущего заказа

echo "AAAAAAAAAa";


   $db_props = CSaleOrderPropsValue::GetList(
        array("SORT" => "ASC"),
        array(
                
                "ORDER_ID" => $od
            )
    );

	while ($arProps = $db_props->Fetch()) {
	   
//////// Добавам в текущий каталог

$arFields = array(
   "ORDER_ID" => $ORDER_ID,
   "ORDER_PROPS_ID" => $arProps[ORDER_PROPS_ID],
   "NAME" => $arProps[NAME],
   "CODE" => $arProps[CODE],
   "VALUE" => $arProps[VALUE]
);

CSaleOrderPropsValue::Add($arFields);
/////////
	   
   }
   
   // Удалем заказ старый $od 

   	$arOrder = CSaleOrder::GetByID($od);

		
		if ($arOrder[PRICE]<=0) 
		{
			// Удаляем нулевой заказ
			CSaleOrder::Delete($od);		
		}	
	
//
	
}

?>