<?php
/**
 * Created by PhpStorm.
 * User: j.idziak@macopedia.pl
 * Date: 15.02.16
 * Time: 16:04
 */
class Macopedia_CopyStoreData_Block_Adminhtml_System_Store_Copy_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('copy_store_data_form');
    }

    /**
     * Prepare form data
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        /* @var $fieldset Varien_Data_Form */
        $fieldset = $form->addFieldset('copy_store_data_fieldset', array(
            'legend' => Mage::helper('core')->__('Copy Store Data settings')
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('from_store_id', 'select', array(
                'name' => 'from_store_id',
                'label' => Mage::helper('core')->__('From Store View'),
                'title' => Mage::helper('core')->__('From Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')
                        ->getStoreValuesForForm(false, true),
            ));
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
            $field = $fieldset->addField('to_store_id', 'select', array(
                'name' => 'to_store_id',
                'label' => Mage::helper('core')->__('To Store View'),
                'title' => Mage::helper('core')->__('To Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')
                        ->getStoreValuesForForm(false, true),
            ));
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        }
        else {
            $fieldset->addField('from_store_id', 'hidden', array(
                'name' => 'from_store_id',
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $fieldset->addField('to_store_id', 'hidden', array(
                'name' => 'to_store_id',
                'value' => Mage::app()->getStore(true)->getId()
            ));
        }

        $fieldset->addField('page', 'select', array(
            'name' => 'page',
            'label' => Mage::helper('core')->__('Copy CMS pages'),
            'title' => Mage::helper('core')->__('Copy CMS page'),
            'required' => true,
            'values'  => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('block', 'select', array(
            'name' => 'block',
            'label' => Mage::helper('core')->__('Copy CMS blocks'),
            'title' => Mage::helper('core')->__('Copy CMS blocks'),
            'required' => true,
            'values'  => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $form->setAction($this->getUrl('*/*/copy'));
        $form->setUseContainer(true);
        $this->setForm($form);

        Mage::dispatchEvent('adminhtml_store_edit_form_prepare_form', array('block' => $this));

        return parent::_prepareForm();
    }
}
