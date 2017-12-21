<?php

namespace Test\Brands\Api\Data;

/**
 * @api
 */
interface BrandSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get brands list.
     *
     * @return \Test\Brands\Api\Data\BrandInterface[]
     */
    public function getItems();

    /**
     * Set brands list.
     *
     * @param \Test\Brands\Api\Data\BrandInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
