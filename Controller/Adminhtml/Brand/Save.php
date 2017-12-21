<?php

namespace Test\Brands\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\View\Result\PageFactory;
use Test\Brands\Controller\Adminhtml\AbstractBrand;
use Test\Brands\Model;

class Save extends AbstractBrand
{
    /**
     * @var DataObjectProcessor
     */
    protected $_dataObjectProcessor;

    /**
     * @var DataObjectHelper
     */
    protected $_dataObjectHelper;

    /**
     * Save constructor.
     * @param PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param Context $context
     * @param \Test\Brands\Api\Data\BrandInterfaceFactory $brandFactory
     * @param \Test\Brands\Api\BrandRepositoryInterface $brandRepository
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        Context $context,
        \Test\Brands\Api\Data\BrandInterfaceFactory $brandFactory,
        \Test\Brands\Api\BrandRepositoryInterface $brandRepository,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper
    )
    {
        $this->_dataObjectProcessor = $dataObjectProcessor;
        $this->_dataObjectHelper = $dataObjectHelper;
        parent::__construct($resultPageFactory, $resultJsonFactory, $context, $brandFactory, $brandRepository);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $isAjax = $this->getRequest()->getParam('isAjax') ? true : false;
        if ($isAjax) {
            /** @var \Magento\Framework\Controller\Result\Json $resultJson */
            $resultJson = $this->_resultJsonFactory->create();
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
        }

        $data = $this->getRequest()->getPostValue();

        $id = $this->getRequest()->getParam('id');

        try {
            if (!empty($id)) {
                $brand = $this->_brandRepository->getById($id);
            } else {
                $brand = $this->_brandFactory->create();
                unset($data['id']);
            }

            $brand->addData($data);
            $brand = $this->_brandRepository->save($brand);

            if ($isAjax) {
                return $resultJson->setData([
                    'messages' => __('You saved the brand'),
                    'error' => false
                ]);
            }

            $this->messageManager->addSuccessMessage(__('You saved the brand'));
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('*/*/edit', ['id' => $brand->getId()]);
            } else {
                $resultRedirect->setPath('*/*/index');
            }
        } catch (LocalizedException $e) {
            if ($isAjax) {
                return $resultJson->setData([
                    'messages' => $e->getMessage(),
                    'error' => true
                ]);
            }
            $this->messageManager->addErrorMessage($e->getMessage());
            if (isset($brand) && !$brand->getId()) {
                $this->storeBrandDataToSession(
                    $this->_dataObjectProcessor->buildOutputDataArray(
                        $brand,
                        Model\Brand::class
                    )
                );
            }
            $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        } catch (\Exception $e) {

            if ($isAjax) {
                return $resultJson->setData([
                    'messages' => $e->getMessage(),
                    'error' => true
                ]);
            }
            $this->messageManager->addErrorMessage(__('There was a problem saving the brand'));
            if (isset($brand) && !$brand->getId()) {
                $this->storeBrandDataToSession(
                    $this->_dataObjectProcessor->buildOutputDataArray(
                        $brand,
                        Model\Brand::class
                    )
                );
            }
            $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        return $resultRedirect;
    }

    /**
     * @param $brandModelData
     */
    protected function storeBrandDataToSession($brandModelData)
    {
        $this->_getSession()->setTestBrandsBrandData($brandModelData);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_Brands::update');
    }
}
