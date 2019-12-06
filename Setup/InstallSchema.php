<?php declare(strict_types=1);

namespace Snowdog\ProductAttributeDescription\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Snowdog\ProductAttributeDescription\Model\ProductAttributeDescriptionManager;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ): void {
        $setup->startSetup();
        $this->addDescriptionToCatalogEavAttributeTable($setup);
        $setup->endSetup();
    }

    private function addDescriptionToCatalogEavAttributeTable(
        SchemaSetupInterface $setup
    ): void {
        $connection = $setup->getConnection();
        $connection->addColumn(
            $connection->getTableName('catalog_eav_attribute'),
            ProductAttributeDescriptionManager::ATTRIBUTE_DESCRIPTION_CODE,
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Attribute Description'
            ]
        );
    }
}
