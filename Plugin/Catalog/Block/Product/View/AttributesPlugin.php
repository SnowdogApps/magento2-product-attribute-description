<?php declare(strict_types=1);

namespace Snowdog\ProductAttributeDescription\Plugin\Catalog\Block\Product\View;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\View\Attributes;
use Magento\Framework\Registry;
use Snowdog\ProductAttributeDescription\Model\ProductAttributeDescriptionManager;

class AttributesPlugin
{
    /**
     * @var Registry
     */
    private $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAdditionalData(Attributes $subject, $result): array
    {
        $currentProduct = $this->getCurrentProduct();

        if (!$currentProduct
            || !$productAttributes = $currentProduct->getAttributes()
        ) {
            return $result;
        }

        $result = $this->parseAttributeDescription($productAttributes, $result);

        return $result;
    }

    private function parseAttributeDescription($productAttributes, $data): array
    {
        foreach ($productAttributes as $productAttribute) {
            if (isset($data[$productAttribute->getAttributeCode()])) {
                $data[$productAttribute->getAttributeCode()]['attribute_description'] =
                    $productAttribute->getData(ProductAttributeDescriptionManager::ATTRIBUTE_DESCRIPTION_CODE);
            }
        }

        return $data;
    }

    private function getCurrentProduct():? ProductInterface
    {
        return $this->registry->registry('product');
    }
}
