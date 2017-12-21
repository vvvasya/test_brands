<?php

namespace Test\Brands\Block\Adminhtml\Brand\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

abstract class AbstractButton
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \Test\Brands\Api\BrandRepositoryInterface
     */
    protected $_brandRepository;

    /**
     * @var \Test\Brands\Api\Data\BrandInterface
     */
    protected $_brand;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    /**
     * AbstractButton constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\UrlInterface $url
     * @param \Test\Brands\Api\BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\UrlInterface $url,
        \Test\Brands\Api\BrandRepositoryInterface $brandRepository
    )
    {
        $this->_request = $request;
        $this->_url = $url;
        $this->_brandRepository = $brandRepository;
    }

    /**
     * @return mixed|null
     */
    public function getBrandId()
    {
        try {
            if (empty($this->_brand) || !$this->_brand->getId()) {
                $this->_brand = $this->_brandRepository->getById(
                    $this->_request->getParam('id')
                );
            }

            return $this->_brand->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->_url->getUrl($route, $params);
    }

    /**
     * get button data
     *
     * @return array
     */
    abstract public function getButtonData();
}
