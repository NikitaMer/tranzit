<?

CModule::AddAutoloadClasses(
    "wsm.import1c",
    array(
        "WsmImport1cIBlockHelper" 	 => 'classes/mysql/iblock_helper.php',
        "WsmImport1cIBlockElements"  => 'classes/mysql/iblock_elements.php',
        "WsmImport1cIBlockSections"  => 'classes/mysql/iblock_sections.php',
        "WsmImport1cCatalogPrice"  => 'classes/mysql/catalog_price.php',
        "WsmImport1cIBlockSearch"  => 'classes/general.php',

        #work with price rules table
        "Wsm\\Import1c\\Price" 				=> "lib/price/price.php",
        "Wsm\\Import1c\\Price\\RulesTable" 	=> "lib/price/price_rules.php",
		)
	); 
