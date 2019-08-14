<?php

class Magestore_Magedebuger_Adminhtml_MagedebugerController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('system/magedebuger')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Cache Magebugs'), Mage::helper('adminhtml')->__('Cache Magebugs'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	
	public function clearAction()
	{
		$cache_path = Mage::getBaseDir('var').DS.'magedebuger';
		$ioFile = new Varien_Io_File();
		try{
			$ioFile->rmdir($cache_path,true);
			Mage::getSingleton('core/session')
					->addSuccess(Mage::helper('adminhtml')->__('removed successful'));
			$this->_redirect('*/*/index');
		} catch(Exception $e){
			Mage::getSingleton('core/session')
					->addSuccess(Mage::helper('adminhtml')->__('removed failed'));		
			$this->_redirect('*/*/index');
		}
	}
}