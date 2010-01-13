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
 * Plugin 'Add a FF Searchbar' for the 'redirect_search' extension.
 *
 * @author	Sven Juergens <sj@nordsonne.de>
 * @package	TYPO3
 * @subpackage	tx_redirectsearch
 */

require_once(PATH_tslib . 'class.tslib_content.php');
require_once(PATH_t3lib . 'class.t3lib_tstemplate.php');

require_once(PATH_tslib . 'class.tslib_eidtools.php');
 
class tx_redirectsearch_eID {
	var $q;
	
	function init() {
	
		tslib_eidtools::connectDB();
		tslib_eidtools::initFeUser();
				
		$this->q = htmlspecialchars(t3lib_div::_GET('q'));
		$this->q = t3lib_div::trimExplode(' ',$this->q,1);
		
		if(strtolower($this->q[0]) == 'help') {
			$this->getHelp();
			exit;
		}

	}

	function main() {
	
			// get record
			$row = 	$this->getResult('tx_redirectsearch_search');
			
			// unset hotkey from array
			unset($this->q[0]);
			
			if(is_array($row) && !empty($row) && $row[0]['useadvanced'] == 0) {
				
				if($row['0']['marker']== 0 && $row['0']['usetsmarker']== 0){
					header('Location: ' .$row[0]['url'] . implode('+',$this->q));
					
				}elseif($row['0']['marker']== 1 && $row['0']['usetsmarker']== 0){
				
					$replace = '';
					$replace = implode('+', $this->q);
					$url ='';					
					$url = str_replace('###marker###', $replace , $row[0]['url']);

					header('Location: ' .$url);
					
				}elseif($row['0']['marker']== 0 && $row['0']['usetsmarker'] == 1){
				
					$url ='';
					$typoScriptCode = '';
					$typoScriptCode = $this->getTypoScript($row[0]['tsmarker']);
					$url = str_replace('###tsmarker###',$typoScriptCode, $row[0]['url']);
					header('Location: ' .$url);
					
				}elseif($row['0']['marker']== 1 && $row['0']['usetsmarker']== 1){
					
					$replace = '';
					$replace = implode('+', $this->q);
					$url ='';					
					$url = str_replace('###marker###', $replace , $row[0]['url']);
					
					$typoScriptCode = '';
					$typoScriptCode = $this->getTypoScript($row[0]['tsmarker']);
					$url = str_replace('###tsmarker###',$typoScriptCode, $url);
					header('Location: ' .$url);
				}
			}elseif($row[0]['useadvanced'] == 1){
				$extConf = '';
				$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['redirect_search']);
				
				$readPath = t3lib_div::getFileAbsFileName($extConf['user_Files']);
				if (@is_dir($readPath)){
					include_once($readPath . $row[0]['advanced'] );
					$userfile = t3lib_div::makeInstance('tx_redirectsearch_advanced');
					echo $userfile->main($this->q);
				}
			}else {
			$this->getHelp();
		}	
		
	}
	
	
	function getTypoScript($typoscriptCode){
		
		require_once(PATH_t3lib.'class.t3lib_tsparser.php');
		$TSparserObject = '';
		$TSparserObject = t3lib_div::makeInstance('t3lib_tsparser');
		$TSparserObject->parse($typoscriptCode);
		
		// Get page browser
		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$cObj->start(array(), '');

		require_once(PATH_tslib . 'class.tslib_fe.php');
		$tsfeClassName = t3lib_div::makeInstanceClassName('tslib_fe');
		$GLOBALS['TSFE'] = new $tsfeClassName($GLOBALS['TYPO3_CONF_VARS'], 0, '');

		return $cObj->cObjGet($TSparserObject->setup);
	}
	
	function getResult($table){
	
		 $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*',
						$table,
						'hotkey=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($this->q[0],$table) .
						$this->andWhere,
						'',
						'',
						'1'
						
				);
		return 	$row;
	}
	
	function getHelp(){
		$extConf = '';
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['redirect_search']);
	
		if($extConf['showHelp'] == 1){	
			$searchItems = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_redirectsearch_search', '1=1'. $this->andWhere,'','hotkey');
			echo $this->buildingList($searchItems,'SearchItems');
		}else{
			echo 'access forbidden';
		}	
	}
	
	function buildingList($items,$tableHead){
	
				//opening
				$content .= '<table style="margin-bottom:20px;" width="50%" border="0" cellspacing="0" cellpadding="3" class="list" summary="">';
				$content .= '<caption align="top"></caption>';
			
				// date and names
				$content .= '<tr bgcolor="#cccccc"><td><strong>' . $tableHead . '</strong></td><td></td></tr>';
				$content .= '<tr bgcolor="#E6E6E6"><td>HotKey</td><td>URL</td></tr>';


				if(is_array($items)){
					// values
					$alt = 1;
					foreach ($items as $item) {
						$content .= '<tr class="sub-' . ($alt + 1). '">';  //row open
						$content .= '<td>' . $item['hotkey']  . '</td>';  //first Entry
						$content .= '<td><a href="' . $item['url']  . '">' . $item['url'] . '</a></td>';  //first Entry
						$content .= '</tr>';
						$alt = ($alt + 1) % 2;
					}
				}
				$content .= '</table>';

				return $content;
	}					
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/redirect_search/class.tx_redirectsearch_eID.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/redirect_search/class.tx_redirectsearch_eID.php']);
}

// Make instance:
$SOBE = t3lib_div::makeInstance('tx_redirectsearch_eID');
$SOBE->init();
$SOBE->main();

?>