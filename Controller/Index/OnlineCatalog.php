<?php

namespace Botta\CigarCatalog\Controller\Index;

class OnlineCatalog extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setUrl('/pub/catalog/index.html');

        return $redirect;
    }
}