<?php

namespace Test\Brands\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Test\Brands\Model\ResourceModel\Brand\Grid\CollectionFactory;

class Brand extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /** @var \Magento\Framework\App\RequestInterface  */
    protected $_request;

    /**
     * Brand constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $brandCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $brandCollectionFactory,
        \Magento\Framework\App\RequestInterface $request,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $brandCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->_request = $request;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (empty($this->loadedData)) {
            $this->loadedData = [];
            /** @var \Test\Brands\Api\Data\BrandInterface $brand */
            foreach ($this->getCollection() as $brand) {
                $this->loadedData[$brand->getId()] = $brand->getData();
            }
        }

        return $this->loadedData;
    }
}
