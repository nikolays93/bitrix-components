<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
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
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>

<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
<?=bitrix_sessid_post()?>

	<?if(empty($arParams['DEFAULT_FIELDS']) || in_array('NAME', $arParams['DEFAULT_FIELDS'])):?>
	<div class="mf-name">
		<div class="mf-text">
			<?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<p><input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>" class="form-control"></p>
	</div>
	<?else:?>
		<input type="hidden" name="user_name" value="<?=GetMessage("MFT_EMPTY")?>">
	<?endif;?>

	<?if(empty($arParams['DEFAULT_FIELDS']) || in_array('EMAIL', $arParams['DEFAULT_FIELDS'])):?>
	<div class="mf-email">
		<div class="mf-text">
			<?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<p><input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" class="form-control"></p>
	</div>
	<?else:?>
		<input type="hidden" name="user_email" value="<?=GetMessage("MFT_EMPTY")?>">
	<?endif;?>

	<?php
	/** Custom: Start  */
	if(isset($arParams["USER_FIELDS"]) && is_array($arParams["USER_FIELDS"])) {
		foreach ($arParams["USER_FIELDS"] as $strField) {
			if( ! $strField ) continue;

			$required = false;
			if( 0 === strpos($strField, "*") ){
				$strField = mb_substr($strField, 1);
				$required = true;
			}

			$arField = explode(':', trim( $strField ));
			if( 0 === strpos($strField, "checkbox") ) continue;
			?>
			<div class="mf-<?=$arField[0];?>">
				<div class="mf-text">
					<?=$arField[1];?><?if($required):?><span class="mf-req">*</span><?endif?>
				</div>
				<p><input type="text" name="<?=$arField[0];?>" value="<?=$arResult["USER_FIELDS"][ $arField[0] ];?>" placeholder="<?//=$arField[0];?>" class="form-control"></p>
			</div>
			<?php
		}
	}
	/** Custom: End  */
	?>

	<?if(empty($arParams['DEFAULT_FIELDS']) || in_array('MESSAGE', $arParams['DEFAULT_FIELDS'])):?>
	<div class="mf-message">
		<div class="mf-text">
			<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<p><textarea name="MESSAGE" rows="5" cols="40" class="form-control"><?=$arResult["MESSAGE"]?></textarea></p>
	</div>
	<?else:?>
		<input type="hidden" name="MESSAGE" value="<?=GetMessage("MFT_EMPTY")?>">
		<input type="hidden" name="EMPTY_MESSAGE" value="1">
	<?endif;?>

	<?php
	/** Custom: Start */
	if( !empty($arParams['TEXT_ACCEPTANCE']) && is_array($arParams['TEXT_ACCEPTANCE']) ) {
		?><div class="acceptance"><?
		foreach ($arParams['TEXT_ACCEPTANCE'] as $i => $acceptance) {
			if(!$acceptance) continue;
			?>
			<p><input type="checkbox" name="acceptance<?=$i;?>" value="1" required="true"><span><?=htmlspecialcharsBack($acceptance);?></span></p>
			<?
		}
		?></div><?
	}
	/** Custom: End */
	?>
	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="mf-captcha">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
		<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="form-control">
	</div>
	<?endif;?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>" class="btn btn-primary">
</form>
</div>