<?php

namespace Test\Brands\Setup;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Config\Model\ResourceModel\Config\Data;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory;
use Magento\Eav\Setup\EavSetupFactory;

class Uninstall implements UninstallInterface
{
    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;
    /**
     * @var Data
     */
    protected $_configResource;

    /**
     * @param CollectionFactory $collectionFactory
     * @param Data $configResource
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Data $configResource,
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->_collectionFactory = $collectionFactory;
        $this->_configResource = $configResource;
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        foreach ([
            \Test\Brands\Model\ResourceModel\Brand::TABLE
        ] as $table) {
            if ($setup->tableExists($table)) {
                $setup->getConnection()->dropTable($table);
            }
        }

        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->removeAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'brands'
        );

//        $collection = $this->_collectionFactory
//            ->create()
//            ->addPathFilter('test_brands');
//        foreach ($collection as $config) {
//            $this->deleteConfig($config);
//        }
    }

    /**
     * @param AbstractModel $config
     * @throws \Exception
     */
    protected function deleteConfig(AbstractModel $config)
    {
        $this->_configResource->delete($config);
    }
}
