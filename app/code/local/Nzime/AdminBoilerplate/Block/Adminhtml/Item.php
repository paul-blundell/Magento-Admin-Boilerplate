<?php
class Company_AdminBoilerplate_Block_Adminhtml_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'company_adminboilerplate_adminhtml';
        $this->_controller = 'item';
        $this->_headerText = Mage::helper('company_adminboilerplate')->__('My Data');

        /**
         * Add our import button
         */
        $this->_addButton('import', array(
            'label'   => Mage::helper('catalog')->__('Import'),
            'onclick' => "setLocation('{$this->getUrl('*/*/import')}')",
            'class'   => 'add'
        ));
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/edit');
    }
}
