<?php
class Company_AdminBoilerplate_Model_Data extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('company_adminboilerplate/data');
    }
    
    protected function _afterLoad()
    {
        parent::_afterLoad();
        
        if (!isset($this->_data['custom_data']))
            return $this;

        $fields = json_decode($this->_data['custom_data']);
        foreach ($fields AS $key=>$data)
        {
            $this->_data[$key] = $data;
        }
        unset($this->_data['data']);

        return $this;
    }
    
    protected function _beforeSave()
    {
        parent::_beforeSave();
        
        $dynamicFields = Mage::helper('company_adminboilerplate')->getFields();
        $result = array();
        foreach ($dynamicFields AS $key=>$field)
        {
            // Don't include filterable fields in the grouped data
            // as these have their own column in the table
            if ($field->filterable) continue;
            
            if (isset($this->_data[$key]))
            {
                $result[$key] = $this->_data[$key];
                unset($this->_data[$key]);
            }
        }
        $this->_data['custom_data'] = json_encode($result);

        return $this;
    }
}
