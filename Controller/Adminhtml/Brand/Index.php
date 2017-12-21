<?php

namespace Test\Brands\Controller\Adminhtml\Brand;

use Test\Brands\Controller\Adminhtml\AbstractBrand;

class Index extends AbstractBrand
{
    /**
     * Brands list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /**
         * @var \Magento\Backend\Model\View\Result\Page $resultPage
         */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Test_Brands::brands');
        $resultPage->getConfig()->getTitle()->prepend(__('Brands'));
        $resultPage->addBreadcrumb(__('Test'), __('Test'));
        $resultPage->addBreadcrumb(__('Brands'), __('Brands'));

        return $resultPage;
    }
}
