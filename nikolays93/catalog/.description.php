<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IBLOCK_CATALOG_NAME"),
	"DESCRIPTION" => GetMessage("IBLOCK_CATALOG_DESCRIPTION"),
	"ICON" => "/images/icon.gif",
	"COMPLEX" => "Y",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "Seo18.ru",
		"CHILD" => array(
			"ID" => "nikolays93:catalog",
			"NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
			"SORT" => 30,
		)
	)
);
