<?php

namespace Botta\CigarCatalog\Block;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Class Index
 *
 * @author Arisbel
 */
class Index extends \Magento\Framework\View\Element\Template
{
    protected $dataPersistor;
    protected $formValues;
    protected $collectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Botta\CigarCatalog\Model\ResourceModel\CigarCatalogContent\CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->collectionFactory = $collectionFactory;
    }

    public function getStates()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $states = $objectManager->create('Magento\Directory\Model\RegionFactory')
            ->create()->getCollection()->addFieldToFilter('country_id','US')->setOrder('default_name');

        return $states;
    }

    public function getCatalogImageUrl()
    {
        $collection = $this->collectionFactory->create();
        $record = $collection->getFirstItem();

        $imagePath = $record->getImage();
        $store = $this->_storeManager->getStore();
        $mediaUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $imagePath ? sprintf('%scigarcatalog%s', $mediaUrl, $imagePath) : $this->getViewFileUrl('Botta_CigarCatalog::images/catalog-online.png');
    }

    public function getFormAction()
    {
        return $this->getUrl('*/*/subscribe');
    }

    public function getFormValue($name)
    {
        if (null === $this->formValues) {
            $formId = 'request_online_catalog_form';
            $values = $this->getDataPersistor()->get($formId);
            $this->getDataPersistor()->clear($formId);

            $this->formValues = isset($values['subscribe']) ? $values['subscribe'] : [];
        }

        return isset($this->formValues[$name]) ? $this->formValues[$name] : null;
    }

    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__("Download Mike's Cigars Interactive Catalog for the Best Cigars Online"));

        return parent::_prepareLayout();
    }

    /**
     * @return DataPersistorInterface
     */
    private function getDataPersistor()
    {
        if ($this->dataPersistor === null) {
            $this->dataPersistor = ObjectManager::getInstance()
                ->get(DataPersistorInterface::class);
        }

        return $this->dataPersistor;
    }
}
