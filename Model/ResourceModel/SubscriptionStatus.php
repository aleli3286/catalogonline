<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/26/2018
 * Time: 6:52 PM
 */

namespace Botta\CigarCatalog\Model\ResourceModel;


class SubscriptionStatus extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init(
            'botta_cigar_catalog_subscription_status',
            'id'
        );
    }
}