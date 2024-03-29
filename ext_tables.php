<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::allowTableOnStandardPages('tx_redirectsearch_search');

if (TYPO3_MODE == 'BE')    {
    include_once(t3lib_extMgm::extPath('redirect_search').'class.tx_redirectsearch_field_advanced.php');
}

$TCA['tx_redirectsearch_search'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:redirect_search/locallang_db.xml:tx_redirectsearch_search',		
		'label'     => 'hotkey',
		'label_alt' => 'url',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',	
		'delete' => 'deleted',
		'requestUpdate' => 'useadvanced',
		'dividers2tabs' => 1,
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_redirectsearch_search.gif',
	),
);



t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($_EXTKEY .'_pi1', 'FILE:EXT:redirect_search/flexform_ds.xml');



t3lib_extMgm::addPlugin(array(
	'LLL:EXT:redirect_search/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_redirectsearch_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_redirectsearch_pi1_wizicon.php';
}
t3lib_extMgm::addStaticFile($_EXTKEY,'static/redirect_search/', 'Redirect Search');

?>