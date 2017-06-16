<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$path = $GLOBALS['APPLICATION']->GetCurPage(false);
$is_shop_main = $path == '/shop/';

if($is_shop_main) {
    ?>
    <script language="Javascript" type="text/javascript" src="/js/jquery.lwtCountdown-1.0.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="/style/main.min.css"></link>

    <?

    $arBanners = array();

    if (CModule::IncludeModule("advertising")) {
        $arFilter = Array(
            "ACTIVE " => 'Y',
            "LAMP" => 'green',
            "STATUS_SID" => 'PUBLISHED',
            "TYPE_SID" => 'MAIN_SHOP',
            "LID" => SITE_ID,
        );

        $by = 's_weight';
        $order = 'desc';
        $chtime = array();
        $rsBanners = CAdvBanner::GetList($by, $order, $arFilter, $is_filtered, "N");
        while ($arBanner = $rsBanners->NavNext(false, false)) {


            $strReturn = CAdvBanner::GetHTML($arBanner, true);

            if (strlen($strReturn) > 0) {
                $arBanner['FIX_SHOW'] = 'Y';
                CAdvBanner::FixShow($arBanner);
            }

            $chtime[] = $arBanner[DATE_SHOW_TO];
            $arBanners[] = $strReturn;
        }
    }
}


    #echo "<pre>"; print_r($arBanners); echo "</pre>";
    ?>
<section class="slider-inner<?=$is_shop_main ? '' : ' mini'?>">
<?
if($is_shop_main)
{
        ?>
        <ul class="slides" id="inner-slider">

            <?if(!empty($arBanners)):?>
                <?foreach ($arBanners as $key=>$banner):?>
                    <li class="item">
                        <div class="wrapper center-block">
                            <?=$banner?>
                        </div>
                        <?

                        global $USER;


                        if   ($chtime[$key]!='')
                        {
                            ?>
                            <div style="left:45%; top:85px; index-z:10000; position: absolute;">
                            <div id="countdown_dashboard<?=$key;?>" style="height:50px;">

                            <div class="dash days_dash">
                            <span class="dash_title">дни</span>
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            </div>
                            <div class="dash hours_dash">
                            <span class="dash_title">часы</span>
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            </div>
                            <div class="dash minutes_dash">
                            <span class="dash_title">минуты</span>
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            </div>
                            <div class="dash seconds_dash">
                            <span class="dash_title">секунды</span>
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            </div>
                            </div>
                            </div>

                            <script>

                                <?
                                $date=explode(' ',$chtime[$key]);
                                $da1=explode('.',$date[0]);
                                $da2=explode(':',$date[1]);
                                ?>

                                $('#countdown_dashboard<?=$key;?>').countDown({
                                    targetDate: {
                                        'day': <?=$da1[0];?>,
                                        'month': <?=$da1[1];?>,
                                        'year': <?=$da1[2];?>,
                                        'hour': <?=$da2[0];?>,
                                        'min': <?=$da2[1];?>,
                                        'sec': <?=$da2[2];?>
                                        }
                                    });

                            </script>
                            <?
                        }
                    ?>
                </li>
            <?endforeach;?>
        <?endif;?>

        <?/*
        <li class="item">
            <div class="wrapper center-block">
                <div class="title">Оптовая продажа <br>автотоваров</div>
                <div class="desc">
                    Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации систем массового участия. Постоянное информационно-пропагандистское обеспечение.
                </div>
                <a href="#" class="btn-go yellow">Подробнее
                    <span class="arrow"></span>
                </a>
            </div>
        </li>
        */?>

    </ul>

    <div id="inner-slider-navigation" class="navigation wrapper center-block">

        <a href="#" data-target="prev" class="slider-nav prev custom"></a>
        <a href="#" data-target="next" class="slider-nav next custom"></a>
        <div class="bl">
            <ul class="tabs numericControls">

                <?if(count($arBanners) > 1):?>
                    <?foreach ($arBanners as $index => $banner):?>
                        <li data-target="<?=$index+1?>" class="custom">1</li>
                    <?endforeach;?>
                <?endif;?>

            </ul>
        </div>
    </div>
    <?
}
    ?>

    <div id="main-slider-navigation" class="navigation2 wrapper center-block">

        <ul class="tabs2">
            <li>
              <a  href="/shop/nashi-preimushchestva/" class="line"><div class="icon"></div>Наши<br> преимущества</a>
            </li>
            <li>
                <a  href="/shop/oplata-i-dostavka/" class="line">
                    <div class="icon"></div>Оплата и<br>доставка
                </a>
            </li>
            <li>
                <a href="/shop/action/" class="line">
                    <div class="icon"></div>Наши <br>акции
                </a>
            </li>
            <li>
                <a href="/shop/otzyvy/" class="line">
                    <div class="icon"></div>Отзывы о<br> магазине
                </a>
            </li>
            <li>
              <a href="/shop/kontakty-internet-magazina" class="line">
                    <div class="icon"></div>Контактная<br> информация
                </a>
            </li>
        </ul>

    </div>

</section>

<?if(count($arBanners) > 1):?>
<script>

    $(function(){

        var sudoSlider = $("#inner-slider").sudoSlider({
            speed: 800,
            pause: 5500,
            auto:true,
            prevNext: false,
            numeric: false,
            touch: true,
            continuous:true,
            customLink: '.custom',
            beforeAnimation: function(t){
                $('#inner-slider-navigation .tabs .li').removeClass('current');
                $('#inner-slider-navigation .tabs .li').eq(t-1).addClass('current');
            },
            afterAnimation: function(t){

            }
        });


    });
</script>
<?endif;?>