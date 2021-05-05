<?php

declare(strict_types=1);

namespace Ashraf\Crud\Controller\Adminhtml\Item;

use Ashraf\Crud\Controller\Adminhtml\Action;

class MassStatus extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $itemIds = $this->getRequest()->getParam('item');
        $status = $this->getRequest()->getParam('status');
        $storeViewId = $this->getRequest()->getParam('store');
        if (!is_array($itemIds) || empty($itemIds)) {
            $this->messageManager->addError(__('Please select Item(s).'));
        } else {
            $collection = $this->_itemCollectionFactory->create()
                // ->setStoreViewId($storeViewId)
                ->addFieldToFilter('item_id', ['in' => $itemIds]);
            try {
                foreach ($collection as $item) {
                    $item->setStoreViewId($storeViewId)
                        ->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been changed status.', count($itemIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->_resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/', ['store' => $this->getRequest()->getParam('store')]);
    }
}
