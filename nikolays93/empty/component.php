<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// $sections = Conditions::get_dir_sections();
// if( CModule::IncludeModule('iblock') ) {
//     $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM",
//         "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");

//     $arFilter = Array(
//         "IBLOCK_TYPE" => 'content',
//         "IBLOCK_ID" => IBLOCK_ID__ARTICLES,
//         "ACTIVE_DATE" => "Y",
//         "ACTIVE" => "Y"
//     );

//     if( !empty($sections[2]) ) {
//         $arFilter['CODE'] = $sections[2];

//         $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
//         while($ob = $res->GetNextElement()) {
//             // $arFields = $ob->GetFields();
//             $arProperties = $ob->GetProperties();

//             if( $post_id = $arProperties[ $arParams['POSITION'] ]['VALUE'] ) {
//                 $arFilter["ID"] = $post_id;
//             }
//         }

//         unset( $arFilter['CODE'] );
//     }
//     $arFilter["ID"] = !empty($arFilter["ID"]) ? $arFilter["ID"] : intval($arParams['POST']);

//     $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
//     while($ob = $res->GetNextElement()) {
//         $arFields = $ob->GetFields();
//         $arResult['POST'] = $arFields;
//         $arResult['POST']['PICTURE'] = CFile::GetFileArray($arFields['PREVIEW_PICTURE']);
//     }
// }

$this->IncludeComponentTemplate();
