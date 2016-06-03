<?php
class Company_AdminBoilerplate_Adminhtml_Company_AdminboilerplateController extends Mage_Adminhtml_Controller_Action
{
    private $filesPath;

    public function indexAction()
    {
        $this->filesPath = Mage::getConfig()->getNode('default/company_bikeinformation/media_path');

        // instantiate the grid container
        $contentBlock = $this->getLayout()->createBlock('company_adminboilerplate_adminhtml/item');

        // add the grid container as the only item on this page
        $this->getLayout()->getBlock('head')->setTitle($this->__('Admin Boilerplate'));
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }

    /**
     * This action handles both viewing and editing of existing content.
     */
    public function editAction()
    {
        $content = Mage::getModel('company_adminboilerplate/data');

        if ($contentId = $this->getRequest()->getParam('id', false))
        {
            $content->load($contentId);

            if ($content->getId() < 1)
            {
                $this->_getSession()->addError(
                    $this->__('This data no longer exists.')
                );

                return $this->_redirect('*/*/index');
            }
        }

        // process $_POST data if the form was submitted
        if ($postData = $this->getRequest()->getPost())
        {
            try {
                if (!empty($_FILES))
                    $this->_saveFiles($postData);

                foreach ($postData as $key => $value)
                {
                    if (is_array($value))
                        $postData[$key] = implode(',', $value);
                }

                $content->addData($postData);
                $content->save();

                $this->_getSession()->addSuccess(
                    $this->__('The content has been saved.')
                );

                // redirect to remove $_POST data from the request
                return $this->_redirect('*/*/edit', array('id' => $content->getId()));

            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
        }

        // make the current object available to blocks
        Mage::register('current_content', $content);

        // instantiate the form container
        $contentEditBlock = $this->getLayout()->createBlock(
            '*/*/item_edit'
        );

        // add the form container as the only item on this page
        $this->loadLayout()
            ->_addContent($contentEditBlock)
            ->renderLayout();
    }

    public function deleteAction()
    {
        $content = Mage::getModel('company_adminboilerplate/data');

        if ($contentId = $this->getRequest()->getParam('id', false))
            $content->load($contentId);

        if ($content->getId() < 1)
        {
            $this->_getSession()->addError(
                $this->__('This data no longer exists.')
            );

            return $this->_redirect('*/*/index');
        }

        try {
            $content->delete();

            $this->_getSession()->addSuccess(
                $this->__('The content has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect('*/*/index');
    }

    public function importAction()
    {
        if ($data = $this->getRequest()->getPost())
        {
            try {
                Mage::getResourceModel('company_adminboilerplate/data')->import($data);
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('company_adminboilerplate')->__('Import completed.'));
                $this->_redirect('*/*/index');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $contentEditBlock = $this->getLayout()->createBlock(
            'company_adminboilerplate_adminhtml/item_import'
        );

        $this->loadLayout()
            ->_addContent($contentEditBlock)
            ->renderLayout();
    }

    public function exportCsvAction()
    {
        $fileName   = 'item_data.csv';
        $content    = $this->getLayout()->createBlock('company_adminboilerplate_adminhtml/item_csv')->getCsvFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $this->_prepareDownloadResponse($fileName, $content, $contentType);
    }

    protected function _isAllowed()
    {
        $actionName = $this->getRequest()->getActionName();

        switch ($actionName)
        {
            case 'index':
            case 'edit':
            case 'delete':
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession->isAllowed('company_adminboilerplate/item');
                break;
        }

        return $isAllowed;
    }

    protected function _saveFiles(&$postData)
    {
        foreach ($_FILES AS $field=>$data)
        {
            if (empty($data['name'])) continue;

            $uploader = new Varien_File_Uploader($field);

            if ($field == 'image')
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));

            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);

            $uploader->save(Mage::getBaseDir('media').DS.$this->filesPath, $data['name']);

            $postData[$field] = $data['name'];
        }
    }
}
