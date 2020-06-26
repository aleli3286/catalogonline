<?php

namespace Botta\CigarCatalog\Model\ResourceModel\Subscription;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Botta\CigarCatalog\Model\Subscription::class,
            \Botta\CigarCatalog\Model\ResourceModel\Subscription::class
        );
    }
}