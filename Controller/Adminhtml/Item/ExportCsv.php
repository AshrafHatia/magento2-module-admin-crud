<?php

declare(strict_types=1);

namespace Ashraf\Crud\Controller\Adminhtml\Item;

use Magento\Framework\App\Filesystem\DirectoryList;
use Ashraf\Crud\Controller\Adminhtml\Action;

class ExportCsv extends Action
{
    public function execute()
    {
        $fileName = 'items.csv';
        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Ashraf\Crud\Block\Adminhtml\Item\Grid')->getCsv();
        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
