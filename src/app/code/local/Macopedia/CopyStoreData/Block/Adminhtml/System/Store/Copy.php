<?php
/**
 * Created by PhpStorm.
 * User: j.idziak@macopedia.pl
 * Date: 15.02.16
 * Time: 15:44
 */
class Macopedia_CopyStoreData_Block_Adminhtml_System_Store_Copy extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'macopedia_copystoredata';
        $this->_controller = 'system_store';
        $this->_mode       = 'copy';

        $this->_removeButton('save');
        $this->_removeButton('reset');

        $this->_addButton('copy', array(
            'label'     => Mage::helper('core')->__('Copy Store Data'),
            'onclick'   => 'editForm.submit();',
            'class'     => 'save',
        ), 1);
    }

    public function getFormHtml()
    {
        $this->getChild('form')->setData('action', $this->getUrl('*/*/copy'));
        return $this->getChildHtml('form');
    }

    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('core')->__('Copy Store Data');
    }
}
