<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if( CModule::IncludeModule('iblock') ) {
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM",
        "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");

    $iblock_id = IBLOCK_ID__NEWS;
    $arOrder = Array("NAME" => "ASC");
    $arFilter = Array(
        "IBLOCK_ID" => $iblock_id,
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y"

        // array(
        //     "LOGIC" => "OR",
        //     array("PREVIEW_PICTURE" => '', "!PROPERTY_CODE_VALUE" => ''),
        //     array("DETAIL_PICTURE" => '', "!PROPERTY_CODE_2_VALUE" => ''),
        // ),
    );


    $arSelectedFields = array("ID", "IBLOCK_ID", 'property_CODE');

    $res = CIBlockElement::GetList(
        $arOrder,
        $arFilter,
        $arGroupBy = false,
        array('nTopCount' => '100'),
        $arSelectedFields
    );

    // $arResult['ELEMENTS'] = array();
    // /**
    //  * @var Object CIBlockElement
    //  */
    // while($ob = $res->GetNextElement())
    // {
    //     $arFields = $ob->GetFields();
    //     $arProps = $ob->GetProperties();

    //     $arResult['ELEMENTS'][ $arFields['ID'] ]['FIELDS'] = $arFields;
    //     $arResult['ELEMENTS'][ $arFields['ID'] ]['PROPS'] = $arProps;
    // }

    $arResult['ITEMS'] = array();

    /**
     * @var Array
     */
    while($arItem = $res->GetNext())
    {
        $arResult['ITEMS'][] = $arItem;
    }
}

$this->IncludeComponentTemplate();
