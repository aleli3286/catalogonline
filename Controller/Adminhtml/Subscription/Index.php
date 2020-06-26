<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/26/2018
 * Time: 9:35 AM
 */

namespace Botta\CigarCatalog\Controller\Adminhtml\Subscription;

class Index extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->_view->loadLayout();

        $this
            ->_setActiveMenu(
                'Botta_CigarCatalog::cigar_catalog_subscription'
            )->_addBreadcrumb(
                'Catalog Subscriptions',
                'Catalog Subscriptions'
            );

        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            'Catalog Subscriptions'
        );

        $this->_view->renderLayout();
    }
}