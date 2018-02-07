<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="mfeedback">
	<?
	if(!empty($arResult["ERROR_MESSAGE"])) {
		foreach($arResult["ERROR_MESSAGE"] as $msg) ShowError($msg);
	}

	if(strlen($arResult["OK_MESSAGE"]) > 0) {
		echo sprintf('<div class="mf-ok-text">%s</div>', $arResult["OK_MESSAGE"]);
	}
	?>

	<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
		<?=bitrix_sessid_post()?>

		<?if(is_array($arParams['FIELDS']) && in_array('NAME', $arParams['FIELDS'])):?>
			<div class="mf-name">
				<div class="mf-text">
					<?=GetMessage("MFT_NAME")?><?if(in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
				</div>
				<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>" class="form-control">
			</div>
		<?endif;?>

		<?if(is_array($arParams['FIELDS']) && in_array('EMAIL', $arParams['FIELDS'])):?>
			<div class="mf-email">
				<div class="mf-text">
					<?=GetMessage("MFT_EMAIL")?><?if(in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
				</div>
				<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" class="form-control">
			</div>
		<?endif;?>

		<?foreach($arParams["NEW_EXT_FIELDS"] as $obField):?>
			<div class="mf-custom">
				<?php
				switch ($obField->type) {
					case 'select':
						break;

					case 'checkbox': ?>
						<label class="mf-<?=$obField->type;?>">
							<input
								type="<?=$obField->type;?>"
								name="CUSTOM[<?=$obField->num;?>]"
								value="<?=$arResult['custom_' . $obField->num];?>">
							<?php
								echo $obField->name;
								echo 'Y' === $obField->req ? '<span class="mf-req">*</span>' : '';
							?>
						</label>
					<?php break;

					case 'textarea': ?>
						<label class="mf-<?=$obField->type;?>">
							<?php
								echo $obField->name;
								echo 'Y' === $obField->req ? '<span class="mf-req">*</span>' : '';
							?><br>
							<textarea name="CUSTOM[<?=$obField->num;?>]" class="form-control">
								<?=$arResult['custom_' . $obField->num];?>
							</textarea>
						</label>
					<?php break;

					default: ?>
						<label class="mf-<?=$obField->type;?>">
							<?php
								echo $obField->name;
								echo 'Y' === $obField->req ? '<span class="mf-req">*</span>' : '';
							?><br>
							<input
								type="<?=$obField->type;?>"
								name="CUSTOM[<?=$obField->num;?>]"
								value="<?=$arResult['custom_' . $obField->num];?>"
								class="form-control">
						</label>
					<?php
					break;
				}
				?>
			</div>
		<?endforeach;?>

		<? if(is_array($arParams['FIELDS']) && in_array('MESSAGE', $arParams['FIELDS'])) : ?>
			<div class="mf-message">
				<div class="mf-text">
					<?=GetMessage("MFT_MESSAGE")?><?if(in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
				</div>
				<textarea name="MESSAGE" rows="5" cols="40" class="form-control"><?=$arResult["MESSAGE"]?></textarea>
			</div>
		<? endif ?>

		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
			<div class="mf-captcha">
				<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
				<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
				<input type="text" name="captcha_word" size="30" maxlength="50" value="">
			</div>
		<?endif;?>

		<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">

		<p class="clear"></p>
		<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>" class="btn btn-primary">
	</form>
</div>