<?php
class Magestore_Magedebuger_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		if(!Mage::helper('magedebuger')->is_allowedIP())
		{
			$this->_redirect('');
			return;
		}
		
		$debugger = Mage::getModel('magedebuger/magedebuger');

		$magebugs = $debugger->loadBugs();

		Mage::register('magebugs',$magebugs);
		
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function clearAction()
	{
		if(!Mage::helper('magedebuger')->is_allowedIP())
		{
			$this->_redirect('');
			return;
		}		
		Mage::getModel('magedebuger/magedebuger')->clear();
		$this->_redirect('*/*/index',array());
	}	
}