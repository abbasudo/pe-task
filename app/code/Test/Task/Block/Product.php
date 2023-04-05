<?php

namespace Test\Task\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Test\Task\Helper\Data;

class Product extends Template
{
    /**
     * @var Data
     */
    public $helper;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $storeManager;
    /**
     * @var \Magento\Framework\View\Element\BlockFactory
     */
    public $blockFactory;
    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    public $appEmulation;

    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;


    /**
     * Product constructor.
     *
     * @param  Context  $context
     * @param  Data  $helper
     * @param  CollectionFactory  $productCollectionFactory
     * @param  array  $data
     */
    public function __construct(

        Context $context,
        Data $helper,
        CollectionFactory $productCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Element\BlockFactory $blockFactory,
        \Magento\Store\Model\App\Emulation $appEmulation,
        array $data = []
    ) {
        $this->helper                   = $helper;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
        $this->blockFactory = $blockFactory;
        $this->appEmulation = $appEmulation;
    }

    /**
     * Get product
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getProduct()
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->getSelect()->orderRand();
        $productCollection->setPageSize(1);

        return $productCollection->getFirstItem();
    }

    /**
     * @param $product
     * @param  string  $imageType
     *
     * @return mixed
     */
    public function getImageUrl($product, string $imageType)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        $imageBlock   = $this->blockFactory->createBlock('Magento\Catalog\Block\Product\ListProduct');
        $productImage = $imageBlock->getImage($product, $imageType);
        $imageUrl     = $productImage->getImageUrl();
        $this->appEmulation->stopEnvironmentEmulation();

        return $imageUrl;
    }

    /**
     * Get buy button url
     *
     * @return string
     */
    public function getBuyUrl()
    {
        if ($this->helper->isRedirectToCheckout()) {
            return $this->_urlBuilder->getUrl('checkout/index/index');
        }

        return $this->getProduct()->getProductUrl();
    }

    /**
     * Get the template for the block
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'Test_Task::product.phtml';
    }

    /**
     * This function will be used to get the css/js file.
     *
     * @param string $asset
     * @return string
     */
    public function getAssetUrl($asset)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $assetRepository = $objectManager->get('Magento\Framework\View\Asset\Repository');
        return $assetRepository->createAsset($asset)->getUrl();
    }
}
