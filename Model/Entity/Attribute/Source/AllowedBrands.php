<?php

namespace Test\Brands\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class AllowedBrands extends AbstractSource
{
    /**
     * @var \Test\Brands\Api\Data\BrandInterfaceFactory
     */
    protected $_brandFactory;

    public function __construct(
        \Test\Brands\Api\Data\BrandInterfaceFactory $brandFactory
    )
    {
        $this->_brandFactory = $brandFactory;
    }

    public function getAllOptions()
    {
        if (!isset($this->_options)) {
            $this->_options = [];
            $collection = $this->_brandFactory->create()->getCollection();
            /** @var \Test\Brands\Api\Data\BrandInterface $brand */
            foreach ($collection as $brand) {
                $this->_options[] = [
                    'label' => $brand->getName(),
                    'value' => $brand->getId()
                ];
            }
        }

        return $this->_options;
    }
}