<?php
/**
 * Created by PhpStorm.
 * User: j.idziak@macopedia.pl
 * Date: 15.02.16
 * Time: 15:45
 */
class Macopedia_CopyStoreData_Block_Adminhtml_System_Store_Store extends Mage_Adminhtml_Block_System_Store_Store
{
    protected function _prepareLayout()
    {
        /* Add Copy Store Data button */
        $this->_addButton('copy_store', array(
            'label'     => Mage::helper('core')->__('Copy Store Data'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/copyStoreData') .'\')',
            'class'     => 'copy',
        ));

        parent::_prepareLayout();

        return Mage_Adminhtml_Block_Widget_Container::_prepareLayout();
    }
}
