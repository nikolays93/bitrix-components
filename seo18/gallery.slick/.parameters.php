<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockTypes = CIBlockParameters::GetIBlockTypes();
$arIBlocks = array();

$IBlockType = $arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : '';
$db_iblock = CIBlock::GetList(
	Array("SORT"=>"ASC"),
	Array(
		"SITE_ID" => $_REQUEST["site"],
		"TYPE" => $IBlockType,
		)
	);

while( $arRes = $db_iblock->Fetch() ) {
	$arIBlocks[ $arRes["ID"] ] = sprintf('[%s] %s',
		$arRes["ID"],
		$arRes["NAME"]
		);

    $arProperty_LNS = array();

    if( count($arCurrentValues["IBLOCKS"]) == 1 ) {
        $rsProp = CIBlockProperty::GetList(
            Array(
                "sort" => "asc",
                "name" => "asc",
                ),
            Array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => $arCurrentValues["IBLOCKS"][0],
                )
            );

        while ( $arr = $rsProp->Fetch() ) {
            $arProperty[ $arr["CODE"] ] = sprintf('[%s] %s',
                $arRes["CODE"],
                $arRes["NAME"]
                );

            if ( in_array( $arr["PROPERTY_TYPE"], array("L", "N", "S") ) ) {
                $arProperty_LNS[ $arr["CODE"] ] = sprintf('[%s] %s',
                    $arr["CODE"],
                    $arr["NAME"]
                    );
            }
        }
    }
}

$arSorts = Array(
	"ASC" => "По возрастанию",
	"DESC" => "По убыванию",
);

$arSortFields = Array(
        "ID"          => 'По ID',
        "NAME"        => 'По названию',
        "ACTIVE_FROM" => 'Дата начала активности',
        "SORT"        => "Сортировка",
        "TIMESTAMP_X" => "Дата последнего изменения",
	);

$arComponentParameters = array(
	"GROUPS" => array(
        "LIB" => array(
            "NAME" => "Параметры библиотеки",
            "SORT" => "350",
            )
	),
	"PARAMETERS" => array(
        "DISPLAY_NAME" => Array(
            "PARENT" => "VISUAL",
            "NAME" => "Показывать заголовок (если указан)",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
        "DISPLAY_DATE" => Array(
            "PARENT" => "VISUAL",
            "NAME" => "Показывать дату (если указана)",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "DISPLAY_PREVIEW_TEXT" => Array(
            "PARENT" => "VISUAL",
            "NAME" => "Показывать описание анонса (если указана)",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
		"IBLOCK_TYPE" => Array(
			"PARENT" => "BASE",
			"NAME" => "Тип информационных блоков",
			"TYPE" => "LIST",
			"VALUES" => $arIBlockTypes,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCKS" => Array(
			"PARENT" => "BASE",
			"NAME" => "Код информационного блока",
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"MULTIPLE" => "Y",
			"REFRESH" => "Y",
		),
		"NEWS_COUNT" => Array(
			"PARENT" => "BASE",
			"NAME" => "Макс. количество слайдов",
			"TYPE" => "STRING",
			"DEFAULT" => "15",
		),
		"IBLOCK_SORT_BY" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Поле для сортировки слайдов",
			"TYPE" => "LIST",
			"VALUES" => Array(
                "SORT" => "Сортировка",
                "NAME" => "Имя",
                "ID"   => "ID",
			),
			"DEFAULT" => "SORT",
		),
		"IBLOCK_SORT_ORDER" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Направление для сортировки информационных блоков",
			"TYPE" => "LIST",
			"DEFAULT" => "ASC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_BY1" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Поле для первой сортировки слайдов",
			"TYPE" => "LIST",
			"DEFAULT" => "ACTIVE_FROM",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_ORDER1" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Направление для первой сортировки слайдов",
			"TYPE" => "LIST",
			"DEFAULT" => "DESC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_BY2" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Поле для второй сортировки слайдов",
			"TYPE" => "LIST",
			"DEFAULT" => "SORT",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_ORDER2" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Направление для второй сортировки слайдов",
			"TYPE" => "LIST",
			"DEFAULT" => "ASC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"FIELD_CODE" => CIBlockParameters::GetFieldCode("Поля", "DATA_SOURCE"),
		"PROPERTY_CODE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Свойства",
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arProperty_LNS,
			"ADDITIONAL_VALUES" => "Y",
		),
        "USE_LINKS" => array(
            "PARENT" => "URL_TEMPLATES",
            "NAME" => "Установить ссылки",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
		// "IBLOCK_URL" => CIBlockParameters::GetPathTemplateParam(
		// 	"LIST",
		// 	"IBLOCK_URL",
		// 	"УРЛ",
		// 	"",
		// 	"URL_TEMPLATES"
		// ),
		"DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
			"DETAIL",
			"DETAIL_URL",
			"Детальный УРЛ",
			"",
			"URL_TEMPLATES"
		),
		"ACTIVE_DATE_FORMAT" => CIBlockParameters::GetDateFormat("Формат показа даты", "ADDITIONAL_SETTINGS"),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => "Учитывать права доступа",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
          ),

        // "SLICK_infinite" => array(
        //     "PARENT" => "LIB",
        //     "NAME" => "Infinite",
        //     "TYPE" => "CHECKBOX",
        //     "DEFAULT" => "Y",
        //     "DESCRIPTION" => 'Infinite looping',
        //     ),
        // "SLICK_slidesToShow" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Slides To Show',
        //     'DESC'    => 'slides to show at a time',
        //     "DEFAULT" => "1",
        //     "TYPE" => "NUMBER",
        //     ),
        // "SLICK_slidesToScroll" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Slides To Scroll',
        //     'DESC'    => 'slides to scroll at a time',
        //     "DEFAULT" => "1",
        //     'TYPE'    => 'NUMBER'
        //     ),
        // "SLICK_autoplay" => array(
        //     "PARENT" => "LIB",
        //     "NAME" => 'Auto Play',
        //     'DESC'  => 'Enables auto play of slides',
        //     'TYPE'  => 'CHECKBOX',
        //     ),
        // "SLICK_autoplaySpeed" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Auto Play Speed',
        //     'DESC'    => 'Auto play change interval',
        //     'DEFAULT' => '3000',
        //     "TYPE" => "NUMBER",
        //     ),
        // "SLICK_dots" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Dots',
        //     'DESC'    => 'Current slide indicator dots',
        //     "TYPE" => "CHECKBOX",
        //     // 'data-show' => 'dotsClass'
        //     ),
        // "SLICK_dotsClass" => array(
        //     "PARENT" => "LIB",
        //    "NAME"   => 'Dots Class',
        //    'DESC'    => 'Class for slide indicator dots container',
        //    'DEFAULT' => 'slick-dots',
        //    "TYPE" => "text",
        //    ),
        // "SLICK_arrows" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Arrows',
        //     'DESC'    => 'Enable Next/Prev arrows',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     // 'data-show' => 'prevArrow, nextArrow'
        //     ),
        // "SLICK_prevArrow" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Prev Arrow',
        //     'DESC'    => '(html | jQuery selector) | object (DOM node | jQuery object)   Allows you to select a node or customize the HTML for the "Previous" arrow. (May use %object%)',
        //     'DEFAULT' => '<button type="button" class="slick-prev">Previous</button>',
        //     "TYPE" => "text",
        //     ),
        // "SLICK_nextArrow" => array(
        //     "PARENT" => "LIB",
        //    "NAME"   => 'Next Arrow',
        //    'DESC'    => '(html | jQuery selector) | object (DOM node | jQuery object) Allows you to select a node or customize the HTML for the "Next" arrow. (May use %object%)',
        //    'DEFAULT' => '<button type="button" class="slick-next">Next</button>',
        //    "TYPE" => "text",
        //    ),
        // "SLICK_speed" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Speed',
        //     'DESC'    => 'Transition speed',
        //     'DEFAULT' => '300',
        //     "TYPE" => "NUMBER",
        //     ),
        // "SLICK_centerMode" => array(
        //     "PARENT" => "LIB",
        //     "NAME" => 'Center Mode',
        //     'DESC'  => 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.',
        //     "TYPE" => "CHECKBOX",
        //     // 'data-show' => 'centerPadding',
        //     ),
        // "SLICK_centerPadding" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Center Padding',
        //     'DESC'    => 'Side padding when in center mode. (px or %)',
        //     'DEFAULT' => '50px',
        //     "TYPE" => "text",
        //     ),
        // "SLICK_fade" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Fade',
        //     'DESC'    => 'Enables fade',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_variableWidth" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Variable Width',
        //     'DESC'    => 'Disables automatic slide width calculation',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_adaptiveHeight" => array(
        //     "PARENT" => "LIB",
        //     "NAME" => 'AdaptiveHeight',
        //     'DESC'  => 'Adapts slider height to the current slide',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_cssEase" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'CSS Ease',
        //     'DESC'    => 'CSS3 easing',
        //     'DEFAULT' => 'ease',
        //     "TYPE" => "text",
        //     ),
        // "SLICK_accessibility" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Accessibility',
        //     'DESC'    => 'Enables tabbing and arrow key navigation',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_draggable" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Draggable',
        //     'DESC'    => 'Enables desktop dragging',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_easing" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Easing',
        //     'DESC'    => 'animate() fallback easing',
        //     'DEFAULT' => 'linear',
        //     "TYPE" => "text",
        //     ),
        // "SLICK_edgeFriction" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Edge Friction',
        //     'DESC'    => 'Resistance when swiping edges of non-infinite carousels',
        //     'DEFAULT' => '0.15',
        //     "TYPE" => "NUMBER",
        //     ),
        // "SLICK_mobileFirst" => array(
        //     "PARENT" => "LIB",
        //    "NAME"   => 'Mobile First',
        //    'DESC'    => 'Responsive settings use mobile first calculation',
        //    "TYPE" => "CHECKBOX",
        //    ),
        // "SLICK_initialSlide" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Initial Slide',
        //     'DESC'    => 'Slide to start on',
        //     'DEFAULT' => '0',
        //     "TYPE" => "NUMBER",
        //     ),
        // "SLICK_lazyLoad" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Lazy Load',
        //     'DESC'    => 'Accepts \'ondemand\' or \'progressive\' for lazy load technique. \'ondemand\' will load the image as soon as you slide to it, \'progressive\' loads one image after the other when the page loads.',
        //     'DEFAULT' => 'ondemand',
        //     "TYPE" => "text",
        //     ),
        // "SLICK_pauseOnFocus" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Pause On Focus',
        //     'DESC'    => 'Pauses autoplay when slider is focussed',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_pauseOnHover" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Pause On Hover',
        //     'DESC'    => 'Pauses autoplay on hover',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_pauseOnDotsHover" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Pause On Dots Hover',
        //     'DESC'    => 'Pauses autoplay when a dot is hovered',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_respondTo" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Respond To',
        //     'DESC'    => 'Width that responsive object responds to. Can be \'window\', \'slider\' or \'min\' (the smaller of the two).
        //     responsive  array   null    Array of objects containing breakpoints and settings objects (see example). Enables settings at given breakpoint. Set settings to "unslick" instead of an object to disable slick at a given breakpoint.',
        //     'DEFAULT' => 'window',
        //     "TYPE" => "text",
        //     ),
        // "SLICK_rows" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Rows',
        //     'DESC'    => 'Setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.',
        //     "DEFAULT" => "1",
        //     "TYPE" => "NUMBER",
        //     ),
        // "SLICK_slide" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Slide',
        //     'DESC'    => 'Slide element query',
        //     'DEFAULT' => '',
        //     "TYPE" => "text",
        //     ),
        // "SLICK_slidesPerRow" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Slides Per Row',
        //     'DESC'    => 'With grid mode initialized via the rows option, this sets how many slides are in each grid row.',
        //     "DEFAULT" => "1",
        //     "TYPE" => "NUMBER",
        //     ),
        // "SLICK_swipe" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Swipe',
        //     'DESC'    => 'Enables touch swipe',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_swipeToSlide" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Swipe To Slide',
        //     'DESC'    => 'Swipe to slide irrespective of slidesToScroll',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_touchMove" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Touch Move',
        //     'DESC'    => 'Enables slide moving with touch',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_touchThreshold" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Touch Threshold',
        //     'DESC'    => 'To advance slides, the user must swipe a length of (1/touchThreshold) * the width of the slider.',
        //     'DEFAULT' => '5',
        //     "TYPE" => "NUMBER",
        //     ),
        // "SLICK_useCSS" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Use CSS',
        //     'DESC'    => 'Enable/Disable CSS Transitions',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_useTransform" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Use Transform',
        //     'DESC'    => 'Enable/Disable CSS Transforms',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_vertical" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Vertical',
        //     'DESC'    => 'Vertical slide direction',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_verticalSwiping" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Vertical Swiping',
        //     'DESC'    => 'Changes swipe direction to vertical',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_rtl" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Right To Left',
        //     'DESC'    => 'Change the slider\'s direction to become right-to-left',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_waitForAnimate" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'Wait For Animate',
        //     'DESC'    => 'Ignores requests to advance the slide while animating',
        //     'DEFAULT' => 'Y',
        //     "TYPE" => "CHECKBOX",
        //     ),
        // "SLICK_zIndex" => array(
        //     "PARENT" => "LIB",
        //     "NAME"   => 'zIndex',
        //     'DESC'    => 'Set the zIndex values for slides, useful for IE9 and lower',
        //     'DEFAULT' => '1000',
        //     "TYPE" => "NUMBER",
        //     ),
        // ),
);
