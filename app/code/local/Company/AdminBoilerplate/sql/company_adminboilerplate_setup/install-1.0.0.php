<?php
$this->startSetup();

$fields = Mage::helper('company_adminboilerplate')->getFields();

$table = new Varien_Db_Ddl_Table();
$table->setName($this->getTable('company_adminboilerplate/data'));
$table->addColumn(
    'entity_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER, 
    10, 
    array(
        'auto_increment' => true,
        'unsigned' => true,
        'nullable'=> false,
        'primary' => true
    )
);

// Install filterable/static fields
foreach ($fields AS $key=>$field)
{
    if (!$field->filterable) continue;
    
    $type = Varien_Db_Ddl_Table::TYPE_VARCHAR;
    $limit = 255;
    
    switch ($field->type)
    {
        case 'text':
            $type = Varien_Db_Ddl_Table::TYPE_TEXT;
            $limit = null;
            break;
        case 'int':
            $type = Varien_Db_Ddl_Table::TYPE_INTEGER;
            $limit = null;
            break;
    }
    
    $table->addColumn(
        $key, 
        $type, 
        $limit, 
        array(
            'nullable' => true,
        )
    );
}

// Column for dynamic fields
$table->addColumn(
    'custom_data', 
    Varien_Db_Ddl_Table::TYPE_TEXT, 
    null, 
    array(
        'nullable' => true,
    )
);
$table->setOption('type', 'InnoDB');
$table->setOption('charset', 'utf8');
$this->getConnection()->createTable($table);

$this->endSetup();
