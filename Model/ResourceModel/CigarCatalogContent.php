<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 5/1/2020
 * Time: 4:01 p.m.
 */

namespace Botta\CigarCatalog\Model\ResourceModel;

class CigarCatalogContent extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('botta_cigar_catalog_content', 'id');
    }
}