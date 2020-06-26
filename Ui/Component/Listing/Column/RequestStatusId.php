<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/26/2018
 * Time: 6:44 PM
 */

namespace Botta\CigarCatalog\Ui\Component\Listing\Column;


use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class RequestStatusId extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $statusCollectionFactory;

    /**
     * @var \Botta\CigarCatalog\Model\SubscriptionStatus[]
     */
    protected $statuses;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Botta\CigarCatalog\Model\ResourceModel\SubscriptionStatus\CollectionFactory $collectionFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->statusCollectionFactory = $collectionFactory;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['request_status_id'])) {
                    $item['request_status_id'] = $this->getStatusName($item['request_status_id']);
                }
            }
        }

        return $dataSource;
    }


    protected function getStatuses()
    {
        if (null !== $this->statuses) {
            return $this->statuses;
        }

        /** @var \Botta\CigarCatalog\Model\ResourceModel\SubscriptionStatus\Collection $collection */
        $collection = $this->statusCollectionFactory->create();

        $this->statuses = $collection->getItems();

        return $this->statuses;
    }

    protected function getStatusName($id)
    {
        foreach ($this->getStatuses() as $status) {
            if ($status->getId() == $id) {
                return $status->getName();
            }
        }

        return '';
    }
}