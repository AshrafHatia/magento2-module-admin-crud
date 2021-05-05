<?php

namespace Ashraf\Crud\Block\Adminhtml\Item;

use Ashraf\Crud\Model\Status;
use Magento\Backend\Block\Widget\Grid\Extended;

class Grid extends Extended
{
    /**
     * item collection factory.
     *
     * @var \Ashraf\Crud\Model\ResourceModel\Item\CollectionFactory
     */
    protected $_itemCollectionFactory;
    /**
     * construct.
     *
     * @param \Magento\Backend\Block\Template\Context                         $context
     * @param \Magento\Backend\Helper\Data                                    $backendHelper
     * @param \Ashraf\Crud\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Ashraf\Crud\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory,
        array $data = []
    ) {
        $this->_itemCollectionFactory = $itemCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }
    protected function _construct()
    {
        parent::_construct();
        $this->setId('itemGrid');
        $this->setDefaultSort('item_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        $store = $this->getRequest()->getParam('store');
        $collection = $this->_itemCollectionFactory->create();
        if ($store) {
            $collection->addFieldToFilter('stores', [['finset' => 0], ['finset' => $store]]);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'item_id',
            [
                'header' => __('Item ID'),
                'type' => 'number',
                'index' => 'item_id',
                'width' => '10px',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'type' => 'text',
                'index' => 'title',
                'width' => '40px',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name',
            ]
        );
        $this->addColumn(
            'urlkey',
            [
                'header' => __('URL key'),
                'type' => 'text',
                'index' => 'urlkey',
                'width' => '30px',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name',
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'class' => 'img',
                'width' => '50px',
                'filter' => false,
                'renderer' => 'Ashraf\Crud\Block\Adminhtml\Helper\Renderer\Grid\Image',
            ]
        );
        if (!$this->_storeManager->isSingleStoreMode()) {
            $this->addColumn(
                'stores',
                [
                    'header' => __('Store View'),
                    'index' => 'stores',
                    'type' => 'store',
                    'store_all' => false,
                    'store_view' => true,
                    'sortable' => false,
                    'filter_condition_callback' => [$this, '_filterStoreCondition']
                ]
            );
        }
        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => Status::getAvailableStatuses(),
            ]
        );
        $this->addColumn(
            'edit',
            [
                'header' => __('Action'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'item_id',
                    ],
                    [
                        'caption' => __('Delete'),
                        'url' => ['base' => '*/*/delete'],
                        'field' => 'item_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );
        $this->addExportType('*/*/exportCsv', __('CSV'));
        return parent::_prepareColumns();
    }
    /**
     * get item vailable option
     *
     * @return array
     */
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('item_id');
        $this->getMassactionBlock()->setFormFieldName('item');
        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('magecrud/*/massDelete'),
                'confirm' => __('Are you sure you want to Delete?'),
            ]
        );
        $statuses = Status::getAvailableStatuses();
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('magecrud/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses,
                    ],
                ],
            ]
        );
        return $this;
    }
    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/edit',
            ['item_id' => $row->getId()]
        );
    }
}
