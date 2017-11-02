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
$this->setFrameMode(true);
?>
<section class="list list-id-<?=$arParams['IBLOCK_ID'];?> list-<?=$arParams['IBLOCK_TYPE'];?>">
	<?php
	if( $arParams["DISPLAY_TOP_PAGER"] ) {
		echo "<div class='pager top-pager'>{$arResult["NAV_STRING"]}</div>";
	}

	foreach($arResult["ITEMS"] as $arItem) {
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
			CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
			CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array(
				"CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')
				) );

		$link = $arParams["HIDE_LINK_WHEN_NO_DETAIL"] ||
			($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]) ? $arItem["DETAIL_PAGE_URL"] : false;
		?>
		<article class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?php
			display_picture($arParams["DISPLAY_PICTURE"], $arItem["PREVIEW_PICTURE"], $link, array(
				'class' => 'preview_picture',
				) );
			display_name($arParams["DISPLAY_NAME"], $arItem["NAME"], $link, $title_tag = 'h3');
			display_date($arParams["DISPLAY_DATE"], $arItem["DISPLAY_ACTIVE_FROM"]);
			display_description($arParams["DISPLAY_PREVIEW_TEXT"], $arItem["PREVIEW_TEXT"]);

			echo "<div class='clear'></div>";
			foreach($arItem["FIELDS"] as $code => $value) {
				echo "<small>";
				echo GetMessage("IBLOCK_FIELD_" . $code) . ":&nbsp;" . $value;
				echo "</small><br />";
			}

			foreach($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty) {
				echo "<small>";
				echo "{$arProperty["NAME"]}:&nbsp;";
				if( is_array($arProperty["DISPLAY_VALUE"]) ) {
					echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
				}
				else {
					echo $arProperty["DISPLAY_VALUE"];
				}
				echo "</small><br />";
			}
		?>
		</article>
		<?php
	}

	if( $arParams["DISPLAY_BOTTOM_PAGER"] ) {
		echo "<div class='pager pager-bottom'>{$arResult["NAV_STRING"]}</div>";
	}
?>
</section>
