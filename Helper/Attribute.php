<?php

declare(strict_types=1);

namespace Snowdog\ProductAttributeDescription\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Snowdog\ProductAttributeDescription\Model\ProductAttributeDescriptionManager;

class Attribute extends AbstractHelper
{
    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        AttributeRepositoryInterface $attributeRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

        parent::__construct($context);
    }

    public function getAttributesDescriptions(array $attributes): array
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(AttributeInterface::ATTRIBUTE_CODE, $attributes, 'in')
            ->create();

        $data = [];
        $list = $this->attributeRepository->getList(
            Product::ENTITY,
            $searchCriteria
        );

        foreach ($list->getItems() as $attribute) {
            $data[$attribute->getAttributeCode()] = $attribute->getData(
                ProductAttributeDescriptionManager::ATTRIBUTE_DESCRIPTION_CODE
            );
        }

        return $data;
    }
}
