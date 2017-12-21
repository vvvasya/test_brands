<?php

namespace Test\Brands\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Test\Brands\Controller\Adminhtml\AbstractBrand;

class InlineEdit extends AbstractBrand
{

    /**
     * @var JsonFactory
     */
    protected $_jsonFactory;

    /**
     * InlineEdit constructor.
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     * @param Context $context
     * @param \Test\Brands\Api\Data\BrandInterfaceFactory $brandFactory
     * @param \Test\Brands\Api\BrandRepositoryInterface $brandRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        Context $context,
        \Test\Brands\Api\Data\BrandInterfaceFactory $brandFactory,
        \Test\Brands\Api\BrandRepositoryInterface $brandRepository,
        JsonFactory $jsonFactory
    )
    {
        $this->_jsonFactory = $jsonFactory;
        parent::__construct($resultPageFactory, $resultJsonFactory, $context, $brandFactory, $brandRepository);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);

        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error'    => true,
            ]);
        }

        foreach ($postItems as $brandId => $brandData) {
            try {

                $brand = $this->_brandFactory
                    ->create()
                    ->setData($brandData);
                $this->_brandRepository->save($brand);
            } catch (LocalizedException $e) {
                $messages[] = $this->_getError($brand, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->_getError($brand, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->_getError(
                    $brand,
                    __('Something went wrong while saving the brand.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error'    => $error,
        ]);
    }

    /**
     * @param \Test\Brands\Api\Data\BrandInterface $brand
     * @param $errorText
     * @return string
     */
    protected function _getError(\Test\Brands\Api\Data\BrandInterface $brand, $errorText)
    {
        return '[Brand ID: ' . $brand->getId() . '] ' . $errorText;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_Brands::update');
    }
}
