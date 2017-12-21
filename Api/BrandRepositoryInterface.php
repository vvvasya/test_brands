<?php

namespace Test\Brands\Api;

/**
 * @api
 */
interface BrandRepositoryInterface
{
    /**
     * @param \Test\Brands\Api\Data\BrandInterface $brand
     * @return \Test\Brands\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function save(\Test\Brands\Api\Data\BrandInterface $brand);

    /**
     * @param $brandId
     * @return \Test\Brands\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($brandId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Catalog\Api\Data\BrandSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param \Test\Brands\Api\Data\BrandInterface $brand
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Test\Brands\Api\Data\BrandInterface $brand);

    /**
     * @param $brandId
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($brandId);
}