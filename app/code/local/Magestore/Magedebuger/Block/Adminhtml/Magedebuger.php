<?php
class Magestore_Magedebuger_Block_Adminhtml_Magedebuger extends Mage_Adminhtml_Block_Widget_Form
{
	public function _prepareLayout()
    {
		parent::_prepareLayout();
		$this->setTemplate('magedebuger/magedebuger.phtml');
		return $this;
    }
    
     public function getBugFiles()     
     { 
        if (!$this->hasData('bug_files')) {
			$bug_files = Mage::getModel('magedebuger/file')
								->getBugFiles();
            $this->setData('bug_files', $bug_files);
        }
        return $this->getData('bug_files');
    }
}