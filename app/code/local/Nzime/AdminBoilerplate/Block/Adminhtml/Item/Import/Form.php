<?php

class Company_AdminBoilerplate_Block_Adminhtml_Item_Import_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/import', array(
                    '_current' => true,
                    'continue' => 0,
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);

        $hlp = Mage::helper('company_adminboilerplate');

        $fieldSet = $form->addFieldset('import_options', array('legend'=> $hlp->__('Import Options')));
        $fieldSet->addField('import_clear', 'select', array(
          'label'     => $hlp->__('Delete Existing Data'),
          'name'      => 'import_clear',
          'values'    => array(
            array(
                'value' => 0,
                'label' => Mage::helper('catalog')->__('No')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('catalog')->__('Yes')
            ))
        ));

        $fieldSet->addField('import_file', 'file', array(
          'label'     => $hlp->__('CSV File'),
          'name'      => 'import_file'
        ));

        return parent::_prepareForm();
    }
}
