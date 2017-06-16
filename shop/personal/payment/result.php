<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
function toFloat($sum) {
        $sum = floatval($sum);
        if (strpos($sum, ".")) {
            $sum = round($sum, 2);
        } else {
            $sum = $sum.".0";
        }
        return $sum;
    }


$key = "mcYoCVZonWY";

CModule::IncludeModule("sale");

if($_REQUEST['type']=='check') {
    $request = $_REQUEST;
    
    $check = array(
            'type' => 'check',
            'pay_for' => intval($request['pay_for']),
            'amount' => toFloat($request['order_amount']),
            'currency' => trim($request['order_currency']),
            'code' => 2,
            'key' => $key,
            );
        $text = "Error order_id: {$check['pay_for']}";
        $order_amount = floatval($request['order_amount']);
        
                $check['code'] = 0;
                $text = "OK";

        $check['md5_string'] = implode(";", $check);
        $check['md5'] = strtoupper(md5($check['md5_string']));

        $out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<result>
<code>{$check['code']}</code>
<pay_for>{$check['pay_for']}</pay_for>
<comment>{$text}</comment>
<md5>{$check['md5']}</md5>
</result>";
        echo $out;
        
        
        
        
    } elseif($_REQUEST['type']=='pay') {
        
        
        $_request = $_REQUEST;
        $request = $_REQUEST;
        
        $pay = $payOut = array(
            'type' => 'pay',
            'pay_for' => intval($request['pay_for']),
            'onpay_id' => intval($request['onpay_id']),
            'order_id' => intval($request['pay_for']),
            'amount' => toFloat($request['order_amount']),
            'currency' => trim($request['order_currency']),
            'code' => 3,
            'key' => $key,
            );
        unset($pay['code']);
        unset($pay['order_id']);
        $pay['md5_string'] = implode(";", $pay);
        $pay['md5'] = strtoupper(md5($pay['md5_string']));
        $order_amount = floatval($request['order_amount']);
        $text = "Error in parameters data";
        
        if($pay['md5'] != $request['md5'])
            {
                $text = "Md5 signature is wrong";
                $payOut['code'] = 7;
            } else {
                if(CModule::IncludeModule("sale")){
            
                    $arOrder = CSaleOrder::GetByID($payOut["order_id"]);
                        if ($arOrder)
                            {
                                $arFields = array(
                                "STATUS_ID" => "P",
                                );
   
                            if(CSaleOrder::Update($payOut["order_id"], $arFields)) 
                                {
                                    $payOut['code'] = 0;
                                    $text = "OK";
                                } else {
                                    $text = "Error in mechant database queries: operation or balance tables error";
                                }
                            }else{
                                $text = "somthing is wrong";
                                $payOut['code'] = 7;   
                            }
                      }
                }
          
        $payOut['md5_string'] = implode(";", $payOut);
        $payOut['md5'] = strtoupper(md5($payOut['md5_string']));
        $out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<result>
<code>{$payOut['code']}</code>
<comment>{$text}</comment>
<onpay_id>{$payOut['onpay_id']}</onpay_id>
<pay_for>{$payOut['pay_for']}</pay_for>
<order_id>{$payOut['order_id']}</order_id>
<md5>{$payOut['md5']}</md5>
</result>";
        echo $out;
    }

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>

