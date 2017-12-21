<?php

namespace Test\Brands\Model\ResourceModel\Brand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Test\Brands\Model;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(Model\Brand::class , Model\ResourceModel\Brand::class);
    }

}

