<?php

namespace Test\Brands\Model\ResourceModel;

class Brand extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const TABLE = 'test_brands_brand';

    protected function _construct()
    {
        $this->_init(self::TABLE, 'id');
    }
}
