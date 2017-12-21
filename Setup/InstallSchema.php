<?php

namespace Test\Brands\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    protected function _createBrandTable(SchemaSetupInterface $setup)
    {
        $tableName = \Test\Brands\Model\ResourceModel\Brand::TABLE;
        if (!$setup->tableExists($tableName)) {
            $table = $setup->getConnection()->newTable($setup->getTable($tableName))
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'brand id'
                )
                ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn(
                    'created',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'created datetime'
                )
                ->addColumn('country', Table::TYPE_TEXT, 3, ['nullable' => false])
                ->addColumn('description', Table::TYPE_TEXT, '64k', ['nullable' => false], 'Brand content')
            ;
            $setup->getConnection()->createTable($table);
        }
    }


    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->_createBrandTable($setup);

        $setup->endSetup();
    }
}
