<?php
namespace Test\Brands\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class UpgradeData implements UpgradeDataInterface
{

    /**
     * @var EavSetupFactory
     */
    protected $_eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->_eavSetupFactory = $eavSetupFactory;
    }


    public function upgrade( ModuleDataSetupInterface $setup, ModuleContextInterface $context ) {

        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.7') < 0) {

            $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

            $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'brands');
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'brands',
                [
                    'type' => 'varchar',
                    'label' => 'Brands',
                    'input' => 'multiselect',
                    'required' => false,
                    'visible' => true,
                    'user_defined' => true,
                    'sort_order' => 1000,
                    'position' => 1000,
                    'system' => 0,
                    'backend' => \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend::class,
                    'source' => \Test\Brands\Model\Entity\Attribute\Source\AllowedBrands::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'searchable' => true,
                    'filterable' => true,
                    'comparable' => true,
                    'visible_on_front' => true,
                    'used_in_product_listing' => true
                ]
            );

            $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $attributeSetIds = $eavSetup->getAllAttributeSetIds($entityTypeId);
            foreach ($attributeSetIds as $attributeSetId) {
                /**
                 * getAttributeGroupId($entityTypeId, $attributeSetId, "Group_Code");
                 *
                 */
                $groupId = $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, "brands");
                $eavSetup->addAttributeToGroup(
                    $entityTypeId,
                    $attributeSetId,
                    $groupId,
                    'brands',
                    null
                );
            }
        }

        $setup->endSetup();
    }
}