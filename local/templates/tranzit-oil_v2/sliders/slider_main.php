<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
global $APPLICATION;
$page = $APPLICATION->GetCurPage();

$page_optovaya = strpos($page, '/avtotovary/') === 0;
$page_shin_center = strpos($page, '/gruzoviye-shiny/') === 0;
$page_retail = strpos($page, '/retail-network/addresses-of-stores/') === 0;

$startSlide = 1;

if($page_optovaya)
    $startSlide = 1;
elseif($page_shin_center)
    $startSlide = 3;
elseif($page_retail)
    $startSlide = 4;

$arBanners = array();



if($CSiteController->isMainPage() && CModule::IncludeModule("advertising"))
{
    $arFilter = Array(
        "ACTIVE " => 'Y',
        "LAMP" => 'green',
        "STATUS_SID" => 'PUBLISHED',
        "TYPE_SID"	 => 'MAIN',
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
<section class="slider<?if(!$CSiteController->isMainPage()) echo ' mini';?>">
    <?
    if($CSiteController->isMainPage())
    {
        ?>
        <div class="slides" id="main-slider">

            <div class="item wholesale">

                <div class="wrapper center-block">
                    <div class="title">Оптовая продажа <br>автотоваров</div>
                    <div class="desc">
                        Основным направлением деятельности компании является - оптовая торговля автотоварами. Мы работаем с крупнейшими предприятиями и торговыми сетями Республики Татарстан, а общий клиентский портфель составляет более 1500 клиентов.
                    </div>
                    <a href="/avtotovary" class="btn-go black red link">Перейти в раздел<span class="arrow"></span></a>
                    <div class="icon"></div>
                </div>

            </div>

            <div class="item shop">

                <div class="wrapper center-block">

                    <div class="title">Интернет магазин<br>автотоваров</div>
                    <div class="desc">Наш интернет-магазин - это удобный сервис по поиску, подбору и покупке автомобильных товаров с бесплатной доставкой по городу Казани. Вам больше не надо тратить время на поиски. Наши специалисты помогут Вам с выбором, а цены приятно удивят.
                    </div>
                  <a href="/shop" target="_blank" class="btn-go black yellow link">Перейти в
                        раздел<span class="arrow"></span></a>
                    <div class="icon"></div>
                </div>

            </div>

            <div class="item truck active">

                <div class="wrapper center-block"
                     style="background: url(<?= SITE_TEMPLATE_PATH ?>/img/slider/shini.png) 0 0 no-repeat;">
                    <div class="title">Грузовые<br>шины</div>
                    <div class="desc">Мы предлагаем широкий спектр услуг по продаже и обслуживанию шин мировых брендов для грузовой и специальной техники.Сеть шиномонтажей и шинных центров всегда готовы обслужить Вас по самым высоким стандартам.
                    </div>
                    <a href="/gruzoviye-shiny" class="btn-go blue link">Перейти в раздел<span class="arrow"></span></a>
                    <!-- <div class="icon"></div> -->
                </div>

            </div>

            <div class="item retail">

                <div class="wrapper center-block">
                    <div class="title">Розничная<br>сеть</div>
                    <div class="desc">В наших магазинах Вы всегда можете найти широкий выбор автотоваров, способный удовлетворить любого водителя, как легковых, так и грузовых автомобилей. А наша дисконтная система  позволит Вам экономить!
                    </div>
                    <a href="/retail-network" class="btn-go red link">Перейти в раздел<span class="arrow"></span></a>
                    <div class="icon"></div>
                </div>

            </div>

            <? if (!empty($arBanners)):?>
                <? foreach ($arBanners as $banner):?>
                    <li class="item">
                        <div class="wrapper center-block" style="overflow: hidden;"><?= $banner ?></div>
                    </li>
                <? endforeach; ?>
            <? endif; ?>
        </div>
    <?
    }
    ?>

	<div id="main-slider-navigation" class="navigation wrapper center-block">

		<a href="#" data-target="prev" class="slider-nav prev custom"></a>
		<a href="#" data-target="next" class="slider-nav next custom"></a>

		<ul class="tabs numericControls">
			<li data-target="1" class="custom2 wholesale<?if($page_optovaya || $page == '/') echo ' current';?>">
                <a  href="/avtotovary" class="line"><div class="icon"></div><span>Оптовая<br>торговля</span></a>
            </li>
			<li data-target="2" class="custom2 shop">
                <a  href="/shop/" class="line">
                    <div class="icon"></div><span>Интернет<br>магазин</span>
                </a>
            </li>
			<li data-target="3" class="custom2 truck<?if($page_shin_center) echo ' current';?>">
                <a href="/gruzoviye-shiny" class="line">
                    <div class="icon"></div><span>Грузовые<br>шины</span>
                </a>
            </li>
			<li data-target="4" class="custom2 retail<?if($page_retail) echo ' current';?>">
                <a href="/retail-network" class="line">
                    <div class="icon"></div><span>Розничная<br>сеть</span>
                </a>
            </li>
		</ul>

	</div>

	<script>
		$(function(){

			var sudoSlider = $("#main-slider").sudoSlider({
				speed: 800,
				pause: 4000,
				auto: true,
				prevNext: false,
				numeric: false,
				touch: true,
				continuous:true,
				startSlide: <?=intval($startSlide)?>,
				customLink: '.custom',
				controlsFade: true,
				controlsFadeSpeed: '500',
				beforeAnimation: function(t){
					$('#main-slider-navigation .tabs li').removeClass('current');
					$('#main-slider-navigation .tabs li').eq(t-1).addClass('current');
					},
				afterAnimation: function(t){

					}
				});
			});
	</script>

</section>
