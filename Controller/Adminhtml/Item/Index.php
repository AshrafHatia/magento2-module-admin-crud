<?php

declare(strict_types=1);

namespace Ashraf\Crud\Controller\Adminhtml\Item;

use Ashraf\Crud\Controller\Adminhtml\Action;

class Index extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->_resultForwardFactory->create();
            $resultForward->forward('grid');
            return $resultForward;
        }
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}
