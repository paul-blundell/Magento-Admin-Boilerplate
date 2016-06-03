<?php
class Company_AdminBoilerplate_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getFields()
    {
        return get_object_vars(Mage::getConfig()->loadModulesConfiguration('fields.xml')->getNode('company_adminboilerplate/csv_fields'));
    }
}