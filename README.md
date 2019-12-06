# Snowdog Magento2 Product Attribute Description

The extension allows to set product attributes description through attribute admin edition page

### 1. Installation:

* `composer require snowdog/module-product-attribute-description`
* `bin/magento module:enable Snowdog_ProductAttributeDescription`
* `bin/magento setup:upgrade`

### 2. Usage:

- There will be a new tab "Attribute Description" in product attribute edition page which opens a Wysiwyg editor
- The attribute description can be displayed in product page through attributes property `snowproductattributedescription_description` or `attribute_description`
- Also it can be accessible everywhere through API endpoint:

```
GET /V1/snowproductattributedescription/description/:attributeCode
```

where `:attributeCode` is the attribute code identifier