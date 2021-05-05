<?php

declare(strict_types=1);

namespace Ashraf\Crud\Block;

use Magento\Framework\View\Element\Template;

class Item extends Template
{
    public $_helper;
    protected $_imageFactory;
    protected $_items = array();
    protected $_itemFactory;
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $backendUrl;

    /**
     * @var \Ashraf\Crud\Model\ResourceModel\Item\Collection
     */
    protected $_itemCollection;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Ashraf\Crud\Model\ItemFactory $itemFactory,
        \Ashraf\Crud\Helper\Data $helper,
        array $data = []
    ) {
        $this->_imageFactory = $imageFactory;
        $this->backendUrl = $backendUrl;
        $this->_itemFactory = $itemFactory;
        $this->_helper = $helper;
        parent::__construct($context, $data);
    }
    public function getItemCollection()
    {
        // $customerGroup = $this->_customerSession->getCustomer()->getGroupId();
        if (!$this->_itemCollection) {
            $store = $this->_storeManager->getStore()->getStoreId();
            $collection = $this->_itemFactory->create()->getCollection()
                ->addFieldToFilter('stores', [['finset' => 0], ['finset' => $store]])
                ->addFieldToFilter('status', 1);
            $this->_itemCollection = $collection;
        }
        return $this->_itemCollection;
    }
    public function getImage($item)
    {
        $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $item->getImage();
        return $resizedURL;
    }
}
