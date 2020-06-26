<?php

namespace Botta\CigarCatalog\Model\ResourceModel;

class Subscription extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init(
            'botta_cigar_catalog_subscription',
            'id'
        );
    }
}