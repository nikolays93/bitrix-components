<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
        // 'CACHE_TIME' => array('DEFAULT' => 120),
        "POSITION" => array(
            "PARENT" => "BASE",
            "NAME" => "Расположение текста",
            "TYPE" => "LIST",
            // "REFRESH" => "перегружать настройки или нет после выбора (N/Y)",
            // "MULTIPLE" => "одиночное/множественное значение (N/Y)",
            "VALUES" => array(
                'LEFT' => 'Слева',
                'RIGHT' => 'Справа',
            ),
            // "ADDITIONAL_VALUES" => "показывать поле для значений, вводимых вручную (Y/N)",
            // "SIZE" => "число строк для списка (если нужен не выпадающий список)",
            // "DEFAULT" => "значение по умолчанию",
            // "COLS" => "ширина поля в символах",
        ),
	),
);
