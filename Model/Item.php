<?php

declare(strict_types=1);

namespace Ashraf\Crud\Model;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    /**
     * @var \Ashraf\Crud\Model\ResourceModel\Item\CollectionFactory
     */
    protected $_itemCollectionFactory;
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Ashraf\Crud\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory,
        \Ashraf\Crud\Model\ResourceModel\Item $resource,
        \Ashraf\Crud\Model\ResourceModel\Item\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_itemCollectionFactory = $itemCollectionFactory;
    }
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Ashraf\Crud\Model\ResourceModel\Item');
    }
}
