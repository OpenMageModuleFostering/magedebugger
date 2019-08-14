<?php

class Magestore_Magedebuger_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getIpAddress()
	{
		return $_SERVER['REMOTE_ADDR'];
	}
	
	public function is_allowedIP()
	{
		$allowed_ips = Mage::getStoreConfig('magedebuger/general/allowed_ips');
		$allowed_ips = explode(',',$allowed_ips);
		if(!count($allowed_ips))
			return false;
		$ip = $this->getIpAddress();
		if(in_array($ip,$allowed_ips))
			return true;
		else
			return false;
	}
	
	public function var_dump($value,$name=null)
	{
		Mage::getSingleton('magedebuger/magedebuger')->call('var_dump',$value,$name);
	}
	
	public function print_r($value,$name=null)
	{
		Mage::getSingleton('magedebuger/magedebuger')->call('print_r',$value,$name);
	}

	public function echo_m($value,$name=null)
	{
		Mage::getSingleton('magedebuger/magedebuger')->call('echo',$value,$name);
	}	

	public function print_m($value,$name=null)
	{
		Mage::getSingleton('magedebuger/magedebuger')->call('print',$value,$name);
	}
}