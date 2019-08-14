<?php

class Magestore_Magedebuger_Model_Magedebuger extends Varien_Object
{
	public function var_dump($value,$name=null)
	{
		$this->call('var_dump',$value,$name);
	}
	
	public function print_r($value,$name=null)
	{
		$this->call('print_r',$value,$name);
	}

	public function echo_m($value,$name=null)
	{
		$this->call('echo',$value,$name);
	}	

	public function print_m($value,$name=null)
	{
		$this->call('print',$value,$name);
	}			
	
	public function call($fval,$value,$name=null)
	{
		if(!Mage::helper('magedebuger')->is_allowedIP())
			return $this;
		$this->save($fval,$value,$name);
		return $this;
	}
	
	public function getBugSession()
	{
		if(!Mage::getSingleton('magedebuger/session')->getData('bug_session'))
		{
			$bug_session = Mage::helper('magedebuger')->getIpAddress();
			$bug_session .= '_'.md5(time());
			Mage::getSingleton('magedebuger/session')->setData('bug_session',$bug_session);
		}
		return Mage::getSingleton('magedebuger/session')->getData('bug_session');
	}
	
	public function loadBugs($params = array())
	{
		$bug_session = Mage::getSingleton('magedebuger/session')
							->getData('bug_session');
		if(!$bug_session)
			return array();
		$file = Mage::getModel('magedebuger/file');
		$file->open($bug_session,'a');
		$serialized_bug = $file->getContent();
		$file->close();
		return $this->_parse($serialized_bug);
	}
	
	public function clear()
	{
		$bug_session = Mage::getSingleton('magedebuger/session')
							->getData('bug_session');
		if(!$bug_session)
			return $this;
		$file = Mage::getModel('magedebuger/file');
		$file->open($bug_session,'w');
		$file->save(null);
		$file->close();
		return $this;
	}
	
	public function save($fval,$value,$name=null)
	{
		$serialized_value = serialize($value);
		$bug = $fval."****".$serialized_value."****".$name."\n";
		$file = Mage::getModel('magedebuger/file');
		$file->open($this->getBugSession(),'a');
		$file->save($bug);
		$file->close();
		return $this;
	}
	
	protected function _parse($serialized_bug)
	{
		$bugs = array();
		$bugArr = explode("\n",$serialized_bug);
		if(! count($bugArr))
			return $this;			
		
		$i = 0;
		foreach($bugArr as $bug)
		{
			$bugs[$i++] = explode('****',$bug);
		}
		return $bugs;
	}
}