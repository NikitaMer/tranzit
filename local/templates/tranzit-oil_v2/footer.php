<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

/** @var @var $CSiteController  SiteController*/
$CSiteController = SiteController::getEntity();

?>
					<?if(strpos($CSiteController->getPath(), '/shop/personal/') == 0 ):?>
						</div>
					</div>
					<?endif;?>

                    <?if($CSiteController->needColumn()):?>

						</div><!-- end right column -->
					</div><!-- end columns -->
                    <?endif;?>
				</div>
                <!-- end wrapper -->
			</section>
			<!-- end section content -->
		</div>
        <!-- end container -->

		<footer class="<?if($CSiteController->getSiteSection() == $CSiteController::SECT_SHOP):?>bottom-line<?endif;?><?=$theme_class?>">
			<div class="wrapper center-block">

				<!-- partner slider -->
                <?
                #==================================================================
                # подключение нижнего сладера
                #==================================================================
                if(strpos($CSiteController->getPath(), '/avtotovary/') === 0 && file_exists(dirname(__FILE__).'/sliders/slider_footer_avtotovari.php'))
                    include(dirname(__FILE__).'/sliders/slider_footer_avtotovari.php');
                elseif(file_exists(dirname(__FILE__).'/sliders/slider_footer.php'))
                    include(dirname(__FILE__).'/sliders/slider_footer.php');
                ?>
				<!-- end partner slider -->

				<div class="footer_line">
				
					<div class="info">
						&copy; 2003-<?=date('Y');?> Tranzit-oil
					</div>

					<!-- icon block -->
					<div class="icon-blocks">
                        <?if($CSiteController->getSiteSection() == $CSiteController::SECT_SHOP):?>

							<?$APPLICATION->IncludeComponent(
								"bitrix:sale.basket.basket.small",
								"icon_block",
								array(
									"PATH_TO_BASKET" => "/shop/cart/",
									"PATH_TO_ORDER" => "/shop/cart/order.php",
									"SHOW_DELAY" => "N",
									"SHOW_NOTAVAIL" => "N",
									"SHOW_SUBSCRIBE" => "N"
								),
								false
							);?>

                        <?else:?>
                            <a href="/local/ajax/getprice.php" target="_blank" class="block getprice open_ajax">
                                <div class="ico"><span></span></div>
                                <div class="desc"><span>Запросить<br>прайс лист</span></div>
                            </a>
                        <?endif;?>

                        <div class="block phone">
                            <div class="ico"><span></span></div>
                            <div class="desc">
								<?if($CSiteController->isShop()):?>
									<span class="phone">8 843 222-90-14</span><span>&nbsp;&nbsp; -&nbsp;</span>Казань<br>
									<span class="phone">8 967 379-98-62</span><span>&nbsp; -&nbsp;</span>Наб. Челны
								<?else:?>
									<span class="phone">222-85-90</span><span> -&nbsp;</span>оптовый отдел<br>
									<span class="phone">222-90-14</span><span> -&nbsp;</span>интернет-магазин
								<?endif;?>
							</div>
                        </div>
						
					</div>
					<!-- end icon block -->

					<?if($CSiteController->getSiteSection() != $CSiteController::SECT_SHOP):?><?endif;?>

                    <?/*$APPLICATION->IncludeComponent("bitrix:search.title", "mini", Array(
                            "NUM_CATEGORIES" => "1",	// Количество категорий поиска
                            "TOP_COUNT" => "5",	// Количество результатов в каждой категории
                            "ORDER" => "date",	// Сортировка результатов
                            "USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
                            "CHECK_DATES" => "Y",	// Искать только в активных по дате документах
                            "SHOW_OTHERS" => "Y",	// Показывать категорию "прочее"
                            "PAGE" => "#SITE_DIR#search/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
                            "CATEGORY_0_TITLE" => "",	// Название категории
                            "CATEGORY_0" => array(	// Ограничение области поиска
                                0 => "no",
                            ),
                            "SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
                            "INPUT_ID" => "title-search-input-footer",	// ID строки ввода поискового запроса
                            "CONTAINER_ID" => "title-search-footer",	// ID контейнера, по ширине которого будут выводиться результаты
                        ),
                        false
                    );*/?>

					
				</div>

			</div>
		</footer>

        <?if($CSiteController->getSiteSection() == $CSiteController::SECT_SHOP):?>
        <div class="catalog-line">
            <div class="wrapper center-block">

                <a href="/local/ajax/ask_question.php" class="button open_ajax">Написать директору</a>
				
				<!-- Соц. кнопки -->
				<div class="soc_foot">
					<a href="https://vk.com/tranzitshop" target="_blank"><img src="/local/templates/tranzit-oil_v2/img/vk.png"></a>
					<a href="https://www.facebook.com/Интернет-магазин-Tranzit-shopru-1188521421197537​" target="_blank"><img src="/local/templates/tranzit-oil_v2/img/facebook.png"></a>
					<a href="https://www.instagram.com/tranzitshop.ru" target="_blank"><img src="/local/templates/tranzit-oil_v2/img/instagram.png"></a>
				</div>

                <div class="right-block">

					<?
					//количество элементов в сравнении
					$catalog_compare_count = count($_SESSION['CATALOG_COMPARE_LIST'][CATALOG_IBLOCK_ID]['ITEMS']);
					?>

                    <div class="sep link<?if($catalog_compare_count):?> active<?endif;?>">
                        <div class="ballon compare"><div class="text_data">Добавлено</div></div>
                        <a class="icon icon16 compare" href="/catalog/compare.php?action=COMPARE&amp;IBLOCK_ID=<?=CATALOG_IBLOCK_ID?>">Сравнение</a><div class="counter"><?=$catalog_compare_count?></div>
                    </div>

					<?
					//количество элементов в закладках
					$count_favorites = 0; //обновление данных через скрипт


					if(\Bitrix\Main\Loader::includeModule('wsm.favorites'))
					{
						if($GLOBALS['USER']->IsAuthorized())
						{
							$arFields = array('USER_ID' => $GLOBALS['USER']->GetID());
							$rsFav = WSMFavorites::GetList(array(), $arFields);
							$count_favorites = $rsFav->SelectedRowsCount();
						}
						else
						{
							$favCookie = new CWSMFavoritesCookies(SITE_ID);
							$rs = $favCookie->GetList();
							$count_favorites = $rs->SelectedRowsCount();
						}

					}


					?>
                    <div class="sep link <?if($count_favorites > 0):?>active<?endif;?>">
                        <div class="ballon favorite"><div class="text_data">Добавлено</div></div>
                        <a class="icon icon16 favorite" href="/shop/favorites/">Закладки</a><div class="counter"><?=$count_favorites?></div>
                    </div>

					<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "footer", array(
							"PATH_TO_BASKET" => "/shop/cart/",
							"PATH_TO_ORDER" => "/shop/cart/order.php"
							),
							false
							);?>
							
                    
                </div>
            </div>
        </div>
        <?endif;?>

        <?/*
        global $USER;
        if (!$USER->IsAdmin()):?
        


		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-39832435-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>

		<?endif;*/?>
	<script>
		var fav_count = 0;


		var CFavorites;
		BX.ready(function(){

			if(typeof window.BX.WSMFavorites == 'function'){

				CFavorites = new BX.WSMFavorites({
					'link': 'add2favorite',     	      //класс ссылок
					//'fav_text':   '<span>В закладках</span>',    //текст ссылки при наличии в избранном
					//'nofav_text': '<span>В закладки</span>',    //текст ссылки при отсутсвии в избранном
					'fav_class' : 'favorites',      //класс ссылки при наличии в избранном
					onInit: function(links){
						//console.log('WSMFavorites onInit');
						},
					onGetTotal: function(total){
						//console.log('WSMFavorites onGetTotal', total);
						SetFavCounter(total);
						},
					onClick: function(ID, chacked, link){

                        if(typeof ShowNotice == 'function' && !chacked)
                            ShowNotice('favorite');
						},
					onStatusChange: function(id, checked, elements){ 

                        console.log('WSMFavorites onStatusChange', id, checked, elements);

						for(i in elements){

                            if(checked)
                                $(elements[i]).addClass('active');
                            else
                                $(elements[i]).removeClass('active');

                            if($(elements[i]).hasClass('notext')){
                                $(elements[i]).html('');

                                }
                            else{
                                if(checked)
                                    $(elements[i]).html('<span>В закладках</span>');
                                else
                                    $(elements[i]).html('<span>В закладки</span>');

                            }
							}
						},

					onError: function(err){
						console.warn('WSMFavorites onError', err);
						}
					});

			}

		});
	</script>

<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-24228182-1', 'auto');

  function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)" 
    ));

    return matches ? decodeURIComponent(matches[1]) : "";
 }

  ga('set', 'dimension1', getCookie("_ga"));
  ga('require', 'displayfeatures'); 
  ga('send', 'pageview');

</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter24101779 = new Ya.Metrika({
                    id:24101779,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    ecommerce:"dataLayer"
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/24101779" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


	<?if($CSiteController->isShop()):?>
	<!-- START ME-TALK -->
	<script type='text/javascript'>
		(function() {
			var s = document.createElement('script');
			s.type ='text/javascript';
			s.id = 'supportScript';
			s.charset = 'utf-8';
			s.async = true;
			s.src = '//me-talk.ru/support/support.js?h=8d7f8ced132e6f5354698cbdc1148b7d';
			var sc = document.getElementsByTagName('script')[0];
			
			var callback = function(){
				/*
					Здесь вы можете вызывать API. Например, чтобы изменить отступ по высоте:
					supportAPI.setSupportTop(200);
				*/
			};
			
			s.onreadystatechange = s.onload = function(){
				var state = s.readyState;
				if (!callback.done && (!state || /loaded|complete/.test(state))) {
					callback.done = true;
					callback();
				}
			};
			
			if (sc) sc.parentNode.insertBefore(s, sc);
			else document.documentElement.firstChild.appendChild(s);
		})();
	</script>
	<!-- END ME-TALK -->
	
	<!-- start reformal
	<script type="text/javascript">
		var reformalOptions = {
			project_id: 972755,
			project_host: "tranzit-shop.reformal.ru",
			tab_orientation: "left",
			tab_indent: "75%",
			tab_bg_color: "#f00000",
			tab_border_color: "#FFFFFF",
			tab_image_url: "http://tab.reformal.ru/0J%252FQvtGA0YPQs9Cw0LnRgtC1INC90LDRgQ==/FFFFFF/c77740adc7650bd701a89105c96ba1f5/left/1/tab.png",
			tab_border_width: 2
		};
		
		(function() {
			var script = document.createElement('script');
			script.type = 'text/javascript'; script.async = true;
			script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'media.reformal.ru/widgets/v3/reformal.js';
			document.getElementsByTagName('head')[0].appendChild(script);
		})();
	</script><noscript><a href="http://reformal.ru"><img src="http://media.reformal.ru/reformal.png" /></a><a href="http://tranzit-shop.reformal.ru">Поругайте нас</a></noscript>
	 end reformal -->

<script type="text/javascript" src="https://keplerleads.com/init.js"></script>
<script type="text/javascript">
    Kepler.init({id: 352});
</script>


	<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=SNwLlgn4O6iIx7odNIunyQIHzmKwIw43m2vfseZjgKWwwmuAGZVry0WT1Ci5OUXC*APdfO0gdgu3MMHfhs5n9AxLHkVg6liKFUSdWUzvgKdZ4JYdQtLDGh1Z8z8H0K6bbLTZB19uh8oLP8KztdOji2otBdRpNQaKf9rkVZ2*bTo-';</script>
	<?endif;?>

  </body>
</html>
<?
if(!$CSiteController->isMainPage())
{
	#$APPLICATION->SetDirProperty('H1', $APPLICATION->GetTitle().' — «Транзит ойл»');
    $APPLICATION->SetDirProperty('title', $APPLICATION->GetTitle().' — «Транзит ойл»');
	#$APPLICATION->SetPageProperty('title', $APPLICATION->GetTitle().' — «Транзит ойл»');
}
?><?

require($_SERVER["DOCUMENT_ROOT"]."/neworder.php");

?>