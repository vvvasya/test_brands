<?php

namespace Test\Brands\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Test\Brands\Api\Data\BrandInterface;

class BrandRepository implements \Test\Brands\Api\BrandRepositoryInterface
{
    /**
     * @var BrandInterface[]
     */
    protected $_instances = [];

    /**
     * @var BrandFactory
     */
    protected $_brandFactory;

    /**
     * @var ResourceModel\Brand
     */
    protected $_brandResource;

    /**
     * @var ResourceModel\Brand\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $_collectionProcessor;

    /**
     * @var \Test\Brands\Api\Data\BrandSearchResultsInterfaceFactory
     */
    protected $_searchResultsFactory;

    public function __construct(
        \Test\Brands\Model\BrandFactory $brandFactory,
        \Test\Brands\Model\ResourceModel\Brand $brandResource,
        \Test\Brands\Model\ResourceModel\Brand\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor = null,
        \Test\Brands\Api\Data\BrandSearchResultsInterfaceFactory $searchResultsFactory
    )
    {
        $this->_brandFactory = $brandFactory;
        $this->_brandResource = $brandResource;
        $this->_collectionFactory = $collectionFactory;
        $this->_collectionProcessor = $collectionProcessor;
        $this->_searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param BrandInterface $brand
     * @return BrandInterface
     */
    public function save(\Test\Brands\Api\Data\BrandInterface $brand)
    {
        $this->_brandResource->save($brand);
        unset($this->_instances[$brand->getId()]);
        return $this->getById($brand->getId());
    }

    /**
     * @param $brandId
     * @return BrandInterface
     * @throws NoSuchEntityException
     */
    public function getById($brandId)
    {
        if (empty($this->_instances[$brandId])) {
            $brand = $this->_brandFactory->create()->load($brandId);
            if (!$brand->getId()) {
                throw NoSuchEntityException::singleField('id', $brandId);
            }
            $this->_instances[$brandId] = $brand;
        }
        return $this->_instances[$brandId];
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Catalog\Api\Data\BrandSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Test\Brands\Model\ResourceModel\Brand\Collection $collection */
        $collection = $this->_collectionFactory->create();

        $this->_collectionProcessor->process($searchCriteria, $collection);

        $collection->load();

        $searchResult = $this->_searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

    /**
     * @param BrandInterface $brand
     * @return bool
     * @throws StateException
     */
    public function delete(\Test\Brands\Api\Data\BrandInterface $brand)
    {

        try {
            $this->_brandResource->delete($brand);
        } catch (\Exception $e) {
            throw new StateException(
                __(
                    'Cannot delete brand with id %1',
                    $brand->getId()
                ),
                $e
            );
        }
        unset($this->instances[$brand->getId()]);
        return true;
    }

    /**
     * @param $brandId
     * @return bool
     * @throws StateException
     */
    public function deleteById($brandId)
    {
        $this->delete($this->getById($brandId));
        return true;
    }

}