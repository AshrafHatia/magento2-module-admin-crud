<?php

declare(strict_types=1);

namespace Ashraf\Crud\Model\ResourceModel;

class Item extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('cruditems', 'item_id');
    }
}
