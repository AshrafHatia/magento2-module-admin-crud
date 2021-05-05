<?php

namespace Ashraf\Crud\Block\Adminhtml\Helper\Renderer\Grid;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;

class Image extends AbstractRenderer
{
    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * Item factory.
     *
     * @var \Ashraf\Crud\Model\ItemFactory
     */
    protected $_itemFactory;
    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Context              $context
     * @param \Magento\Store\Model\StoreManagerInterface  $storeManager
     * @param \Magento\Cms\Model\BlockFactory $blockFactory
     * @param array                                       $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Ashraf\Crud\Model\ItemFactory $itemFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->_itemFactory  = $itemFactory;
    }
    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $storeViewId = $this->getRequest()->getParam('store');
        $item = $this->_itemFactory->create()->setStoreViewId($storeViewId)->load($row->getId());
        $srcImage = $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . $item->getImage();
        return '<image width="150" height="50" src ="' . $srcImage . '" alt="' . $item->getImage() . '" >';
    }
}
