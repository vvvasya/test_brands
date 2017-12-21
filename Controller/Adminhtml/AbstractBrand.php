<?php

namespace Test\Brands\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;

abstract class AbstractBrand extends Action
{

    /**
     * @var \Test\Brands\Model\BrandRepository
     */
    protected $_brandRepository;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * @var \Test\Brands\Api\Data\BrandInterfaceFactory
     */
    protected $_brandFactory;

    /**
     * AbstractBrand constructor.
     * @param PageFactory $resultPageFactory
     * @param Context $context
     * @param \Test\Brands\Model\ResourceModel\Brand\CollectionFactory $collectionFactory
     * @param \Test\Brands\Api\BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        Context $context,
        \Test\Brands\Api\Data\BrandInterfaceFactory $brandFactory,
        \Test\Brands\Api\BrandRepositoryInterface $brandRepository
    )
    {
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_brandRepository = $brandRepository;
        $this->_brandFactory = $brandFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_Brands::root');
    }
}
