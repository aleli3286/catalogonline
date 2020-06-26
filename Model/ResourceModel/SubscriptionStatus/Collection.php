<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/26/2018
 * Time: 6:51 PM
 */

namespace Botta\CigarCatalog\Model\ResourceModel\SubscriptionStatus;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            \Botta\CigarCatalog\Model\SubscriptionStatus::class,
            \Botta\CigarCatalog\Model\ResourceModel\SubscriptionStatus::class
        );
    }
}