<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult["ERROR_MESSAGE"])): 
?>
<div class="vote-note-box vote-note-error">
	<div class="vote-note-box-text"><?=ShowError($arResult["ERROR_MESSAGE"])?></div>
</div>
<?
endif;

if (!empty($arResult["OK_MESSAGE"])): 
?>
<div class="vote-note-box vote-note-note">
	<div class="vote-note-box-text"><?=ShowNote($arResult["OK_MESSAGE"])?></div>
</div>
<?
endif;

if (empty($arResult["VOTE"]) || empty($arResult["QUESTIONS"]) ):
	return true;
endif;

?>
<div class="vote-items-result">

<?
$iCount = 0;
foreach ($arResult["QUESTIONS"] as $arQuestion):
	$iCount++;

?>
	<div class="vote">

		<div class="vote-item-header">
			<div class="vote-item-question"><?=$arQuestion["QUESTION"]?></div>
		</div>

		<?if ($arQuestion["DIAGRAM_TYPE"] == "circle"):?>

			<img width="150" height="150" src="<?=$componentPath?>/draw_chart.php?qid=<?=$arQuestion["ID"]?>&dm=150" /></td>

			<?foreach ($arQuestion["ANSWERS"] as $arAnswer):?>
				<ul class="answers">
					<li><div class="vote-bar-square" style="background-color:#<?=$arAnswer["COLOR"]?>"></div></li>
					<li><nobr><?=$arAnswer["COUNTER"]?> (<?=$arAnswer["PERCENT"]?>%)</nobr></li>
					<li><?=$arAnswer["MESSAGE"]?></li>
				</ul>
			<?endforeach?>

		<? else://histogram ?>

			<div class="answers">
			<?foreach ($arQuestion["ANSWERS"] as $arAnswer):?>
				<div class="answer">
				<?/* if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']])):?>
					<div style='width:80%; height:1px; background-color:#<?=$arAnswer["COLOR"]?>;'></div>
				<? endif; */?>


				<?/* if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']]))
					{
						if (trim($arAnswer["MESSAGE"]) != '')
							echo '&nbsp';
						echo '('.GetMessage('VOTE_GROUP_TOTAL') .')';
					}*/
				?>

					<? $percent = round($arAnswer["BAR_PERCENT"] * 0.8); // (100% bar * 0.8) + (20% span counter) = 100% td ?>

					<div class="title">
						<?=$arAnswer["MESSAGE"]?>
						<span class="counter">
						<nobr><?=($arAnswer["COUNTER"] > 0?'&nbsp;':'')?><?=$arAnswer["COUNTER"]?> (<?=$arAnswer["PERCENT"]?>%)</nobr>
						</span>
					</div>
					<div class="bar">
						<div class="bar-pesent" style="width:<?=$percent?>%;background-color:#<?=$arAnswer["COLOR"]?>"></div>
					</div>
					<span class="answer-counter">

					</span>

					<?/* if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']])): ?>
						<? $arGroupAnswers = $arResult['GROUP_ANSWERS'][$arAnswer['ID']]; ?> 

						<?foreach ($arGroupAnswers as $arGroupAnswer):?>
							<? $percent = round($arGroupAnswer["PERCENT"] * 0.8); // (100% bar * 0.8) + (20% span counter) = 100% td ?>


									<? if (trim($arAnswer["MESSAGE"]) != '') { ?>
										<span class='vote-answer-lolight'><?=$arAnswer["MESSAGE"]?>:&nbsp;</span>
									<? } ?>
									<?=$arGroupAnswer["MESSAGE"]?>


								<div class="vote-answer-bar" style="width:<?=$percent?>%;background-color:#<?=$arAnswer["COLOR"]?>"></div>
								<span class="vote-answer-counter"><nobr><?=($arGroupAnswer["COUNTER"] > 0?'&nbsp;':'')?><?=$arGroupAnswer["COUNTER"]?> (<?=$arGroupAnswer["PERCENT"]?>%)</nobr></span></td>

						<?endforeach?>
						<div style='width:80%; height:1px; background-color:#<?=$arAnswer["COLOR"]?>;'></div>
					<? else: ?>

					<? endif; // USER_ANSWERS*/ ?>
				</div>
			<?endforeach?>
			</div>
		<?endif;?>
	</div>
<?endforeach;?>
</div>