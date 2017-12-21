<?php

namespace Test\Brands\Model;

use Magento\Framework\Model\AbstractModel;
use Test\Brands\Model\ResourceModel;

class Brand extends AbstractModel implements \Test\Brands\Api\Data\BrandInterface
{
    /**
     * cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'test_brands_brand';

    /**
     * cache tag
     *
     * @var string
     */
    protected $_cacheTag = 'test_brands_brand';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'test_brands_brand';

    protected function _construct()
    {
        $this->_init(ResourceModel\Brand::class);
    }

    /**
     * @return string
     */
    function getId()
    {
        return $this->getData(self::COLUMN_ID);
    }

    /**
     * @param $id
     * @return $this
     */
    function setId($id)
    {
        return $this->setData(self::COLUMN_ID, $id);
    }

    /**
     * @return string
     */
    function getName()
    {
        return $this->getData(self::COLUMN_NAME);
    }

    /**
     * @param $name
     * @return $this
     */
    function setName($name)
    {
        return $this->setData(self::COLUMN_NAME, $name);
    }

    /**
     * @return string
     */
    function getCreated()
    {
        return $this->getData(self::COLUMN_CREATED);
    }

    /**
     * @param $created
     * @return $this
     */
    function setCreated($created)
    {
        return $this->setData(self::COLUMN_CREATED, $created);
    }

    /**
     * @return string
     */
    function getCountry()
    {
        return $this->getData(self::COLUMN_COUNTRY);
    }

    /**
     * @param $country
     * @return $this
     */
    function setCountry($country)
    {
        return $this->setData(self::COLUMN_COUNTRY, $country);
    }

    /**
     * @return string
     */
    function getDescription()
    {
        return $this->getData(self::COLUMN_DESCRIPTION);
    }

    /**
     * @param $description
     * @return $this
     */
    function setDescription($description)
    {
        return $this->setData(self::COLUMN_DESCRIPTION, $description);
    }

}
