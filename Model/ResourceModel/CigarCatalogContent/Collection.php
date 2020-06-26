<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 5/1/2020
 * Time: 4:01 p.m.
 */

namespace Botta\CigarCatalog\Model\ResourceModel\CigarCatalogContent;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Botta\CigarCatalog\Model\CigarCatalogContent::class,
            \Botta\CigarCatalog\Model\ResourceModel\CigarCatalogContent::class
        );
    }
}