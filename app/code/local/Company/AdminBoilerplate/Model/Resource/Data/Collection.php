<?php
class Company_AdminBoilerplate_Model_Resource_Data_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        
        $this->_init(
            'company_adminboilerplate/data', 
            'company_adminboilerplate/data'
        );
    }
    
    public function _afterLoadData()
    {
        $data = $this->getData();

        foreach ($data AS &$item)
        {
            $fields = json_decode($item['custom_data']);
            foreach ($fields AS $key=>$values)
            {
                $item[$key] = $values;
            }
            unset($item['custom_data']);
        }
        
        $this->_data = $data;
        parent::_afterLoadData();
    }
}