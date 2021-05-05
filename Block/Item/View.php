<?php

declare(strict_types=1);

namespace Ashraf\Crud\Block\Item;

use Magento\Framework\App\Filesystem\DirectoryList;
use Ashraf\Crud\Block\Item;
use Magento\Framework\DataObject\IdentityInterface;

class View extends Item
{
    protected $_filterProvider;
    protected $_item;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Ashraf\Crud\Model\ItemFactory $itemFactory,
        \Ashraf\Crud\Helper\Data $helper,
        array $data = []
    ) {
        $this->_filterProvider = $filterProvider;
        parent::__construct($context, $imageFactory, $backendUrl, $itemFactory, $helper, $data);
    }
    protected function _construct()
    {
        parent::_construct();
    }

    protected function _prepareLayout()
    {
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbs->addCrumb('home', [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link'  => $this->_storeManager->getStore()->getBaseUrl()
            ])
                ->addCrumb('item', $this->getBreadcrumbsData());
        }
        if ($catId = $this->getRequest()->getParam('id')) {
            $model = $this->_itemFactory->create();
            $name = $model->load($catId)->getData('title');
            $breadcrumbs->addCrumb($name, [
                'label' => $name,
                'title' => $name
            ]);
        }
        return parent::_prepareLayout();
    }
    /**
     * @return array
     */
    protected function getBreadcrumbsData()
    {
        $data = [
            'label' => 'Item',
            'title' => 'Item'
        ];
        $data['link'] =  $this->_helper->getItemUrl();
        return $data;
    }
    public function getItem()
    {
        if ($this->_item) {
            return $this->_item;
        }
        $itemId = $this->getRequest()->getParam('id');
        if (!$itemId) {
            return;
        }
        $this->_item = $this->_itemFactory->create()->load($itemId);
        return $this->_item;
    }

    public function getShortDescription()
    {
        $item = $this->getItem();
        $shortdescription =  $item->getSrtdesc();
        if ($shortdescription) {
            $storeId = $this->_storeManager->getStore()->getStoreId();
            return $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($shortdescription);
        }
    }

    public function getDescription()
    {
        $item = $this->getItem();
        $description =  $item->getDesc();
        if ($description) {
            $storeId = $this->_storeManager->getStore()->getStoreId();
            return $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($description);
        }
    }
}
