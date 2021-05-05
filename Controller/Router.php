<?php

declare(strict_types=1);

namespace Ashraf\Crud\Controller;

use Ashraf\Crud\Helper\Data;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    protected $actionFactory;
    protected $_itemfactory;
    protected $helper;
    protected $_response;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Ashraf\Crud\Model\ItemFactory $itemFactory,
        Data $helper
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->_itemfactory = $itemFactory;
        $this->helper = $helper;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $router     = $this->helper->getRouter();
        $urlSuffix  = $this->helper->getUrlSuffix();
        if ($length = strlen($urlSuffix)) {
            if (substr($identifier, -$length) == $urlSuffix) {
                $identifier = substr($identifier, 0, strlen($identifier) - $length);
            }
        }
        $routePath = explode('/', $identifier);
        $routeSize = sizeof($routePath);
        if ($identifier == $router) {
            $request->setModuleName('magecrud')
                ->setControllerName('item')
                ->setActionName('listitem')
                ->setPathInfo('/magecrud/item/listitem');
            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
        } elseif ($routeSize == 2 && $routePath[0] == $router) {
            $url_key = $routePath[1];
            $model = $this->_itemfactory->create();
            $model->load($url_key, 'urlkey');
            if (!empty($model->load($url_key, 'urlkey'))) {
                $itemid = $model->load($url_key, 'urlkey')->getData('item_id');
                $request->setModuleName('magecrud')
                    ->setControllerName('item')
                    ->setActionName('view')
                    ->setParam('id', $itemid)
                    ->setPathInfo('/magecrud/item/view');
                return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
            }
        }
    }
}
