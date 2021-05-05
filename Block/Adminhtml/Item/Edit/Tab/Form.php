<?php

namespace Ashraf\Crud\Block\Adminhtml\Item\Edit\Tab;

// use Ashraf\Crud\Model\Status;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Form extends Generic implements TabInterface
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;
    /**
     * @var \Ashraf\Crud\Model\Item
     */
    protected $_item;
    /**
     * @var \Magento\Customer\Ui\Component\Listing\Column\Group\Options
     */
    protected $_groups;
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Ashraf\Crud\Model\Item $item,
        \Magento\Customer\Ui\Component\Listing\Column\Group\Options $groups,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_item = $item;
        $this->_groups = $groups;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    /**
     * prepare layout.
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
        return $this;
    }
    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('item');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('magecrud_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);
        if ($model->getId()) {
            $fieldset->addField('item_id', 'hidden', ['name' => 'item_id']);
        }
        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name'  => 'status',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );
        $fieldset->addField(
            'title',
            'text',
            [
                'label' => __('Title'),
                'title' => __('Title'),
                'name'  => 'title',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'urlkey',
            'text',
            [
                'label' => __('URL key'),
                'title' => __('URL key'),
                'name'  => 'urlkey',
                'required' => true,
                'class' => 'validate-xml-identifier',
                'note' => 'i.e. item1',
            ]
        );
        $fieldset->addField(
            'image',
            'image',
            [
                'label' => __('Item Image'),
                'title' => __('Item Image'),
                'name'  => 'image',
                'required' => true,
                'note' => 'Allow image type: jpg, jpeg, gif, png',
            ]
        );
        $fieldset->addField(
            'srtdesc',
            'editor',
            [
                'name'   => 'srtdesc',
                'label'  => __('Short Description'),
                'title'  => __('Short Description'),
                'rows' => '2',
                'cols' => '30',
                'wysiwyg' => true,
                'config' => $this->_wysiwygConfig->getConfig([
                    'add_variables'  => false,
                    'add_widgets'    => false,
                    'add_directives' => false,
                    'height' => '130px',
                ])
            ]
        );
        $fieldset->addField(
            'desc',
            'editor',
            [
                'name'   => 'desc',
                'label'  => __('Description'),
                'title'  => __('Description'),
                'rows' => '5',
                'cols' => '30',
                'wysiwyg' => true,
                'config' => $this->_wysiwygConfig->getConfig([
                    'add_variables'  => true,
                    'add_widgets'    => true,
                    'add_directives' => true,
                    'height' => '300px',
                ])
            ]
        );
        $fieldset->addField(
            'customergroup',
            'select',
            [
                'label'    => __('Customer Group'),
                'title' => __('Customer Group'),
                'name'     => 'customergroup',
                'required' => true,
                'values'   => $this->_groups->toOptionArray(),
            ]
        );
        /* Check is single store mode */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'stores',
                'select',
                [
                    'name' => 'stores[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, false)
                ]
            );
            $renderer = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'stores',
                'hidden',
                ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
            $model->setStoreId($this->_storeManager->getStore(true)->getId());
        }

        if ($model->getCreatedAt()) {
            $fieldset->addField(
                'created_at',
                'date',
                [
                    'name' => 'created_at',
                    'label' => __('Created At'),
                    'id' => 'created_at',
                    'title' => __('Created At'),
                    'date_format' => 'yyyy-MM-dd',
                    'time_format' => 'hh:mm:ss',
                    'style'   => "width:210px",
                    'readonly' => true
                ]
            );
        }
        if ($model->getUpdatedAt()) {
            $fieldset->addField(
                'updated_at',
                'date',
                [
                    'name' => 'updated_at',
                    'label' => __('Updated At'),
                    'id' => 'updated_at',
                    'title' => __('Updated At'),
                    'date_format' => 'yyyy-MM-dd',
                    'time_format' => 'hh:mm:ss',
                    'style'   => "width:210px",
                    'readonly' => true
                ]
            );
        }

        $form->addValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->_coreRegistry->registry('item');
    }
    /**
     * @return \Magento\Framework\Phrase
     */
    public function getPageTitle()
    {
        return $this->getItem()->getId()
            ? __("Edit Item '%1'", $this->escapeHtml($this->getItem()->getTitle())) : __('New Item');
    }
    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Item Information');
    }
    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
