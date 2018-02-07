<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Slick Галерея",
	"DESCRIPTION" => "Показывает перелистывающиеся изображения",
	"ICON" => "/images/news_all.gif",
	"SORT" => 50,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "SEO18.RU",
		"CHILD" => array(
			"ID"   => "multimedia",
			"NAME" => 'Мультимедия',
			"SORT" => 10,
		)
	),
);
