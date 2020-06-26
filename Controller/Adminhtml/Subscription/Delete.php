<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/27/2018
 * Time: 9:47 AM
 */

namespace Botta\CigarCatalog\Controller\Adminhtml\Subscription;

use Magento\Framework\App\ResourceConnection;

class Delete extends \Magento\Backend\App\Action
{
    protected $connection;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ResourceConnection $resourceConnection
    )
    {
        $this->connection = $resourceConnection->getConnection(
            ResourceConnection::DEFAULT_CONNECTION
        );

        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        $this->connection->delete(
            $this->connection->getTableName('botta_cigar_catalog_subscription'),
            sprintf('id = %s', $id)
        );

        $this->messageManager->addSuccessMessage(__('Subscription deleted successfuly.'));

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}