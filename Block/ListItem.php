<?php

declare(strict_types=1);

namespace Ashraf\Crud\Block;

use Magento\Framework\App\Filesystem\DirectoryList;

class ListItem extends Item
{
    protected function _construct()
    {
        parent::_construct();
    }

    protected function _prepareLayout()
    {

        parent::_prepareLayout();

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

        if ($this->getItems()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'magecrud.items.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15])->setShowPerPage(true)->setCollection(
                $this->getItems()
            );
            $this->setChild('pager', $pager);
            $this->getItems()->load();
        }
        return $this;
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
    public function getItems()
    {
        // $customerGroup = $this->_customerSession->getCustomer()->getGroupId();
        $store = $this->_storeManager->getStore()->getId();
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->_itemFactory->create()->getCollection();
        $collection->addFieldToFilter('status', 1);
        $collection->addFieldToFilter('stores', $store);
        // $collection->addFieldToFilter('customergroup', 0);
        $collection->setOrder('title', 'ASC');
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getItem()
    {
        $itemId = $this->getRequest()->getParam('id');
        if (!$itemId) {
            return;
        }
        return $this->_itemFactory->create()->load($itemId);
    }
}
