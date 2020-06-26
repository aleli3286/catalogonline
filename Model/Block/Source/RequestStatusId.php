<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/26/2018
 * Time: 7:14 PM
 */

namespace Botta\CigarCatalog\Model\Block\Source;

use Magento\Framework\Data\OptionSourceInterface;

class RequestStatusId implements OptionSourceInterface
{
    public function __construct(
        \Botta\CigarCatalog\Model\ResourceModel\SubscriptionStatus\CollectionFactory $collectionFactory
    )
    {
        $this->collection = $collectionFactory->create();
    }

    public function toOptionArray()
    {
        $options = [];

        foreach ($this->collection as $item) {
            $options[] = [
                'value' => $item->getId(),
                'label' => $item->getName()
            ];
        }

        return $options;
    }
}