<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_redirectsearch_search'] = array (
	'ctrl' => $TCA['tx_redirectsearch_search']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,hotkey,url'
	),
	'feInterface' => $TCA['tx_redirectsearch_search']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'hotkey' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search.hotkey',		
			'config' => array (
				'type' => 'input',	
				'size' => '5',	
				'eval' => 'required',
			)
		),
		'url' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search.url',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'unique',
			)
		),
		'marker' => array (        
            'exclude' => 0,        
            'label' => 'LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search.marker',        
            'config' => array (
                'type' => 'check',
            )
        ),
		'usetsmarker' => array (        
            'exclude' => 0,        
            'label' => 'LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search.usetsmarker',        
            'config' => array (
                'type' => 'check',
            )
        ),
        'tsmarker' => array (        
            'exclude' => 0,        
            'label' => 'LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search.tsmarker',        
            'config' => array (
                'type' => 'text',
                'cols' => '30',    
                'rows' => '5',
            )
        ),
		'useadvanced' => array (        
            'exclude' => 0,        
            'label' => 'LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search.useadvanced',        
            'config' => array (
                'type' => 'check',
            )
        ),
		 'advanced' => array (        
            'exclude' => 1,        
            'label' => 'LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search.advanced',        
            'config' => array (
                'type' => 'select',
                'items' => array (
                    array('LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search.advanced.I.0', '0'),
                ),
                'itemsProcFunc' => 'tx_redirectsearch_field_advanced->main',    
                'size' => 1,    
                'maxitems' => 1,
            )
        ),
 	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, hotkey, url, marker, usetsmarker, tsmarker, useadvanced, advanced')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);

?>