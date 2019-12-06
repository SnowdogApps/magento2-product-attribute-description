<?php declare(strict_types=1);

namespace Snowdog\ProductAttributeDescription\Model;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Api\Data\AttributeInterface;
use Snowdog\ProductAttributeDescription\Api\ProductAttributeDescriptionManagerInterface;

class ProductAttributeDescriptionManager implements ProductAttributeDescriptionManagerInterface
{
    const ATTRIBUTE_DESCRIPTION_CODE = 'snowproductattributedescription_description';

    /**
     * @var Attribute
     */
    private $eavAttribute;

    public function __construct(Attribute $eavAttribute)
    {
        $this->eavAttribute = $eavAttribute;
    }

    /**
     * @inheritdoc
     */
    public function getDescription(string $attributeCode):? string
    {
        $attribute = $this->getAttributeByCode($attributeCode);

        if (!$attribute) {
            return null;
        }

        return $attribute->getData(self::ATTRIBUTE_DESCRIPTION_CODE);
    }

    private function getAttributeByCode(string $code):? AttributeInterface
    {
        try {
            return $this->eavAttribute->loadByCode(Product::ENTITY, $code);
        } catch (\Exception $e) {
            return null;
        }
    }
}
