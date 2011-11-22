<?php

abstract class Blog_Plugin {
	
	private $type			= "";
	private $name 			= "";
	private $description 	= "";
	private $date 			= "";
	private $author 		= "";
	private $disabled;
	
	private $js_files		= array();
	private $css_files		= array();
	
	public function __construct($name) {
		$config = new Config_Lite(PLUGIN_DIR.'/'.$name.'/plugin.conf');
		$this->name = $config->get(null,'name');
		$this->type = $config->get(null,'type');
		$this->description = $config->get(null,'description');
		$this->date = $config->get(null, 'date');
		$this->author = $config->get(null, 'author');
		$this->disabled = $config->getBool(null,'disabled',false);
		
		$dir = new DirectoryIterator(PLUGIN_DIR.'/'.$name);
		foreach($dir as $d)
			if($d->isFile()) {
				if(substr((string)$d, -3) == '.js')
					$this->js_files[] = (string)$d;
				else if(substr((string)$d, -4) == '.css')
					$this->css_files[] = (string)$d;
			}
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function isDisabled() {
		return $this->disabled;
	}
	
	public function getCSSfiles() {
		return $this->css_files;
	}
	
	public function getJSfiles() {
		return $this->js_files;
	}
	
	/**
	 * 
	 * The rendering of the plugin on the plugin page.
	 */
	abstract public function render();
	
	/**
	 * 
	 * The admin page (configuration).
	 */
	abstract public function admin();
	
	public function __toString() {
		return $this->getName();
	}
}