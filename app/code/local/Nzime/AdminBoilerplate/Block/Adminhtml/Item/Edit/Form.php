<?php
class Company_AdminBoilerplate_Block_Adminhtml_Item_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/edit', array(
                    '_current' => true,
                    'continue' => 0,
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);
        $fieldset = $form->addFieldset('general',array('legend' => $this->__('Details')));

        $fields = array();
        $dynamicFields = Mage::helper('company_adminboilerplate')->getFields();
        foreach ($dynamicFields AS $key=>$field)
        {
            $fields[$key] = array(
                'label' => $field->label,
                'input' => $field->input,
                'required' => $field->required,
                'after_element_html' => '<br><small>'.$field->notes.'</small>'
            );

            if (($field->input == 'select' || $field->input == 'multiselect') && isset($field->values))
            {
                $value = (String)$field->values;
                $fields[$key]['values'] = Mage::helper('company_storelocator')->$value();
            }
        }

        $this->_addFieldsToFieldset($fieldset, $fields);

        return parent::_prepareForm();
    }

    protected function _addFieldsToFieldset(Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()->getPost('contentData'));

        foreach ($fields as $name => $_data)
        {
            if ($requestValue = $requestData->getData($name))
                $_data['value'] = $requestValue;

            $_data['name'] = $name;
            $_data['title'] = $_data['label'];

            // if no new value exists, use existing content data
            if (!array_key_exists('value', $_data))
                $_data['value'] = $this->_getContent()->getData($name);

            // finally call vanilla functionality to add field
            $field = $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

    protected function _getContent()
    {
        if (!$this->hasData('content'))
        {
            $content = Mage::registry('current_content');

            if (!$content instanceof Company_AdminBoilerplate_Model_Data)
                $content = Mage::getModel('company_adminboilerplate/data');

            $this->setData('content', $content);
        }

        return $this->getData('content');
    }
}
