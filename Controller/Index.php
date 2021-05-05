<?php

declare(strict_types=1);

namespace Ashraf\Crud\Controller;

use Magento\Framework\App\Action\Action;

abstract class Index extends Action
{
    /**
     * Crud Itemfactory.
     *
     * @var \Ashraf\Crud\\Model\ItemFactory
     */
    protected $_itemFactory;
    protected $_resultPageFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context                                $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
}
