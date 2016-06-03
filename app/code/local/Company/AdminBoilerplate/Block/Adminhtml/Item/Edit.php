<?php
class Company_AdminBoilerplate_Block_Adminhtml_Item_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'company_adminboilerplate_adminhtml';
        $this->_controller = 'item';
        $this->_mode = 'edit';

        $newOrEdit = $this->getRequest()->getParam('id') ? $this->__('Edit')  : $this->__('New');
        $this->_headerText =  $newOrEdit . ' ' . $this->__('Item');
    }
}
