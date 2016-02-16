<?php
/**
 * Created by PhpStorm.
 * User: j.idziak@macopedia.pl
 * Date: 15.02.16
 * Time: 15:25
 */
require_once 'Mage/Adminhtml/controllers/System/StoreController.php';

class Macopedia_CopyStoreData_Adminhtml_System_StoreController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Mage_Adminhtml_Cms_PageController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('system/store')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('System'), Mage::helper('adminhtml')->__('System'))
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Stores'), Mage::helper('adminhtml')->__('Manage Stores'))
        ;
        return $this;
    }

    protected function _getModel(){
        return Mage::getModel('macopedia_copystoredata/store_copy');
    }

    public function copyStoreDataAction()
    {
        $this->_title($this->__('System'))
            ->_title($this->__('Stores'));
        $this->_initAction()
            ->_addContent($this->getLayout()
                ->createBlock('macopedia_copystoredata/adminhtml_system_store_copy')
                ->setChild('form', Mage::getBlockSingleton('macopedia_copystoredata/adminhtml_system_store_copy_form')))
            ->renderLayout();
    }

    public function copyAction()
    {
        if ($this->getRequest()->isPost() && $postData = $this->getRequest()->getPost()) {
            $session = $this->_getSession();
            if (empty($postData['from_store_id']) || empty($postData['to_store_id'])) {
                $session->addError(Mage::helper('core')->__('Please select "From Store View" and "To Store View"'));
                $this->_redirect('*/*/copyStoreData');
                return;
            }
            if (empty($postData['page']) && empty($postData['block'])) {
                $session->addError(Mage::helper('core')->__('Please select data to copy'));
                $this->_redirect('*/*/copyStoreData');
                return;
            }

            $dataTypes = array();
            if (!empty($postData['page'])) {
                array_push($dataTypes, 'page');
            }
            if (!empty($postData['block'])) {
                array_push($dataTypes, 'block');
            }

            try {
                foreach ($dataTypes as $dataType) {
                    $error = $this->_getModel()->copyData($dataType, $postData['from_store_id'], $postData['to_store_id']);
                    if ($error) {
                        $session->addError($error);
                        throw new Exception($error);
                    } else {
                        $session->addSuccess(Mage::helper('core')->__('CMS ' . $dataType . 's copied correctly'));
                    }
                }

                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $session->addError($e->getMessage());
                $session->setPostData($postData);
            } catch (Exception $e) {
                $session->addException($e, Mage::helper('core')->__('An error occurred while copying. Please review the error log.'));
                $session->setPostData($postData);
            }
            $this->_redirectReferer();
            return;
        }
        $this->_redirect('*/*/');
    }
}
