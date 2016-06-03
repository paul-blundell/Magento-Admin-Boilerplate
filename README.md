# Magento Admin Boilerplate
Provides a starting admin interface with Import/Export.

## Facts
- Version: 1.0.0
- Extension key: Company_AdminBoilerplate

## Description
A starting template for an admin extension to manage data.

### Features
- Dynamic Fields - defined in fields.xml
- Import/Export with CSVs

### How to use this
1. Clone the repo into your project.
1. Replace all occurrences of `AdminBoilerplate` with `YourModule` and then `adminboilerplate` with `yourmodule`. Case sensitive!
1. Rename the files `controllers/Adminhtml/Company/AdminboilerplateController.php` and `etc/modules/Company_AdminBoilerplate.xml`
1. Rename the folders in `sql` and `controllers/Adminhtml/`
1. Update the table name in config.xml if required
1. Define the fields in fields.xml - do this before installing!

### Fields
By default all defined fields will be stored in the custom_data column in the database
as a JSON object. This gives you the flexibility of being able to alter the fields
after installation. However, you will not be able to filter a collection on these fields. To do this
you should define any field you may need to filter on in the fields.xml file
as `filterable`:

    <filterable>true</filterable>

Do this BEFORE installing and when the database table is created these filterable
fields will have physical columns in the table.

### Reinstalling
If you need to reinstall because you have changed some of the filterable fields
or added more:

1. Delete your database table.
1. Go to `core\_resource` and find your module `company\_[module]\_setup`, delete this row.

### Using

After adding your data in the backend, you can get your data with the following:

    Mage::getModel('company_adminboilerplate/data')->getCollection();

## Requirements
- PHP >= 5.5.0

## Compatibility
- Magento >= 1.9.2.3

## Uninstallation
Remove the `app/code/local/Company/AdminBoilerplate/` folder and the xml file in `etc/modules/Company_adminboilerplate.xml`
Delete the database table `company_adminboilerplate`

## Developer
Paul Blundell
paul@blundell.xyz

## Copyright
&copy; 2016 Paul Blundell
