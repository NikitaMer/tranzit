<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бонусы");
?>

<?
// Выберем все счета (в разных валютах) пользователя с кодом 21
$dbAccountCurrency = CSaleUserAccount::GetList(
        array(),
        array("USER_ID" => CUser::GetID()),
        false,
        false,
        array("CURRENT_BUDGET", "CURRENCY")
    );
	
while ($arAccountCurrency = $dbAccountCurrency->Fetch())
{
echo "На вашем бонусном счете ".": ";
	echo SaleFormatCurrency($arAccountCurrency["CURRENT_BUDGET"],
                            $arAccountCurrency["CURRENCY"])." <br><br>";
}
?>

<table cellpadding="0" cellspacing="0" border="0" class="data-table">
    <thead>
        <tr>
            <td>№</td>
            <td>Дата транзакции</td>
            <td>Сумма</td>
            <td>Описание</td>
        </tr>
    </thead>
    <tbody>
    <?
    CModule::IncludeModule("sale");
    $res = CSaleUserTransact::GetList(Array("ID" => "DESC"), array("USER_ID" => $USER->GetID(),"ORDER_ID"=>false));
    while ($arFields = $res->Fetch())
    {?>
        <tr>
            <td><?=$arFields["ID"]?></td>
            <td><?=$arFields["TRANSACT_DATE"]?></td>
            <td><?=($arFields["DEBIT"]=="Y")?"+":"-"?><?=SaleFormatCurrency($arFields["AMOUNT"], $arFields["CURRENCY"])?><br /><small>(<?=($arFields["DEBIT"]=="Y")?"на счет":"со счета"?>)</small></td>
            <td><?=$arFields["DESCRIPTION"]?></td>
        </tr>
    <?}?>
    <tbody>
</table>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>