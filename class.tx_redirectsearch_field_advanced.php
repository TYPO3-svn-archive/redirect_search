<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Sven Juergens <sj@nordsonne.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */


/**
 * Class/Function which manipulates the item-array for table/field tx_redirectsearch_search_advanced.
 *
 * @author    Sven Juergens <sj@nordsonne.de>
 * @package    TYPO3
 * @subpackage    tx_redirectsearch
 */
class tx_redirectsearch_field_advanced {

	function main(&$params,&$pObj){
	
		// Finding value for the path containing the template files
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['redirect_search']);

		$readPath = t3lib_div::getFileAbsFileName($extConf['user_Files']);

		// If that direcotry is valid, then select files in it:
		if (@is_dir($readPath)){
		
		    //getting all PHP files in the directory:
		    $user_files = t3lib_div::getFilesInDir ($readPath,'php',0,1);

		    // Traverse that array:
		    foreach ($user_files as $htmlFilePath) {
			
		        // Reset vars:
		        $selectorBoxItem_title='';
			
		        // Reading the content of the template document ...
		        $selectorBoxItem_title = trim('(' . $htmlFilePath . ')');

		        // Finally add the new item:
		        $params['items'][] = Array($selectorBoxItem_title, $htmlFilePath,'');
		    }
		}
		// No return - the $params and $pObj variables are passed by reference, so just change content in then and it is passed back automatically...
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/redirect_search/class.tx_redirectsearch_field_advanced.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/redirect_search/class.tx_redirectsearch_field_advanced.php']);
}

?>