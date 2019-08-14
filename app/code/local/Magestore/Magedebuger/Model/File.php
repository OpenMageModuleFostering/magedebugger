<?php

class Magestore_Magedebuger_Model_File extends Varien_Object{
	
	private $_file = null;
	private $_filepath = null;
	
	public function open($fileId,$mode = 'w')
	{
		$this->_createFolder();
		$this->_filepath = $this->_getFolder().DS.$fileId.".mbg";
		$this->_file = fopen($this->_filepath,$mode);
		return $this;
	}
	
	public function save($content)
	{
		if(!$this->_file)
			return $this;
		try{
			fwrite($this->_file,$content);
			return $this;
		} catch(Exception $e){
			return $this;
		}
	}
	
	public function getContent()
	{
		if(!$this->_file)
			return $this;
		try{
			$contents = file_get_contents($this->_filepath);
			return $contents;
		} catch(Exception $e){
			return null;
		}		
	}
	
	public function close()
	{
		if($this->_file)
			fclose($this->_file);
		
		return $this;
	}
	
	public function getBugFiles()
	{
		return $this->_readdir($this->_getFolder());
	}
	
	protected function _readdir($dir)
	{
		$files = array();
		if(!is_dir($dir))
			return $files;
		foreach( scandir( $dir ) as $item ){
			if( !strcmp( $item, '.' ) || !strcmp( $item, '..' ) )
				continue;
			$size = filesize($dir.DS.$item);
			$files[] = new Varien_Object(array('name'=>$item,'size'=>$size));
		}
		return $files;
	}
	
	protected function _createFolder()
	{
		if(!is_dir($this->_getFolder()))
		{
			try{
				mkdir($this->_getFolder());
				chmod($this->_getFolder(),0755);
				return true;
			}catch(Exception $e){
				return false;
			}
		}
	}
	
	protected function _getFolder()
	{
		if(!$this->getData('folder'))
		{
			$folder = Mage::getBaseDir('var').DS.'magedebuger';
			$this->setData('folder',$folder);
		}
		return $this->getData('folder');
	}
}