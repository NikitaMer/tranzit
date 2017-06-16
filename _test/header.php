<?
$BLUE = defined('SHIN_CENTER_PAGE');
$RETAIL = defined('RETAIL_PAGE');
?><!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Транзит Оил</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="robots" content="index, follow" />
		
		<link href="styles.css?2" type="text/css"  rel="stylesheet" />
		<link href="font/styles.css" type="text/css"  rel="stylesheet" />

	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		
		<script type="text/javascript" src="fancyapp/jquery.fancybox.pack.js?v=2.1.5"></script>
		<link rel="stylesheet" type="text/css" href="fancyapp/jquery.fancybox.css?v=2.1.5" media="screen" />

		<?
		/*
		<script type="text/javascript" src="js/jquery.slides.min.js"></script>
		*/
		?>
		<script type="text/javascript" src="js/jquery.sudoSlider.min.js"></script>
		

	    <script src="js/mail.js"></script>
	    <script src="js/script.js"></script>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

	</head> 
	<body>
		<div class="container<?if($BLUE):?> theme-blue<?endif;?>">
		
			<section class="top-menu">
				<div class="wrapper center-block">

					<nav class="main-nav">
						<ul class="layer1">
							<li><a href="/">
							<?if(defined('IS_MAIN_PAGE')):?>
							Главная
							<?else:?>
							<div class="return"></div>На главную страницу
							<?endif;?>
							</a>
							</li>
                            <li class="sep"></li>
							<li class="parent">
								<a href="shop.php">Интернет магазин</a><span class="menu-down"></span>
								<ul>
									<li><a href="#">Автомасла</a></li>
									<li><a href="#">Фильтры</a></li>
									<li><a href="#">Автохимия</a></li>
									<li><a href="#">Охлаждающие жидкости</a></li>
									<li><a href="#">Аккумуляторы</a></li>
									<li><a href="#">Аксессуары</a></li>
									<li><a href="#">Видеорегистраторы</a></li>
									<li><a href="#">Грузовые шины</a></li>
									<li><a href="#">Запасные части</a></li>
								</ul>
							</li>
                            <li class="sep"></li>
							<li class="parent">

                                <a href="about.php">О компании</a><span class="menu-down"></span>
                                <ul>
                                    <li><a href="about.php">О компании</a></li>
                                    <li><a href="#">Портфель брендов</a></li>
                                    <li><a href="#">Социальная ответстенность</a></li>
                                    <li><a href="#">Спонсорство</a></li>
                                    <li><a href="galery.php">Фото-галерея</a></li>
                                </ul>

                            </li>
                            <li class="sep"></li>
							<li><a href="vacance.php">Вакансии</a></li>
                            <li class="sep"></li>
							<li class="parent"><a href="poleznoe.php">Полезные советы</a>
                                <span class="menu-down"></span>
                                <ul>
                                    <li><a href="faq.php">FAQ</a></li>
                                    <li><a href="#">Подбор автотоваров</a></li>
                                    <li><a href="#">Статьи</a></li>
                                </ul></li>
                            <li class="sep"></li>
							<li class="parent"><a href="contacts.php">Контакты</a></li>
						</ul>
					</nav>
					
					<div class="search-line"> 
						<form action="" method="get">
							<input type="text" placeholder="Поиск по сайту" value="">
							<input type="submit" value="">
						</form>
					</div>
                    <script>
                        $(function(){
                            var inp = $('.top-menu .search-line input[type=text]');
                            inp.focus(function(){
                                $(this).parents('.search-line').addClass('active');
                                });
                            inp.blur(function(){
                                $(this).parents('.search-line').removeClass('active');
                                });
                        })
                    </script>
					
				</div>
			</section>
			
			<header>
				
				<div class="wrapper center-block">

					<a class="logo" href="/">
						<?if($BLUE):?>
							<img src="img/logo-shincenter.png" alt=""/>
						<?elseif($RETAIL):?>
							<img src="img/logo-retail.png" alt=""/>
						<?else:?>
							<img src="img/logo.png" alt=""/>
						<?endif;?>
						
					</a>

					<div class="icon-blocks">

						<a href="app/getprice.php" target="_blank" class="block getprice open_ajax">
							<div class="ico"><span></span></div>
							<div class="desc"><span>Запросить<br>прайс лист</span></div>
						</a>
						
						<div class="block phone">
							<div class="ico phone"><span></span></div>
							<div class="desc">
								<span>222-8-590</span> - магазин<br>
								<span>226-85-81</span> - офис
							</div>
						</div>
						
						<div class="block personal" id="auth-container">
							<div class="ico user"><span></span></div>
							<div class="desc">
								<a class="personal" href="#"><span>Личный кабинет</span></a>
								<a class="open_ajax login" href="app/auth.php">Вход</a><div class="sep"></div><a class="open_ajax registr" href="app/reg.php">Регистрация</a>
							</div>
						</div>
					
					</div>
				</div>
			</header>

			<?
            if(defined('IS_MAIN_PAGE'))
                include('slider-main.php');
            else
                include('slider-inner.php');
            ?>

			<section class="content">
				<div class="wrapper center-block">