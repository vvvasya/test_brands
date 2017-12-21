<?php

namespace Test\Brands\Controller\Adminhtml\Brand;

class MassDelete extends MassAction
{
    /**
     * @param \Test\Brands\Api\Data\BrandInterface $brand
     * @return $this
     */
    protected function massAction(\Test\Brands\Api\Data\BrandInterface $brand)
    {
        $this->_brandRepository->delete($brand);
        return $this;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_Brands::delete');
    }
}
