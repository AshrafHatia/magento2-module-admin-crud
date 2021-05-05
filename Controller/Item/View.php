<?php

declare(strict_types=1);

namespace Ashraf\Crud\Controller\Item;

use Magento\Framework\App\Action\Action;

class View extends Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
