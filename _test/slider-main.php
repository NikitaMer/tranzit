
<section class="slider">

	<ul class="slides" id="main-slider">
		<li class="item wholesale">

			<div class="wrapper center-block">
				<div class="title">Оптовая продажа <br>автотоваров</div>
				<div class="desc">
					Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации систем массового участия. Постоянное информационно-пропагандистское обеспечение.
				</div>
				<a href="/wholesale/" class="btn-go black red link">Перейти в раздел<span class="arrow"></span></a>
				<div class="icon"></div>
			</div>

		</li>

		<li class="item shop">

			<div class="wrapper center-block">
				<div class="title">Интернет магазин<br>автотоваров</div>
				<div class="desc">Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации систем массового участия. Постоянное информационно-пропагандистское обеспечение.
				</div>
				<a href="http://www.tranzit-shop.ru/" target="_blank"  class="btn-go black yellow link">Перейти в раздел<span class="arrow"></span></a>
				<div class="icon"></div>
			</div>

		</li>

		<li class="item truck">

			<div class="wrapper center-block">
				<div class="title">Грузовой<br>шинный центр</div>
				<div class="desc">Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации систем массового участия. Постоянное информационно-пропагандистское обеспечение.
				</div>
				<a href="/truck-tire-center/" class="btn-go blue link">Перейти в раздел<span class="arrow"></span></a>
				<div class="icon"></div>

			</div>

		</li>

		<li class="item retail">

			<div class="wrapper center-block">
				<div class="title">Розничная<br>сеть</div>
				<div class="desc">Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации систем массового участия. Постоянное информационно-пропагандистское обеспечение.
				</div>
				<a href="/retail-network/" class="btn-go red link">Перейти в раздел<span class="arrow"></span></a>
				<div class="icon"></div>
			</div>

		</li>

        <li class="item retail">

            <div class="wrapper center-block">
                <div class="title">Акция</div>

            </div>

        </li>

	</ul>

	<div id="main-slider-navigation" class="navigation wrapper center-block">
		
		<a href="#" data-target="prev" class="slider-nav prev custom"></a>
		<a href="#" data-target="next" class="slider-nav next custom"></a>

		<ul class="tabs numericControls">
			<li data-target="1" class="custom wholesale"><div class="line"><div class="icon"></div><span>Оптовая<br>торговля</span></div></li>
			<li data-target="2" class="custom shop"><div class="line"><div class="icon"></div><span>Интернет<br>магазин</span></div></li>
			<li data-target="3" class="custom truck"><div class="line"><div class="icon"></div><span>Грузовой<br>шинный центр</span></div></li>
			<li data-target="4" class="custom retail"><div class="line"><div class="icon"></div><span>Розничная<br>сеть</span></div></li>
		</ul>
		
		
		
	</div>
<?/*
<div class="icon"></div><span>Оптовая<br>торговля</span>
*/?>
</section>

<script>
	var slideMainImg = {
		0: 'img/slider/slide-bg.jpg',
		1: 'img/slider/slide-bg2.jpg',
		2: 'img/slider/slide-bg3.jpg',
		3: 'img/slider/slide-bg4.jpg'
		};

	$(function(){
	
		 var sudoSlider = $("#main-slider").sudoSlider({
			speed: 800,
			pause: 3000,
			auto:true,
			prevNext: false,
			numeric: false,
			touch: true,
			continuous:true,
			//controlsAttr:'#controlsid',
			//numericAttr: 'class="numericControls"',
			customLink: '.custom',
			controlsFade: true,
			controlsFadeSpeed: '300',
			beforeAnimation: function(t){
				$('#main-slider-navigation .tabs li').removeClass('current');
				$('#main-slider-navigation .tabs li').eq(t-1).addClass('current');
				},
			afterAnimation: function(t){

				}
			});
		
		
		});
</script>