
				</div>
			</section>
		</div><!-- end container -->

		<footer<?if($BLUE):?> class="theme-blue"<?endif;?>>
			<div class="wrapper center-block">
<?/*
                <div class="partner" id="partner-slider">
                    <ul>
                        <li>
							<div><a href="#"><img src="img/partner/valvoline.png"/></a></div>
							<div><a href="#"><img src="img/partner/mobil.png"/></a></div>
							<div><a href="#"><img src="img/partner/total.png"/></a></div>
							<div><a href="#"><img src="img/partner/castrol.png"/></a></div>
							<div><a href="#"><img src="img/partner/shell.png"/></a></div>
							<div><a href="#"><img src="img/partner/valvoline.png"/></a></div>
							<div><a href="#"><img src="img/partner/mobil.png"/></a></div>
						</li>
						<li>
							<a href="#"><img src="img/partner/valvoline.png"/></a>
							<a href="#"><img src="img/partner/mobil.png"/></a>
							<a href="#"><img src="img/partner/total.png"/></a>
							<a href="#"><img src="img/partner/castrol.png"/></a>
							<a href="#"><img src="img/partner/shell.png"/></a>
							<a href="#"><img src="img/partner/valvoline.png"/></a>
							<a href="#"><img src="img/partner/mobil.png"/></a>
						</li>
                    </ul>
                </div>
*/?>
						
				<div class="partner" id="partner-slider">
                    <ul>
                        <li><table>
							<tr>
							<td><a href="#"><img src="img/partner/valvoline.png"/></a></td>
							<td><a href="#"><img src="img/partner/mobil.png"/></a></td>
							<td><a href="#"><img src="img/partner/total.png"/></a></td>
							<td><a href="#"><img src="img/partner/castrol.png"/></a></td>
							<td><a href="#"><img src="img/partner/shell.png"/></a></td>
							<td><a href="#"><img src="img/partner/mobil.png"/></a></td>
							<td><a href="#"><img src="img/partner/valvoline.png"/></a></td>
							</tr>
							</table>
						</li>
						<li>
							<table>
							<tr>
							<td><a href="#"><img src="img/partner/valvoline.png"/></a></td>
							<td><a href="#"><img src="img/partner/mobil.png"/></a></td>
							<td><a href="#"><img src="img/partner/total.png"/></a></td>
							<td><a href="#"><img src="img/partner/castrol.png"/></a></td>
							<td><a href="#"><img src="img/partner/shell.png"/></a></td>
							<td><a href="#"><img src="img/partner/mobil.png"/></a></td>
							<td><a href="#"><img src="img/partner/valvoline.png"/></a></td>
							</tr>
							</table>
						</li>
                    </ul>
                </div>
				
				<script>
                    var sudoSliderPartner;

					$(function(){
						 sudoSliderPartner = $("#partner-slider").sudoSlider({
							speed: 900,
							pause: 3000,
							auto:true,
							prevNext: false,
							numeric: false,
							touch: true,
							continuous:true,
							});
						
						});
				</script>

						 

				<div class="footer_line">
				
					<div class="info">
						&copy; 2005-<?=date('Y');?> Tranzit-oil
					</div>

					<div class="icon-blocks">
                        <a href="app/getprice.php" target="_blank" class="block getprice open_ajax">
                            <div class="ico"><span></span></div>
                            <div class="desc"><span>Запросить<br>прайс лист</span></div>
                        </a>

                        <div class="block phone">
                            <div class="ico"><span></span></div>
                            <div class="desc">
                                <span>222-8-590</span> - магазин<br>
                                <span>226-85-81</span> - офис
                            </div>
                        </div>
					</div>

					<div class="search-line"> 
						<form action="" method="get">
							<input type="text" placeholder="Поиск по сайту" value=""> 
							<input type="submit" value="">
						</form>
					</div>
					
				</div>

			</div>
		</footer>
		
		
		
		<script>
			$(function(){
				var e = GetEmail('117114046116110101105108099050108108097099064116114111112112117115');
				$('.contact_email').html(e);
				$('.contact_email').attr('href', 'mailto:' + e);
				

				
				$(".app").fancybox({
					//wrapCSS: 'fancybox-custom',
					//titlePosition		: 'outside',
					//overlayColor		: '#000',
					//centerOnScroll		: false,
					//overlayOpacity	: 0.4
					});

				});
		</script>
  </body>
</html>