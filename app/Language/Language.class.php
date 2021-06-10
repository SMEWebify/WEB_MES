<?php

namespace App\Language;

class Language {
	//Language by ISO 639 code (default: French)
	private $_lang = 'fr';
	
	//Folder containing languages
	private $_dirLangue = '../Language';
	
	// Objet SimpleXML
	private $_simpleXML = null;
	
	//Builder
	public function __construct($dirLangue, $folder, $lang = false) {
		if(is_dir($dirLangue)) {
			$this->_dirLangue = $dirLangue;
		}
		else {
			$this->_dirLangue = 'ERP/../../app/Language';
		}
		
		if($lang) {
			$this->_lang = strtolower($lang);
		}
		else {
			if($lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))) {
				$this->_lang = $lang;
			}
			else {
				$this->_lang = 'fr';
			}
		}
		
		if(file_exists($this->_dirLangue.'/'.$this->_lang.'/'.$folder.'.xml')) {
			//Load XML file
			$this->loadXmlFile($folder);
		}
		else {
			die('Fichier XML ('.$this->_dirLangue.'/'.$this->_lang.'/'.$folder.'.xml) innexistant ! Merci de vérifier que celui ci existe.');
		}
	}
	
	//Load XML file
	private function loadXmlFile($folder) {
		$this->_simpleXML = simplexml_load_file($this->_dirLangue.'/'.$this->_lang.'/'.$folder.'.xml');
	}
	
	//Load the message to display
	public function show_text($text) {
		$result = $this->_simpleXML->xpath($text);
		
		foreach($result as $node) {
			return $node;
		}
	}
}
?>