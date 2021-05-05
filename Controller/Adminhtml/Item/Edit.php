<?php

declare(strict_types=1);

namespace Ashraf\Crud\Controller\Adminhtml\Item;

use Ashraf\Crud\Controller\Adminhtml\Action;

class Edit extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('item_id');
        $storeViewId = $this->getRequest()->getParam('store');
        $model = $this->_itemFactory->create();
        if ($id) {
            $model->setStoreViewId($storeViewId)->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Item no longer exists.'));
                $resultRedirect = $this->_resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('item', $model);
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}
