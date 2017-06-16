
<section class="slider-inner">

	<ul class="slides" id="inner-slider">
		<li class="item">

			<div class="wrapper center-block">
				<div class="title">Оптовая продажа <br>автотоваров</div>
				<div class="desc">
					Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации систем массового участия. Постоянное информационно-пропагандистское обеспечение.
				</div>
				<a href="#" class="btn-go red">Подробнее
					<span class="arrow"></span>
				</a>
			</div>

		</li>

		<li class="item">

			<div class="wrapper center-block">
				<div class="title">Интернет магазин<br>автотоваров</div>
				<div class="desc">Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации систем массового участия. Постоянное информационно-пропагандистское обеспечение.
				</div>
				<a href="#" class="btn-go red">Подробнее
					<span class="arrow"></span>
				</a>
			</div>

		</li>

		<li class="item">

			<div class="wrapper center-block">
				<div class="title">Грузовой<br>шинный центр</div>
				<div class="desc">Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации систем массового участия. Постоянное информационно-пропагандистское обеспечение.
				</div>
				<a href="#" class="btn-go red">Подробнее
					<span class="arrow"></span>
				</a>
			</div>

		</li>

	</ul>

	<div id="inner-slider-navigation" class="navigation wrapper center-block">
		
		<a href="#" data-target="prev" class="slider-nav prev custom"></a>
		<a href="#" data-target="next" class="slider-nav next custom"></a>

		<ul class="tabs numericControls">
			<li data-target="1" class="custom">1</li>
			<li data-target="2" class="custom">2</li>
			<li data-target="3" class="custom">3</li>
		</ul>
	</div>

</section>

<script>
	var slideMainImg = {
		0: 'img/slider/slide-bg.jpg',
		1: 'img/slider/slide-bg2.jpg',
		2: 'img/slider/slide-bg3.jpg',
		3: 'img/slider/slide-bg4.jpg'
		};

	$(function(){
	
		 var sudoSlider = $("#inner-slider").sudoSlider({
			speed: 800,
			pause: 2000,
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