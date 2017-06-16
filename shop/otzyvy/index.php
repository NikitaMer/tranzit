<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы  о работе");
?>

<? if ($_POST[add]=='') { ?>

<style type="text/css">
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

h1, h2 {
	font-size: 24px;
	padding-bottom: 32px;
	font-family: Verdana;
	line-height: 100%;
	color: #222;
}

h2 {
	margin-top: 20px
}

.review-count {
	width: 100%;
	border-bottom: 1px solid #dedede;
	/*height: 50px;*/
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
	min-height: 120px;	
}

.review_feedback {
	width: 85%;
	margin-left: 15%;
	margin-top: -30px;
}

.rev-ava,
.rev-ava-feed {
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

.rev-text {
	margin: 10px 15px 45px;
	font-size: 13px;
	font-family: Verdana;
	text-decoration: none;
	min-height: 80px;
}

.feed_rew {
	min-height: auto;
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
	margin-top: 30px;
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

.rev-ava-feed img {
	width: 50px;
	height: 50px;
	margin-top: 10px;
}

.rev-ava p,
.rev-ava-feed p {
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
padding-right:3px;
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
	right: 2px;
	bottom: 2px;
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

.create-mark {
position: absolute;
left: 0;
bottom: -4px;
}



#addrating
{
cursor:pointer;
}

</style>

	<div class="review-count">
		<!--<ul>
			<li OnClick="window.location.href='?count=45';" <? if ($_GET['count']==45) echo ' class="active"';?>>45</li>
			<li OnClick="window.location.href='?count=30';"  <? if ($_GET['count']==30) echo ' class="active"';?>>30</li>
			<li OnClick="window.location.href='?count=15';"  <? if ( ($_GET['count']==15) || ($_GET['count']==0) ) echo ' class="active"';?>>15</li>
		</ul>
		<p>Показывать отзывы по</p>-->
	</div>
	
	<h2 class="mr80">Написать отзыв</h2>
	<div class="create-review">
		<form id="review-form" action method="POST" style="overflow-y: hidden;">
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
				<textarea name="dignity" autocomplete="on" onblur="this.value=(this.value=='')?this.title:this.value;" onfocus="this.value=(this.value==this.title)?'':this.value;" title="Достоинства">Достоинства</textarea>
				<label>ДОСТОИНСТВА</label>
			</div>
			<div class="clear"></div>
			<div class="form-text">
				<textarea name="limitations" autocomplete="on" onblur="this.value=(this.value=='')?this.title:this.value;" onfocus="this.value=(this.value==this.title)?'':this.value;" title="Недостатки">Недостатки</textarea>
				<label>НЕДОСТАТКИ</label>
			</div>
			<div class="clear"></div>
			<div class="form-text">
				<textarea name="mess" onblur="this.value=(this.value=='')?this.title:this.value;" onfocus="this.value=(this.value==this.title)?'':this.value;" title="Напишите Ваш комментарий">Напишите Ваш комментарий</textarea>
				<label>КОММЕНТАРИЙ</label>
			</div>
			<div class="form-button" style="padding-left:120px;">
				<button>ОТПРАВИТЬ</button>
			</div>
			<input type="hidden" id='ratval' name="ratval" value='0%'>
		</form>
			
		<div class="create-mark">
			<p  style='margin-top:8px;'>Оценить работу</p>
			<div class="stars" style="padding-left:60px;">
				<div id="addrating" class="empty-stars">
					<div mousemove="alert(2);" id="rating" style="width:0%"></div>
				</div>
			</div>
		</div>
	</div>
	
<?
$count = "15";
$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"reviews", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "reviews",
		"IBLOCK_ID" => "77",
		"NEWS_COUNT" => $count,
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
			0 => "DIGNITY",
			1 => "LIMITATIONS",
			2 => "DESCRIPTION",
			3 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "reviews",
		"SET_LAST_MODIFIED" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>

<? } else { ?>

Отзыв принят, подождите модерации. 

<?
$el = new CIBlockElement;

$PROP = array();
$PROP[702] = $_POST['phone'];  // свойству с кодом 12 присваиваем значение "Белый"
$PROP[703] = $_POST['ratval'];        // свойству с кодом 3 присваиваем значение 38
$PROP[794] = $_POST['dignity'];
$PROP[795] = $_POST['limitations'];

$arLoadProductArray = Array(
  "MODIFIED_BY"       => $USER->GetID(), // элемент изменен текущим пользователем
  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
  "IBLOCK_ID"         => 77,
  "PROPERTY_VALUES"   => $PROP,
  "NAME"              => $_POST['name'],
  "ACTIVE"            => "N",            // активен
  "PREVIEW_TEXT"      => $_POST['mess']
);

$PRODUCT_ID = $el->Add($arLoadProductArray);

$rsSites = CSite::GetByID("s1"); 
$arSite = $rsSites->Fetch(); 
$mail_to = $arSite["EMAIL"];

$link="
http://www.tranzit-oil.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=77&type=reviews&ID=".$PRODUCT_ID."&lang=ru&find_section_section=-1&WF=Y
";

$POST=array(
"EMAIL_TO"    => $mail_to,
"DIGNITY"     => $_POST[dignity],
"LIMITATIONS" => $_POST[limitations],
"TEXT"        => $_POST[mess],
"NAME"        => $_GET[name],
"PHONE"       => $_GET[phone],
"LINK"        => $link
);

CEvent::Send("NEWREVIEWS", 's1', $POST);
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