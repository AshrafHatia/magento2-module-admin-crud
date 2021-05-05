<?php

declare(strict_types=1);

namespace Ashraf\Crud\Controller\Adminhtml\Item;

use Ashraf\Crud\Controller\Adminhtml\Action;

class Grid extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        return $resultLayout;
    }
}
