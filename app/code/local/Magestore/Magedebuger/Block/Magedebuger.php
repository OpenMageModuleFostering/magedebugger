<?php
class Magestore_Magedebuger_Block_Magedebuger extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMageBugs()     
     { 
        if (!$this->hasData('magebugs')) {
            $this->setData('magebugs', Mage::registry('magebugs'));
        }
        return $this->getData('magebugs');
    }
}