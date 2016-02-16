<?php
/**
 * Created by PhpStorm.
 * User: j.idziak@macopedia.pl
 * Date: 15.02.16
 * Time: 17:55
 */
class Macopedia_CopyStoreData_Model_Store_Copy
{
    public function copyData($type, $from, $to)
    {
        try {
            $fromCollectionItems = Mage::getModel('cms/' . $type)->getCollection()->addStoreFilter($from, false)->getItems();
            $toCollectionItems = Mage::getModel('cms/' . $type)->getCollection()->addStoreFilter($to, false)->getItems();
            $existingUrKeys = array();
            foreach($toCollectionItems as $item) {
                $existingUrKeys[$item->getIdentifier()] = true;
            }
            foreach ($fromCollectionItems as $item) {
                if (!isset($existingUrKeys[$item->getIdentifier()])) {
                    $itemData = $item->getData();
                    unset($itemData[$type . '_id']);
                    unset($itemData['update_time']);
                    unset($itemData['creation_time']);
                    $itemData['title'] = '[Translate to ' . Mage::getModel('core/store')->load($to)->getName() . '] ' . $itemData['title'];
                    $itemData['stores'] = array($to);
                    Mage::getModel('cms/' . $type)->setData($itemData)->save();
                }
            }
            return false;
        } catch (Exception $e) {
            Mage::logException($e);
            return $e->getMessage();
        }
    }
}
