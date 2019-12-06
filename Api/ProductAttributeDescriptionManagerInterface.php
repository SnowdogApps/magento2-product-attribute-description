<?php declare(strict_types=1);

namespace Snowdog\ProductAttributeDescription\Api;

interface ProductAttributeDescriptionManagerInterface
{
    /**
     * @param string $attributeCode
     * @return null|string
     */
    public function getDescription(string $attributeCode):? string;
}
