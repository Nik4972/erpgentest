<?php

namespace backend;

class ErpEnums {
    public static $RecordStatuses = [1=>'Actual', 'Archived', 'Deleted'];
    public static $YesNo = ['Yes', 'No'];
    public static $AddressTypes = ['Registry', 'Logistic', 'Other'];
    public static $SubjectTypes = ['Company', 'Person', 'Businessman'];
    public static $OfficialNumberTypes = ['Registry', 'Taxing'];
    public static $NamePrefixes = ['Ing.', 'Mudr.', 'Mgr.', 'Doc.', 'Phd.', 'Bc.'];
    public static $Genders = ['', '', '', '', ''];
    public static $ContactTypes = ['url', 'e-mail', 'phone', 'chat', 'fax'];
    public static $BankCardTypes = ['Debit', 'Credit', 'Universal'];
    public static $DocumentsRequired = ['', '', '', '', ''];
    public static $DocumentsPresence = ['', '', '', '', ''];
    public static $Storages = ['', '', '', '', ''];
    public static $Ambries = ['', '', '', '', ''];
    public static $MeasureUnitTypes = ['Weight', 'Volume', 'Quantity', 'Time'];
    public static $MeasureUnits = ['', '', '', '', ''];
    public static $MaterialProductTypes = ['', '', '', '', ''];
    public static $ImmaterialProductTypes = ['', '', '', '', ''];
}