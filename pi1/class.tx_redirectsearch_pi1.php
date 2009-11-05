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

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Add a FF Searchbar' for the 'redirect_search' extension.
 *
 * @author	Sven Juergens <sj@nordsonne.de>
 * @package	TYPO3
 * @subpackage	tx_redirectsearch
 */
class tx_redirectsearch_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_redirectsearch_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_redirectsearch_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'redirect_search';	// The extension key.
	var $pi_checkCHash = true;
	
	public $templateCode = '';
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		
		$this->init();

	 if(t3lib_div::_GP('type') == 222){
			$content = $this->getSearch();
			header('Content-type:application/xml;');
			die($content);
		}else{
			$this->addHeaderPart();
			$content .= '<a href="#" onclick="window.external.AddSearchProvider(\'' . t3lib_div::getIndpEnv(TYPO3_SITE_URL) . $this->getOpenSearch_url() . '\');">huhu</a>'   ;
			$content = $this->pi_wrapInBaseClass($content);
		}
		return $content;
	}
	
	function init(){
		$this->pi_initPIflexForm();
		
		$this->fetchConfigValue('pluginName');
		$this->fetchConfigValue('pluginDescription');
		$this->fetchConfigValue('pluginIcon');
		$this->fetchConfigValue('templateFile');
		$this->templateCode  = 	$this->cObj->fileResource($this->conf['templateFile']);
		
		if(empty($this->templateCode)) {
			$this->templateCode = $this->cObj->fileResource('EXT:' . $this->extKey . '/res/template.tmpl');
		}
	}
	
	function addHeaderPart(){
	
		$link = '<link rel="search" type="application/opensearchdescription+xml"' ;
		$link .= 'href="' . t3lib_div::getIndpEnv(TYPO3_SITE_URL) . $this->getOpenSearch_url() . '"';
		$link .= 'title="'. $this->conf['pluginDescription'] . '" />';

		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] = $link;
			
	}
	
	function getSearch(){
	
		$templateSubpart = $this->cObj->getSubpart($this->templateCode,'###CONTENT###');
		$markerArray = array(
			'###SEARCHNAME###' 			=> 	$this->conf['pluginName'], 
			'###SEARCHDESCRIPTION###' 	=>	$this->conf['pluginDescription'],
			'###SEARCHURL###' 			=>	$this->getSearch_url(),
			'###SEARCHICON_PNG###'		=>	$this->getSearch_icon($this->conf['pluginIcon'],'png'),
			'###SEARCHICON_JPG###'		=>	$this->getSearch_icon($this->conf['pluginIcon'],'jpg'),
		);
		
		// TODO - adding SearchICON
		
		$entries[] = $this->cObj->substituteMarkerArray($templateSubpart, $markerArray);

		return implode('', $entries);
		

	}
	function getSearch_icon($image,$ext){
			$withAndHeight ='';
			if($ext == 'png'){
				$withAndHeight = '16'; 
			}else{
				$withAndHeight = '64';
			}
			
			$imageConf = array(
				'file' => 'uploads/tx_redirectsearch/' . $image,
				'file.' => array(
					'width' => $withAndHeight,
					'height' => $withAndHeight,
					'ext' => $ext,
				)
			);
		return t3lib_div::getIndpEnv(TYPO3_SITE_URL) . $this->cObj->IMG_RESOURCE($imageConf);
	
	}
	function getSearch_url(){
		// host + index.php?eID=redirectsearch&amp;q={searchTerms}
		return t3lib_div::getIndpEnv(TYPO3_SITE_URL) . 'index.php?eID=redirectsearch&amp;q={searchTerms}';
	}
	
	function getOpenSearch_url(){
		
		$conf = array(
			'parameter' => $GLOBALS['TSFE']->id,
			'additionalParams' => '&type=222',
		);	
		return $this->cObj->typolink_URL($conf);

	}
	
	function fetchConfigValue($param, $sheet='sDEF') {
		$value = trim($this->pi_getFFvalue($this->cObj->data['pi_flexform'], $param, $sheet));
		if (!is_null($value) && $value != '') {
				$this->conf[$param] = $value;
		}
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/redirect_search/pi1/class.tx_redirectsearch_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/redirect_search/pi1/class.tx_redirectsearch_pi1.php']);
}

?>