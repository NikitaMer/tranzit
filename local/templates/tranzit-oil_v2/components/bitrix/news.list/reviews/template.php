<div class="reviews">

<?foreach($arResult["ITEMS"] as $arItem):?>

<?

$s=ceil(strlen($arItem[PREVIEW_TEXT])/140)*40+55;
if ($s<120) $s=120;

$dt=explode(' ',$arItem[DATE_CREATE]);
$dt=$dt[0];

$ow=round($arItem[PROPERTIES][OCENKA][VALUE]/5*100);

$dignity = $arItem[PROPERTIES][DIGNITY][VALUE];
$limitations = $arItem[PROPERTIES][LIMITATIONS][VALUE];
$preview_text = $arItem[PREVIEW_TEXT];

$comment_shop = $arItem[PROPERTIES][COMMENT][VALUE];
?>

<div class="review">
	<div class="rev-ava">
		<img src="/img/avatar.png">
		<p class="rev-name"><?=$arItem[NAME];?></p>
		<p class="rev-date">Дата <span><?=$dt;?></span></p>
	</div>
	
	<div class="rev-cont">
	    <div class="rev-text">
            <?php if (isset($dignity) && !empty($dignity)) { ?>
			    <p><strong>Достоинства:</strong><br/> <?=$dignity;?></p>
			<?php } ?>
			
			<?php if (isset($limitations) && !empty($limitations)) { ?>
			    <p><strong>Недостатки:</strong><br/> <?=$limitations;?></p>
			<?php } ?>
			
			<?php if (isset($preview_text) && !empty($preview_text)) { ?>
			    <p><strong>Комментарий:</strong><br/> <?=$preview_text;?></p>
			<?php } ?>
		</div>
		
		<div class="rev-mark">
			<p>Оценка</p>
			<div class="stars">
				<div class="empty-stars">
				    <div style="width: <?=$ow;?>%"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if (isset($comment_shop) && !empty($comment_shop)) { ?>
<div class="review_feedback">
	<div class="rev-ava-feed">
		<img src="/img/avatar.png">
		<p class="rev-name">tranzit-oil</p>
	</div>
	
	<div class="rev-cont">
	    <div class="rev-text feed_rew">
			    <p><strong>Комментарий магазина:</strong><br/> <?=$comment_shop;?></p>
		</div>
	</div>
</div>
<?php } ?>

<?endforeach;?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

</div>