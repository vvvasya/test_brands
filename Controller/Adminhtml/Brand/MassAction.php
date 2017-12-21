<?php

namespace Test\Brands\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Test\Brands\Controller\Adminhtml\AbstractBrand as BrandAbstractAction;

abstract class MassAction extends BrandAbstractAction
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var string
     */
    protected $_successMessage;

    /**
     * @var string
     */
    protected $_errorMessage;

    /**
     * MassAction constructor.
     * @param PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param Context $context
     * @param \Test\Brands\Api\Data\BrandInterfaceFactory $brandFactory
     * @param \Test\Brands\Api\BrandRepositoryInterface $brandRepository
     * @param Filter $filter
     * @param $successMessage
     * @param $errorMessage
     */
    public function __construct(
        PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        Context $context,
        \Test\Brands\Api\Data\BrandInterfaceFactory $brandFactory,
        \Test\Brands\Api\BrandRepositoryInterface $brandRepository,
        Filter $filter,
        $successMessage,
        $errorMessage
    )
    {
        $this->_filter            = $filter;
        $this->_successMessage    = $successMessage;
        $this->_errorMessage      = $errorMessage;
        parent::__construct($resultPageFactory, $resultJsonFactory, $context, $brandFactory, $brandRepository);
    }

    /**
     * @param \Test\Brands\Api\Data\BrandInterface $brand
     * @return mixed
     */
    protected abstract function massAction(\Test\Brands\Api\Data\BrandInterface $brand);

    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->_filter->getCollection(
                $this->_brandFactory
                    ->create()
                    ->getCollection()
            );
            $collectionSize = $collection->getSize();
            foreach ($collection as $model) {
                $this->massAction($model);
            }
            $this->messageManager->addSuccessMessage(__($this->_successMessage, $collectionSize));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __($this->_errorMessage));
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('brands/brand/index');
        return $redirectResult;
    }
}
