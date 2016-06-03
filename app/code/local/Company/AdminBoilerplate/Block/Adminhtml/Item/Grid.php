<?php
class Company_AdminBoilerplate_Block_Adminhtml_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('company_adminboilerplate/data_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareColumns()
    {
        $fields = Mage::helper('company_adminboilerplate')->getFields();

        foreach ($fields AS $key=>$field)
        {
            if (!$field->grid) continue;

            $fieldMap = array(
                'header' => $this->_getHelper()->__($field->label),
                'type' => $field->type,
                'index' => $key
            );

            if ($field->width)
                $fieldMap['width'] = $field->width;
                
            $this->addColumn($key, $fieldMap);
        }

        $this->addColumn('action', array(
            'header' => $this->_getHelper()->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'actions' => array(
                array(
                    'caption' => $this->_getHelper()->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'entity_id',
            'is_system' => true
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('company_adminboilerplate')->__('CSV'));

        return parent::_prepareColumns();
    }

    protected function _getHelper()
    {
        return Mage::helper('company_adminboilerplate');
    }
}
