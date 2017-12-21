<?php

namespace Test\Brands\Controller\Adminhtml\Brand;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\Brands\Controller\Adminhtml\AbstractBrand;

class Delete extends AbstractBrand
{

    public function execute()
    {
        $isAjax = $this->getRequest()->getParam('isAjax') ? true : false;
        if ($isAjax) {
            /** @var \Magento\Framework\Controller\Result\Json $resultJson */
            $resultJson = $this->_resultJsonFactory->create();
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
        }
        $brandId = $this->getRequest()->getParam('id');
        if ($brandId) {
            try {
                $this->_brandRepository->deleteById($brandId);

                if ($isAjax) {
                    return $resultJson->setData([
                        'messages' => __('You have deleted the brand'),
                        'error' => false
                    ]);
                }

                $this->messageManager->addSuccessMessage(__('The brand has been deleted.'));
                $resultRedirect->setPath('brands/*/');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $message = __('The brand no longer exists.');
                if ($isAjax) {
                    return $resultJson->setData([
                        'messages' => $message,
                        'error' => false
                    ]);
                }
                $this->messageManager->addErrorMessage($message);
                return $resultRedirect->setPath('brands/*/');
            } catch (LocalizedException $e) {
                $message = $e->getMessage();
                if ($isAjax) {
                    return $resultJson->setData([
                        'messages' => $message,
                        'error' => false
                    ]);
                }
                $this->messageManager->addErrorMessage($message);
                return $resultRedirect->setPath('brands/brand/edit', ['id' => $brandId]);
            } catch (\Exception $e) {
                $message = __('There was a problem deleting the brand');
                if ($isAjax) {
                    return $resultJson->setData([
                        'messages' => $message,
                        'error' => false
                    ]);
                }
                $this->messageManager->addErrorMessage($message);
                return $resultRedirect->setPath('brands/brand/edit', ['id' => $brandId]);
            }
        }
        $message = __('We can\'t find a brand to delete.');
        if ($isAjax) {
            return $resultJson->setData([
                'messages' => $message,
                'error' => false
            ]);
        }
        $this->messageManager->addErrorMessage($message);
        $resultRedirect->setPath('brands/*/');
        return $resultRedirect;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_Brands::delete');
    }
}
