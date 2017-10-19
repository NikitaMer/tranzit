<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);
?>
<form class="add_car_form">
    <div class="block"><p>Текст</p></div>
    <div class="text">Внимательно заполните все поля формы и нажмите кнопку "ОТПРАВИТЬ"</div>
    <label><input class="VIN" placeholder="VIN"></label>        
    <label><input class="VIN_2" placeholder="VIN 2"></label>        
    <label class="label-padding-right"><input class="mark" placeholder="Марка автомобиля"></label>        
    <label class="label-padding-left"><input class="year" placeholder="Год выпуска, г"></label>        
    <label class="label-padding-right"><input class="cap" placeholder="Объем двигателя, л"></label>        
    <label class="label-padding-left"><input class="HP" placeholder="Лошадиные силы, л.с."></label>
    <label><textarea cols="" rows="" placeholder="Перечень запасных частей"></textarea></label>
    <label class="label-padding-right"><input class="name" placeholder="Имя"></label>        
    <label class="label-padding-right label-padding-left"><input class="phone" name="phone" placeholder="Телефон"> </label>       
    <label class="label-padding-left"><input class="email" placeholder="E-mail"></label>
    <button>Отправить</button>    	
</form>