<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if( function_exists('get_default_catalog_args') ) {
    get_default_catalog_args(null, $arParams);
    // or $arParams = array_merge($arParams, get_default_catalog_args());
}

$this->IncludeComponentTemplate();
