<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "FEEDBACK_FORM", "ACTIVE" => "Y");
if($site !== false)
	$arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arComponentParameters = array(
	"PARAMETERS" => array(
		"FIELDS" => Array(
			"NAME" => 'Поля',
			"TYPE"=>"LIST",
			"MULTIPLE"=>"Y",
			"VALUES" => Array("NAME" => GetMessage("MFP_NAME"), "EMAIL" => "E-mail", "MESSAGE" => GetMessage("MFP_MESSAGE")),
			"DEFAULT"=>"",
			"COLS"=>25,
			"PARENT" => "BASE",
		),
		"REQUIRED_FIELDS" => Array(
			"NAME" => GetMessage("MFP_REQUIRED_FIELDS"),
			"TYPE"=>"LIST",
			"MULTIPLE"=>"Y",
			"VALUES" => Array("NAME" => GetMessage("MFP_NAME"), "EMAIL" => "E-mail", "MESSAGE" => GetMessage("MFP_MESSAGE")),
			"DEFAULT"=>"",
			"COLS"=>25,
			"PARENT" => "BASE",
		),
		"EXT_FIELDS" => array(
			'NAME' => "Доп. поля контактной формы",
			'TYPE' => 'CUSTOM',
			'JS_FILE' => '/local/components/seo18/main.feedback.advanced/assets/admin.js',
			'JS_EVENT' => 'FormFieldsList',
			'JS_DATA' => json_encode( array('types' => array(
				"text"     => "Строка",
				"checkbox" => "Выбор",
				"select"   => "Список",
				"textarea" => "Текстовое поле"
				)) ),
			'DEFAULT' => null,
			'PARENT' => 'BASE',
			),
		"USE_CAPTCHA" => Array(
			"NAME" => GetMessage("MFP_CAPTCHA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"OK_TEXT" => Array(
			"NAME" => GetMessage("MFP_OK_MESSAGE"), 
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MFP_OK_TEXT"), 
			"PARENT" => "BASE",
		),
		// "PRIVACY_TEXT" => Array(
		// 	"NAME" => 'Текст политики конфедициальности', 
		// 	"TYPE" => "STRING",
		// 	"DEFAULT" => '',
		// 	"PARENT" => "BASE",
		// 	"COLS"   => 5,
		// ),
		// "DATA_PROCESSING_TEXT" => Array(
		// 	"NAME" => 'Текст разрешения на обработку данных', 
		// 	"TYPE" => "STRING",
		// 	"DEFAULT" => '',
		// 	"PARENT" => "BASE",
		// 	"COLS"   => 5,
		// ),
		"EMAIL_TO" => Array(
			"NAME" => GetMessage("MFP_EMAIL_TO"), 
			"TYPE" => "STRING",
			"DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")), 
			"PARENT" => "BASE",
		),
		"EVENT_MESSAGE_ID" => Array(
			"NAME" => GetMessage("MFP_EMAIL_TEMPLATES"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"Y", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
		"AJAX_MODE" => Array(
			"NAME" => GetMessage("MFP_AJAX_MODE"),
			"TYPE"=>"CHECKBOX",
			"DEFAULT"=>"Y",
			"PARENT" => "BASE",
		),
	)
);
