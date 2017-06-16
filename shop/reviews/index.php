<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы  о работе");
?>

<? if ($_POST[add]=='') { ?>

<style>
html, body, div, span, ul, ol, li, h1, h2, h3, h4, h5, h6, form, input, img, table, tbody, th, tr, td, a {
	margin: 0;
	padding: 0;
}

p {
	margin: 10px 0;
	padding: 0;
}

html, body {
	height: 100%;
}

a {
	text-decoration: none;
}

ul, ol {
	list-style-type: none;
}

div {
	display: block;
	box-sizing: border-box;
}

html, body, img {
	border: 0;
}

input[type="text"]:focus { 
	outline: none;
}

body {
}

.clear {
	float: none;
	clear: both;
}

.col.main_right {
	position: relative;
	min-height: 100%;
	margin: 0 auto;
	width: 690px;
}

h1 {
	font-size: 24px;
	padding-bottom: 32px;
	font-family: Verdana;
	line-height: 100%;
	color: #222;
}	

.review-count {
	width: 100%;
	height: 50px;

	border-bottom: 1px solid #dedede;
}

.review-count p {
	display: block;
	float: right;
	font-size: 12px;
	font-family: Verdana;
	text-decoration: none;
	font-weight: bold;
}

.review-count ul {
	display: block;
	float: right;
}

.review-count li {
	display: block;
	float: right;
	height: 33px;
	width: 33px;
	border: 1px solid #dedede;
	text-align: center;
	line-height: 33px;
	border-radius: 5px;
	margin-left: 5px;
	font-size: 12px;
	font-family: Verdana;
	text-decoration: none;
	font-weight: bold;
	box-sizing: border-box;
}

.review-count li:hover,
.review-pages li:hover {
	border: 0;
	background: #ffc400;
	cursor: pointer;	
	color: #fff;
}

.review-count li.active,
.review-pages li.active {
	border: 0;
	background: #ffc400;
	color: #fff;	
}

.review-pages {
	width: 100%;
	height: 100px;
}

.review-pages {
	text-align: center;
	margin-top: 10px;
}

.review-pages ul {
	display: inline-block;
}

.review-pages li {
	display: block;
	float: left;
	height: 33px;
	width: 33px;
	text-align: center;
	line-height: 33px;
	border-radius: 5px;
	margin: 20px 8px;
	font-size: 12px;
	font-family: Verdana;
	text-decoration: none;
	font-weight: bold;
	background: #ededed;
}

.review-pages li.first {
	background-color: none;
	background: url('/img/left-arrow.png') no-repeat center center transparent;
	margin: 20px 0;
}

.review-pages li.last {
	background-color: none;
	background: url('/img/right-arrow.png') no-repeat center center transparent;
	margin: 20px 0;
}

.reviews {
	width: 100%;
	border-bottom: 1px solid #dedede;
}

.review {
	width: 100%;
	margin: 50px 0;
	height: 120px;	
}

.rev-ava {
	width: 14%;
	height: 100%;
	float: left;
	text-align: center;
}

.rev-cont {
	width: 85%;
	border: 1px solid #dedede;
	border-radius: 5px;
	height: 100%;
	margin-left: 15%;
	position: relative;
}

.rev-cont p {
	margin: 10px 15px;
	font-size: 13px;
	font-family: Verdana;
	text-decoration: none;
}

.rev-mark {
	position: absolute;
	right: 0;
	bottom: 0;
	width: 40%;
}

.rev-mark p {
	display: block;
	width: 20%;
	float: left;
	color: #9d9d9d;
}

.stars {
	width: 80%;
	margin: 5px 0 0 33%;
}

.empty-stars {
	margin: 0 5px;
	background: url('/img/empty-stars.png') no-repeat 0 0 transparent;
	height: 25px;
	width: 137px;
}

.empty-stars div {
	background: url('/img/stars.png') no-repeat 0 0.5px transparent;
	height: 25px;
}

.rev-ava img {
	height: 63px;
	width: 63px;
	margin-top: 10px;
}

.rev-ava p {
	margin: 3px 0;
	color: #9d9d9d;
	font-size: 12px;
	font-family: Verdana;
	text-decoration: none;
	font-weight: bold;
}

.rev-date {
	font-size: 10px !important;
	font-weight: normal !important;
}

.create-review {
	width: 100%;
	position: relative;
}

.form-name {
	float: left;
}

.form-phone {
	float: right;
}

.form-name input {
	width: 150px;
}

.form-phone  input {
	width: 250px;
}

#review-form input {
	border-radius: 5px 0 0 5px;
	height: 30px;
	border-width: 1px;
	border-style: solid;
	border-color: #dedede transparent #dedede #dedede;
	float: left;
	color: #9d9d9d;
	font-size: 11px;
	font-family: Verdana;
	font-style: italic;
	padding: 0 10px;
}

.form-name label,
.form-phone label {
	width: 70px !important;
	background: #ffc400;
	border-radius: 0 5px 5px 0;
	border-width: 1px;
	border-style: solid;
	border-color: #dedede #dedede #dedede transparent;
	color: #fff;
	font-size: 12px;
	font-family: Verdana;
	text-decoration: none;
	height: 30px;
	display: block;
	float: left;
	text-align: center;
	line-height: 31px;
}

.form-text {
	width: 100%;
	position: relative;
	padding-top: 15px;
}

#review-form textarea {
	width: 97%;
	min-height: 105px;
	border: 1px solid #dedede;
	border-radius: 5px;
	color: #9d9d9d;
	font-size: 11px;
	font-family: Verdana;
	font-style: italic;
	padding: 10px;
	margin: 0;
	resize: none;
	outline: none;
}

.form-text label {
	position: absolute;
	right: -1px;
	bottom: 1px;
	background: #ffc400;
	border-radius: 5px;
	padding: 10px;
	color: #fff;
	font-size: 11px;
	font-family: Verdana;
	text-decoration: none;
}

.form-button {
	width: 100%;
	text-align: center;
}

#review-form button {
	background: #ffc400;
	border-radius: 5px;
	padding: 2px 14px;
	color: #fff;
	font-size: 13px;
	font-family: Verdana;
	text-decoration: none;
	border: 0;
	margin-top: 20px;
	cursor: pointer;
}

.create-mark {
	position: absolute;
	left: 0;
	bottom: 0;
}

.create-mark p {
	display: block;
	float: left;
	color: #222;
	float: left;
	font-family: Verdana;
	font-size: 14px;
	font-weight: bold;
}

.create-mark img {
	margin: 10px 8px;
	height: 18px;
	width: 103px;
}

#addrating
{
cursor:pointer;
}

</style>

		<div class="review-count">
			<ul>
				<li class="active">30</li>
				<li>20</li>
				<li>10</li>
			</ul>
			<p>Показывать отзывы по</p>
		</div>







<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"reviews", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "Y",
		"IBLOCK_TYPE" => "reviews",
		"IBLOCK_ID" => "77",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "DATE_CREATE",
			2 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "DESCRIPTION",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_STATUS_404" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "arrows",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "reviews"
	),
	false
);?>




<h1 class="mr80">Написать отзыв</h1>
		<div class="create-review">
			<form id="review-form" action method="POST">
<input type='hidden' name='add' value='ok'>
				<div class="form-name">
					<input name="name" autocomplete="on" onblur="this.value=(this.value=='')?this.title:this.value;" onfocus="this.value=(this.value==this.title)?'':this.value;" value="Введите Ваше имя" title="Введите Ваше имя" type="text" />
					<label>ИМЯ</label>
				</div>
				<div class="form-phone">
					<input name="phone" autocomplete="on" onblur="this.value=(this.value=='')?this.title:this.value;" onfocus="this.value=(this.value==this.title)?'':this.value;" value="Отображаться в комментариях не будет" title="Отображаться в комментариях не будет" type="text" />
					<label>ТЕЛЕФОН</label>
				</div>
				<div class="clear"></div>
				<div class="form-text">
					<textarea name="mess" onblur="this.value=(this.value=='')?this.title:this.value;" onfocus="this.value=(this.value==this.title)?'':this.value;" title="Отображаться в комментариях не будет">Отображаться в комментариях не будет</textarea>
					<label>КОММЕНТАРИЙ</label>
				</div>
				<div class="form-button" style="padding-left:120px;">
					<button>ОТПРАВИТЬ</button>
				</div>	
			</form>
			<div class="create-mark">
				<p>Оценить работу</p>
				<div class="stars" style="padding-left:80px;">
	       <div id="addrating" class="empty-stars">
<input type="hidden" id='ratval' name="ratval" value='0%'>
<div mousemove="alert(2);" id="rating" style="width:0%"></div></div>
						</div>
			</div>
		</div>
		
<? } else { ?>

Отзыв принят, подождите модерации. 

<?
$el = new CIBlockElement;

$PROP = array();
$PROP[702] = $_POST['phone'];  // свойству с кодом 12 присваиваем значение "Белый"
$PROP[703] = $_POST['rating'];        // свойству с кодом 3 присваиваем значение 38

$arLoadProductArray = Array(
  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
  "IBLOCK_ID"      => 77,
  "NAME"           => $_POST[name],
  "ACTIVE"         => "N",            // активен
  "PREVIEW_TEXT"   => $_POST[mess],
  );

$PRODUCT_ID = $el->Add($arLoadProductArray);

?>


<? } ?>

<script>

var cl=0;

$('#addrating').mousemove(function(e){
 var x1 = ( e.pageX - $(this).offset().left) / 27/5*100; 

if (cl==0) $('#rating').css('width',x1+'%');

});



$("#addrating").click(function(e){
if (cl==0) {
cl=1; 
oc=$('#rating').css('width').replace('px','')/27;
$('#ratval').val(oc.toFixed(2));

} else { cl=0;}

});


</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>