<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_redirectsearch_search=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_redirectsearch_redirect=1
');

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_redirectsearch_pi1.php', '_pi1', 'list_type', 1);

// eID
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['redirectsearch'] = 'EXT:redirect_search/class.tx_redirectsearch_eID.php';
?>