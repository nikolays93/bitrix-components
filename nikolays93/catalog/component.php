<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

get_default_catalog_args(null, $arParams);
// or $arParams = array_merge($arParams, get_default_catalog_args());

// 'BASKET_URL' => PATH_TO_BASKET,
// 'FILTER_NAME' => 'arrCatalogFilter',

// 'ADD_PROPERTIES_TO_BASKET' => 'Y',

// 'ADD_TO_BASKET_ACTION' => 'ADD',
// 'BACKGROUND_IMAGE' => '-',
// 'BROWSER_TITLE' => '-',
// 'COMPATIBLE_MODE' => 'Y',
// 'COMPONENT_TEMPLATE' => 'books',
// 'CUSTOM_FILTER' => '',
// 'DETAIL_URL' => '',
// 'DISABLE_INIT_JS_IN_COMPONENT' => 'N',
// 'DISPLAY_BOTTOM_PAGER' => 'N',
// 'DISPLAY_TOP_PAGER' => 'N',
// 'ELEMENT_SORT_FIELD' => 'sort',
// 'ELEMENT_SORT_FIELD2' => 'id',
// 'ELEMENT_SORT_ORDER' => 'asc',
// 'ELEMENT_SORT_ORDER2' => 'desc',
// 'ENLARGE_PRODUCT' => 'STRICT',


// 'INCLUDE_SUBSECTIONS' => 'Y',
// 'LAZY_LOAD' => 'N',
// 'LINE_ELEMENT_COUNT' => '3',
// 'LOAD_ON_SCROLL' => 'N',
// 'MESSAGE_404' => '',

// 'META_DESCRIPTION' => '-',
// 'META_KEYWORDS' => '-',
// 'OFFERS_LIMIT' => '5',
// 'PAGER_BASE_LINK_ENABLE' => 'N',
// 'PAGER_DESC_NUMBERING' => 'N',
// 'PAGER_DESC_NUMBERING_CACHE_TIME' => '36000',
// 'PAGER_SHOW_ALL' => 'N',
// 'PAGER_SHOW_ALWAYS' => 'N',
// 'PAGER_TEMPLATE' => '.default',
// 'PAGER_TITLE' => 'Товары',
// 'PAGE_ELEMENT_COUNT' => '9',
// 'PARTIAL_PRODUCT_PROPERTIES' => 'N',
// 'PRODUCT_BLOCKS_ORDER' => 'price,props,sku,quantityLimit,quantity,buttons,compare',

// 'PRODUCT_PROPERTIES' => array(
// ),
// 'PRODUCT_PROPS_VARIABLE' => 'prop',
// 'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
// 'PRODUCT_ROW_VARIANTS' => '[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]',
// 
// 'PROPERTY_CODE' => array(
//     0 => 'AUTHOR',
//     1 => '',
// ),
// 'PROPERTY_CODE_MOBILE' => array(
//     0 => 'AUTHOR',
// ),
// 'RCM_PROD_ID' => $_REQUEST['PRODUCT_ID'],
// 'RCM_TYPE' => 'personal',
// 'SECTION_CODE' => '',
// 'SECTION_ID' => $_REQUEST['SECTION_ID'],
// 'SECTION_ID_VARIABLE' => 'SECTION_ID',
// 'SECTION_URL' => '',
// 'SECTION_USER_FIELDS' => array(
//     0 => '',
//     1 => '',
// ),



// 'SET_META_DESCRIPTION' => 'Y',
// 'SET_META_KEYWORDS' => 'Y',
// 'SET_STATUS_404' => 'N',

// 'SHOW_404' => 'N',
// 'SHOW_ALL_WO_SECTION' => 'Y',
// 'SHOW_CLOSE_POPUP' => 'N',
// 
// 'SHOW_FROM_SECTION' => 'N',

// 'SHOW_SLIDER' => 'Y',
// 'SLIDER_INTERVAL' => '3000',
// 'SLIDER_PROGRESS' => 'N',

// 'USE_ENHANCED_ECOMMERCE' => 'N',

// 'USE_PRODUCT_QUANTITY' => 'N'

$arParams['SECTION_TOP_DEPTH'] = 1;

$this->IncludeComponentTemplate();
