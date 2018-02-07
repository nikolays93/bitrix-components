<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader,
	Bitrix\Main,
	Bitrix\Iblock;

if( ! function_exists('sanitize_iblock_params') ) {
    function sanitize_iblock_params( $arParams ) {
        if( ! is_array($arParams["IBLOCKS"]) ) $arParams["IBLOCKS"] = array($arParams["IBLOCKS"]);
        foreach($arParams["IBLOCKS"] as $key => $val) if( ! $val ) unset( $arParams["IBLOCKS"][ $key ] );

        $arParams["IBLOCK_SORT_BY"] = trim($arParams["IBLOCK_SORT_BY"]);
        if( ! in_array($arParams["IBLOCK_SORT_BY"], array("SORT","NAME","ID")) ) {
            $arParams["SORT_BY1"] = "SORT";
        }
        $arParams["IBLOCK_SORT_ORDER"] = strtoupper( $arParams["IBLOCK_SORT_ORDER"] );

        if( $arParams["IBLOCK_SORT_ORDER"] != "DESC" ) {
            $arParams["IBLOCK_SORT_ORDER"] = "ASC";
        }

        return $arParams;
    }
}

if( ! function_exists('sanitize_sort_params') ) {
    function sanitize_sort_params( $arParams ) {
        $arParams["SORT_BY1"] = trim( $arParams["SORT_BY1"] );

        if( strlen($arParams["SORT_BY1"]) <= 0 ) $arParams["SORT_BY1"] = "ACTIVE_FROM";
        if( ! preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"]) ) {
            $arParams["SORT_ORDER1"] = "DESC";
        }

        if( strlen($arParams["SORT_BY2"]) <= 0 ) $arParams["SORT_BY2"] = "SORT";
        if( ! preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER2"]) ) {
            $arParams["SORT_ORDER2"] = "ASC";
        }

        return $arParams;
    }
}

$arParams = array_map('trim', $arParams);
// $arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
// $arParams["IBLOCK_URL"] = trim( $arParams["IBLOCK_URL"] );
// $arParams["DETAIL_URL"] = trim( $arParams["DETAIL_URL"] );
// $arParams["ACTIVE_DATE_FORMAT"] = trim( $arParams["ACTIVE_DATE_FORMAT"] );

if( ! isset( $arParams["CACHE_TIME"] ) ) $arParams["CACHE_TIME"] = 36000000;
sanitize_iblock_params( $arParams );
sanitize_sort_params( $arParams );

if( ! is_array( $arParams["FIELD_CODE"] ) ) $arParams["FIELD_CODE"] = array();
foreach( $arParams["FIELD_CODE"] as $key => $val ) {
	if( "" === $val ) unset($arParams["FIELD_CODE"][ $key ]);
}

if( ! is_array($arParams["PROPERTY_CODE"]) ) $arParams["PROPERTY_CODE"] = array();
foreach($arParams["PROPERTY_CODE"] as $k => $v) {
	if( "" === $v ) unset($arParams["PROPERTY_CODE"][ $k ]);
}

$arParams["NEWS_COUNT"] = intval($arParams["NEWS_COUNT"]);
if( $arParams["NEWS_COUNT"] <= 0 ) {
	$arParams["NEWS_COUNT"] = 5;
}

if( strlen($arParams["ACTIVE_DATE_FORMAT"]) <= 0 ) {
	$arParams["ACTIVE_DATE_FORMAT"] = $DB->DateFormatToPHP( CSite::GetDateFormat("SHORT") );
}

$arResult["IBLOCKS"] = array();

$groups = $arParams["CACHE_GROUPS"]==="N" ? false : $USER->GetGroups();
if( $this->startResultCache(false, $groups) ) {
	if( ! Loader::includeModule("iblock") ) {
		$this->abortResultCache();
		ShowError( "Модуль информационных блоков не установлен" );
		return;
	}

	//SELECT
	$arSelect = array_merge( $arParams["FIELD_CODE"], array(
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "NAME",
        "ACTIVE_FROM",
        "TIMESTAMP_X",
        // "DETAIL_PAGE_URL",
        "PREVIEW_TEXT",
        "PREVIEW_PICTURE",
        "DETAIL_TEXT",
        "DETAIL_PICTURE",
	) );

	if( $bGetProperty = count($arParams["PROPERTY_CODE"]) > 0 ) {
		$arSelect[] = "PROPERTY_*";
	}

	//WHERE
	$arrFilter["IBLOCK_TYPE"] = $arParams["IBLOCK_TYPE"];
	$arrFilter["ACTIVE"] = "Y";
	$arrFilter["ACTIVE_DATE"] = "Y";
	$arrFilter["CHECK_PERMISSIONS"] = "Y";

	//ORDER BY
	$arOrder = array(
		$arParams["SORT_BY1"] => $arParams["SORT_ORDER1"],
		$arParams["SORT_BY2"] => $arParams["SORT_ORDER2"],
	);

	if( ! array_key_exists("ID", $arOrder) ) {
		$arOrder["ID"] = "DESC";
	}

	$arIBlockOrder = array(
		$arParams["IBLOCK_SORT_BY"] => $arParams["IBLOCK_SORT_ORDER"],
	);

	if( ! array_key_exists("ID", $arIBlockOrder) ) {
		$arIBlockOrder["ID"] = "DESC";
	}

	$rsIBlocks = CIBlock::GetList( $arIBlockOrder, array(
		"LID" => SITE_ID,
		"ACTIVE" => "Y",
		"ID" => $arParams["IBLOCKS"],
		) );

	while( $arIBlock = $rsIBlocks->GetNext() ) {
		$arButtons = CIBlock::GetPanelButtons( $arIBlock["ID"], 0, 0, array(
			"SECTION_BUTTONS" => false,
			"SESSID" => false
			) );

		$arIBlock["ADD_ELEMENT_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
		// $arIBlock["~LIST_PAGE_URL"] = str_replace(
		// 	array("#SERVER_NAME#", "#SITE_DIR#", "#IBLOCK_TYPE_ID#", "#IBLOCK_ID#", "#IBLOCK_CODE#", "#IBLOCK_EXTERNAL_ID#", "#CODE#"),
		// 	array(SITE_SERVER_NAME, SITE_DIR, $arIBlock["IBLOCK_TYPE_ID"], $arIBlock["ID"], $arIBlock["CODE"], $arIBlock["EXTERNAL_ID"], $arIBlock["CODE"]),
		// 	strlen($arParams["IBLOCK_URL"])? trim($arParams["~IBLOCK_URL"]): $arIBlock["~LIST_PAGE_URL"]
		// );
		// $arIBlock["~LIST_PAGE_URL"] = preg_replace("'/+'s", "/", $arIBlock["~LIST_PAGE_URL"]);
		// $arIBlock["LIST_PAGE_URL"] = htmlspecialcharsbx($arIBlock["~LIST_PAGE_URL"]);

		$arIBlock["ITEMS"] = array();
		$arrFilter["IBLOCK_ID"] = $arIBlock["ID"];
		$rsItem = CIBlockElement::GetList($arOrder, $arrFilter, false, array(
			"nTopCount" => $arParams["NEWS_COUNT"]
			), $arSelect );
		$rsItem->SetUrlTemplates( $arParams["DETAIL_URL"] );

		while( $obItem = $rsItem->GetNextElement() )
		{
			$arItem = $obItem->GetFields();

			$arButtons = CIBlock::GetPanelButtons(
				$arItem["IBLOCK_ID"],
				$arItem["ID"],
				0,
				array("SECTION_BUTTONS"=>false, "SESSID"=>false)
			);

			$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
			$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

			if( strlen($arItem["ACTIVE_FROM"]) > 0 ) {
				$arItem["DISPLAY_ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat(
					$arParams["ACTIVE_DATE_FORMAT"],
					MakeTimeStamp( $arItem["ACTIVE_FROM"], CSite::GetDateFormat() )
					);
			}
			else {
				$arItem["DISPLAY_ACTIVE_FROM"] = "";
			}

			$ipropValues = new Iblock\InheritedProperty\ElementValues($arItem["IBLOCK_ID"], $arItem["ID"]);
			$arItem["IPROPERTY_VALUES"] = $ipropValues->getValues();

			Iblock\Component\Tools::getFieldImageData(
				$arItem,
				array('PREVIEW_PICTURE'),
				Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
				'IPROPERTY_VALUES'
			);

            Iblock\Component\Tools::getFieldImageData(
                $arItem,
                array('DETAIL_PICTURE'),
                Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
                'IPROPERTY_VALUES'
            );

			$arItem["FIELDS"] = array();
			foreach($arParams["FIELD_CODE"] as $code) {
				if( array_key_exists($code, $arItem) ) {
					$arItem["FIELDS"][ $code ] = $arItem[ $code ];
				}
			}

			if( $bGetProperty ) {
				$arItem["PROPERTIES"] = $obItem->GetProperties();
			}


			$arItem["DISPLAY_PROPERTIES"] = array();
			foreach($arParams["PROPERTY_CODE"] as $pid)
			{
                $prop = &$arItem["PROPERTIES"][$pid];
				if( (is_array($prop["VALUE"]) && count($prop["VALUE"])>0)
					|| (!is_array($prop["VALUE"]) && strlen($prop["VALUE"])>0) ) {
					$arItem["DISPLAY_PROPERTIES"][$pid] = CIBlockFormatProperties::GetDisplayValue($arItem, $prop, "news_out");
				}
			}

			$arIBlock["ITEMS"][] = $arItem;
		}
		$arResult["IBLOCKS"][] = $arIBlock;
	}

    $arParams['SlickProps'] = array();
    foreach ($arParams as $param => $value) {
        if( 0 === strpos($param, 'SLICK_') ) {
            if( is_numeric($value) ) {
                $value = (float) $value;
            }
            else {
                switch ($value) {
                    case 'Y': $value = true; break;
                    case 'N': $value = false; break;
                    default: $value = htmlspecialchars_decode($value); break;
                }
            }

            $param = str_replace('SLICK_', '', $param);
            $arParams['SlickProps'][ $param ] = $value;
            unset($arParams[$param]);
        }
    }

	$this->setResultCacheKeys(array());
	$this->includeComponentTemplate();
}