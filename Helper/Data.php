<?php

declare(strict_types=1);

namespace Ashraf\Crud\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * @var array
     */
    protected $configModule;
    /**
     * @var string
     */
    protected $_urlMedia;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $_storeManager;
    /**
     * ScopeConfigInterface scopeConfig
     *
     * @var scopeConfig
     */
    protected $scopeConfig;
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }
    public function getRouter()
    {
        return 'magecrud';
    }
    public function getUrlSuffix()
    {
        return '.html';
    }
    public function getRoutes()
    {
        return $this->getRouter() . $this->getUrlSuffix();
    }
    public function getUrlRouter()
    {
        return $this->_storeManager->getStore()->getBaseUrl() . $this->getRouter();
    }
    public function getUrlKey($key = '', $suffix = true)
    {
        $key = trim($key, '/');
        if ($key) {
            $key =  '/' . $key;
        }
        if ($suffix) {
            $key  = $key . $this->getUrlSuffix();
        }
        return $this->getRouter() . $key;
    }
    public function getItemUrl($key = '', $suffix = true)
    {
        return $this->_storeManager->getStore()->getBaseUrl() . $this->getUrlKey($key, $suffix);
    }
    public function getLinkItem($item)
    {
        $baseUrl  = $this->_storeManager->getStore()->getBaseUrl();
        $key  = $item->getUrlkey();
        $link = $key ? $baseUrl . $this->getUrlKey($key) : '#';
        return $link;
    }
    public function getMediaUrl($image = "")
    {
        if (!$this->_urlMedia) {
            $this->_urlMedia = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        }
        return $this->_urlMedia . $image;
    }
    public function allowExtension()
    {
        return $this->scopeConfig->getValue('crud_config/general/status', ScopeInterface::SCOPE_STORE);
    }
    public function liwth()
    {
        return $this->scopeConfig->getValue('crud_config/list/width', ScopeInterface::SCOPE_STORE);
    }
    public function lihgt()
    {
        return  $this->scopeConfig->getValue('crud_config/list/height', ScopeInterface::SCOPE_STORE);
    }
    public function diwth()
    {
        return $this->scopeConfig->getValue('crud_config/detail/width', ScopeInterface::SCOPE_STORE);
    }
    public function dihgt()
    {
        return $this->scopeConfig->getValue('crud_config/detail/height', ScopeInterface::SCOPE_STORE);
    }
}
