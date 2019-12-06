<?php declare(strict_types=1);

namespace Snowdog\ProductAttributeDescription\Block\Adminhtml\Catalog\Product\Attribute\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Catalog\Api\Data\EavAttributeInterface;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Framework\DataObject;
use Magento\Framework\Data\Form\AbstractForm;
use Magento\Backend\Block\Widget\Form;
use Snowdog\ProductAttributeDescription\Model\ProductAttributeDescriptionManager;

class Description extends Generic implements TabInterface
{
    const TAB_LABEL = 'Attribute Description';
    const ATTRIBUTE_DESCRIPTION_FIELDSET = 'snowproductattributedescription_description_fieldset';

    /**
     * @var null|EavAttributeInterface
     */
    private $attribute = null;

    /**
     * @var Config
     */
    private $wysiwygConfig;

    public function __construct(
        Config $wysiwygConfig,
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        $this->wysiwygConfig = $wysiwygConfig;

        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $data
        );
    }

    /**
     * @inheritdoc
     */
    public function getTabLabel(): string
    {
        return self::TAB_LABEL;
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle(): string
    {
        return self::TAB_LABEL;
    }

    /**
     * @inheritdoc
     */
    public function canShowTab(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isHidden(): bool
    {
        return false;
    }

    protected function _prepareForm(): Form
    {
        $form = $this->getCreatedForm();

        $fieldSet = $form->addFieldset(self::ATTRIBUTE_DESCRIPTION_FIELDSET, [
            'legend' => __('Attribute Description'),
        ]);

        $fieldSet->addField(
            ProductAttributeDescriptionManager::ATTRIBUTE_DESCRIPTION_CODE,
            'editor',
            [
                'label' => __('Description'),
                'name' => ProductAttributeDescriptionManager::ATTRIBUTE_DESCRIPTION_CODE,
                'config' => $this->getWysiwygConfig(),
                'value' => $this->getAttributeObject()
                    ->getData(ProductAttributeDescriptionManager::ATTRIBUTE_DESCRIPTION_CODE)
            ]
        );

        return parent::_prepareForm();
    }

    private function getCreatedForm(): AbstractForm
    {
        $transport = new DataObject([
            'form' => $this->_formFactory->create([
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ])
        ]);

        $form = $transport->getForm();
        $this->setForm($form);

        return $form;
    }

    private function getAttributeObject():? EavAttributeInterface
    {
        if (null === $this->attribute) {
            $this->attribute = $this->_coreRegistry->registry('entity_attribute');
        }

        return $this->attribute;
    }

    private function getWysiwygConfig(): DataObject
    {
        $config['add_variables'] = false;
        $config['add_widgets'] = false;
        $config['add_directives'] = false;

        return $this->wysiwygConfig->getConfig($config);
    }
}
