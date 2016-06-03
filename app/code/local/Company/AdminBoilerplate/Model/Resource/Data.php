<?php
class Company_AdminBoilerplate_Model_Resource_Data extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('company_adminboilerplate/data', 'entity_id');
    }

    public function truncate()
    {
        $this->_getWriteAdapter()->query('TRUNCATE TABLE '.$this->getMainTable());
        return $this;
    }

    public function import($data)
    {
        if (empty($_FILES['import_file']['name']))
            throw new Exception('Could not retrieve uploaded file.');

        if (isset($data['import_clear']) && $data['import_clear'])
            $this->truncate();

        $filename = $_FILES['import_file']['tmp_name'];

        $data = $this->_parseFile($filename);

        $fields = Mage::helper('company_adminboilerplate')->getFields();

        foreach($data AS $row)
        {
            $newItem = Mage::getModel('company_adminboilerplate/data');

            foreach($fields AS $key=>$field)
            {
                if (isset($row[$key]) && !empty($row[$key]))
                    $newItem->setData($key, $row[$key]);
            }

            $newItem->save();
        }

        return true;
    }

    protected function _parseFile($filename)
    {
         //for Mac OS
        ini_set('auto_detect_line_endings', 1);

        $csv = new Varien_File_Csv();
        $data = $csv->getData($filename);
        $keys = array_shift($data);

        for($i=0; $i<count($data); $i++)
        {
            $data[$i] = array_combine($keys, $data[$i]);
        }

        return $data;
    }
}
