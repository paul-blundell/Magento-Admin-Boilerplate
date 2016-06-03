<?php
class Company_AdminBoilerplate_Block_Adminhtml_Item_Import extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'company_adminboilerplate_adminhtml';
        $this->_controller = 'item';
        $this->_mode = 'import';

        $this->_headerText =  $this->__('Import');
    }
}