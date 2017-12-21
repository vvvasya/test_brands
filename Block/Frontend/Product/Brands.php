<?php

namespace Test\Brands\Block\Frontend\Product;

use Magento\Framework\View\Element\Template;

class Brands extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Catalog\Api\Data\ProductInterface
     */
    protected $_product;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $_filterBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Test\Brands\Api\BrandRepositoryInterface
     */
    protected $_brandRepository;

    public function __construct(
        Template\Context $context,
        array $data = [],
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Test\Brands\Api\BrandRepositoryInterface $brandRepository
    )
    {
        $this->_brandRepository = $brandRepository;
        $this->_filterBuilder = $filterBuilder;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function getBrands()
    {
        $brands = $this->getProduct()->getBrands();
        $brands = explode(',', $brands);
        $searchCriteria = $this->_searchCriteriaBuilder->addFilters(
            [
                $this->_filterBuilder
                    ->setField('id')
                    ->setConditionType('in')
                    ->setValue($brands)
                    ->create()
            ]
        );

        /** @var \Test\Brands\Api\Data\BrandInterface[] $brandModels */
        $brandModels = $this->_brandRepository->getList($searchCriteria->create())->getItems();

        return $brandModels;
    }


//    public function toHtml()
//    {
//        return 'Hello';
//        $brands = $this->getBrands();
//
//        var_dump($brands);
//        exit;
//
//        // $attrCode will be attribute code, i.e. 'manufacturer'
//        try{
//            /** @var \Magento\Eav\Model\Entity\Attribute\Option[] $options */
//            $options = $this->_productAttributeRepository->get('brands')->getOptions();
//        }catch(\Exception $e){
//            return false;
//        }
//
//        foreach ($options as $option) {
//            echo $option->getLabel() . '<br>';
//        }
//
//        echo get_class($options[0]);
//
//        var_dump($this->getBrands());
//        exit;
//        return 'Hello';
//    }

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface|mixed
     */
    public function getProduct()
    {
        if (is_null($this->_product)) {
            $this->_product = $this->_registry->registry('product');

            if (!$this->_product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->_product;
    }

}