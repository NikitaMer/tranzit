<?
if ($_SERVER[SCRIPT_NAME]=='/bitrix/admin/iblock_element_edit.php') {

CModule::IncludeModule("iblock");
$db_props = CIBlockElement::GetProperty($_GET[IBLOCK_ID], $_GET[ID], array("sort" => "asc"), Array("CODE"=>"DONACENKI"));

if($ar_props = $db_props->Fetch());
    $priceo=$ar_props[VALUE];



?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script>


$(window).load(function() {

// alert('<?=$priceo;?>');

$('#tr_PROPERTY_699').find('input').keyup(function() {

var pr=$('#tr_PROPERTY_699').find('input').val();

if (pr!='') {
if (pr[0]=='+') { p=pr.replace('+',''); p=<?=$priceo;?>+p.replace('%','')/100*<?=$priceo;?>;}
if (pr[0]=='-') { p=pr.replace('-',''); p=<?=$priceo;?>-p.replace('%','')/100*<?=$priceo;?>;}

p=Math.round(p);

BX('CAT_BASE_PRICE').value=p;
BX('CAT_PRICE_EXIST').value=p;
BX('CAT_BASE_PRICE_0').value=p;
e_base_price.value=p;




}

});

});

</script>

<? } ?>