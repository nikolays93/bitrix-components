<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var $arrSlickProps array params for lib */
$this->setFrameMode(true);

$this->addExternalCss($componentPath . "/assets/slick/slick.css");
$this->addExternalJS ($componentPath . "/assets/slick/slick.min.js");
// $this->addExternalJS ($componentPath . "/assets/slick/initialize.js");
$first_iblock = current($arResult['IBLOCKS']);
?>
<style type="text/css">
	#slick-<?=$first_iblock['ID'];?> {
		margin-bottom: 2px;
	}
	#slick-<?=$first_iblock['ID'];?> .thumbnail {
		position: relative;
		overflow: hidden;
		width: 100%;
		height: 450px;
	}
	#slick-<?=$first_iblock['ID'];?> .thumbnail img {
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
	}
	#slick-<?=$first_iblock['ID'];?>-nav .thumbnail {
		position: relative;
		overflow: hidden;
		height: 170px;
	}
	#slick-<?=$first_iblock['ID'];?>-nav .thumbnail img {
		width: 99%;
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
	}
</style>
<div class="slick-slider" id="slick-<?=$first_iblock['ID'];?>">
	<?foreach ($arResult['IBLOCKS'] as $iblock):
	foreach($iblock["ITEMS"] as $arItem):
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
			CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="thumbnail">
				<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])) {
					printf('
						<a href="%1$s" class="zoom" data-fancybox="%6$s">
							<img src="%1$s" width="%2$s" height="%3$s" alt="%4$s" title="%5$s" />
						</a>',
						$arItem["DETAIL_PICTURE"]["SRC"],
						$arItem["DETAIL_PICTURE"]["WIDTH"],
						$arItem["DETAIL_PICTURE"]["HEIGHT"],
						$arItem["DETAIL_PICTURE"]["ALT"],
						$arItem["DETAIL_PICTURE"]["TITLE"],
						$first_iblock['ID']);
				}?>
			</div>

			<div class="description">
				<?php
				if("Y" === $arParams["DISPLAY_NAME"] && $arItem["NAME"])
					printf('<div class="item-title">%s</div>', $arItem["NAME"]);

				if("Y" === $arParams["DISPLAY_DATE"] && $arItem["DISPLAY_ACTIVE_FROM"])
					printf('<small class="date-time">%s</small>', $arItem["DISPLAY_ACTIVE_FROM"]);

				if("Y" === $arParams["DISPLAY_DETAIL_TEXT"] && $arItem["DETAIL_TEXT"])
					printf('<div class="item-title">%s</div>', $arItem["DETAIL_TEXT"]);
				?>
			</div>
		</div>
	<?endforeach;endforeach;?>
</div><!-- .slick-list -->

<div class="slick-slider" id="slick-<?=$first_iblock['ID'];?>-nav">
	<?foreach ($arResult['IBLOCKS'] as $iblock):
	foreach($iblock["ITEMS"] as $arItem):?>
		<div class="item">
			<div class="thumbnail">
				<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])) {
					printf('<img src="%s" width="%s" height="%s" alt="%s" title="%s" />',
						$arItem["PREVIEW_PICTURE"]["SRC"],
						$arItem["PREVIEW_PICTURE"]["WIDTH"],
						$arItem["PREVIEW_PICTURE"]["HEIGHT"],
						$arItem["PREVIEW_PICTURE"]["ALT"],
						$arItem["PREVIEW_PICTURE"]["TITLE"]);
				}?>
			</div>
		</div>
	<?endforeach;endforeach;?>
</div><!-- .slick-list -->

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var first = '#slick-<?=$first_iblock['ID'];?>';
		var second = '#slick-<?=$first_iblock['ID'];?>-nav';

		$( first ).slick({
			asNavFor: second,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true
		});

		$( second ).slick({
			asNavFor: first,
			centerMode: true,
			focusOnSelect: true,
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: false,
			dots: false
		});
	});
</script>
