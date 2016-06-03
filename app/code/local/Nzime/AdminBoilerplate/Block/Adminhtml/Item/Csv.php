<?php
class Company_AdminBoilerplate_Block_Adminhtml_Item_Csv extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('company_adminboilerplate/data_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $fields = Mage::helper('company_adminboilerplate')->getFields();
        foreach ($fields AS $key=>$field)
        {
            $fieldMap = array(
                'header' => $this->_getHelper()->__($field->label),
                'type' => $field->type,
                'index' => $key
            );

            $this->addColumn($key, $fieldMap);
        }

        return parent::_prepareColumns();
    }

    protected function _getHelper()
    {
        return Mage::helper('company_adminboilerplate');
    }
}
