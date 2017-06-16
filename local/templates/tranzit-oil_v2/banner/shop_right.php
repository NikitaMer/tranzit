<?

$arBanners = array();

if(CModule::IncludeModule("advertising"))
{
    $arFilter = Array(
        "ACTIVE " => 'Y',
        "LAMP" => 'green',
        "STATUS_SID" => 'PUBLISHED',
        "TYPE_SID"	 => 'SHOP_RIGHT',
        "LID" => SITE_ID,
    );

    $by = 's_weight';
    $order = 'desc';

    $rsBanners = CAdvBanner::GetList($by, $order, $arFilter, $is_filtered, "N");
    while($arBanner = $rsBanners->NavNext(false, false))
    {
        $strReturn = CAdvBanner::GetHTML($arBanner, true);

        if (strlen($strReturn)>0)
        {
            $arBanner['FIX_SHOW'] = 'Y';
            CAdvBanner::FixShow($arBanner);
        }


        $arBanners[] = $strReturn;
    }
}


?>

<?if(!empty($arBanners)):?>
	<br>
	<br>
    <ul class="banner-left">
       <?foreach ($arBanners as $banner):?>
        <li><?=$banner?></li>
    <?endforeach;?>
    </ul>
<?endif;?>