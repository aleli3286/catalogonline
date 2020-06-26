<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 5/1/2020
 * Time: 3:58 p.m.
 */

namespace Botta\CigarCatalog\Model;


class CigarCatalogContent extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(
            \Botta\CigarCatalog\Model\ResourceModel\CigarCatalogContent::class
        );
    }
}