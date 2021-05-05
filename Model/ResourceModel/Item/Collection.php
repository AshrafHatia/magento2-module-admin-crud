<?php

declare(strict_types=1);

namespace Ashraf\Crud\Model\ResourceModel\Item;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Ashraf\Crud\Model\Item', 'Ashraf\Crud\Model\ResourceModel\Item');
    }
}
