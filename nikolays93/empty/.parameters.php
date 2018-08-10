<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @global $arCurrentValues
 */

$arComponentParameters = array(
	"GROUPS" => array(
        // BASE
        // DATA_SOURCE
        // VISUAL
        // USER_CONSENT
        // URL_TEMPLATES
        // SEF_MODE
        // AJAX_SETTINGS
        // CACHE_SETTINGS
        // ADDITIONAL_SETTINGS
	),
	"PARAMETERS" => array(
        // 'CACHE_TIME' => array('DEFAULT' => 120),
        "POSITION" => array(
            "PARENT" => "BASE",
            "NAME" => "Расположение текста",
            // LIST, STRING, CHECKBOX, CUSTOM, FILE, COLORPICKER
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
