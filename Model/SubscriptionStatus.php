<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/26/2018
 * Time: 6:51 PM
 */

namespace Botta\CigarCatalog\Model;

/**
 * Class SubscriptionStatus
 * @package Botta\CigarCatalog\Model
 * @method setName($name)
 * @method getName()
 */
class SubscriptionStatus extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init(
            \Botta\CigarCatalog\Model\ResourceModel\SubscriptionStatus::class
        );
    }
}