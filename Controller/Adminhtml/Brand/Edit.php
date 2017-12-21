<?php

namespace Test\Brands\Controller\Adminhtml\Brand;

use Test\Brands\Controller\Adminhtml\AbstractBrand;

class Edit extends AbstractBrand
{
    /**
     * Edit or create Brand
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $brandId = $this->getRequest()->getParam('id');

        /**
         * @var \Magento\Backend\Model\View\Result\Page $resultPage
         */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Test_Brands::brands');
        $resultPage->getConfig()->getTitle()->prepend(__('Brands'));
        $resultPage->addBreadcrumb(__('Test'), __('Test'));
        $resultPage->addBreadcrumb(__('Brands'), __('Brands'), $this->getUrl('brands/brand'));

        if (empty($brandId)) {
            $resultPage->addBreadcrumb(__('New Brand'), __('New Brand'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Brand'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Brand'), __('Edit Brand'));
            $brand = $this->_brandRepository->getById($brandId);
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Brand: "%1"', $brand->getName()));
        }
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_Brands::update');
    }
}
