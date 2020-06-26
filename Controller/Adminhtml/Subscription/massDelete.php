<?php

namespace Botta\CigarCatalog\Controller\Adminhtml\Subscription;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;

/**
 * massDelete
 *
 * @author Raibel Botta <raibelbotta@gmail.com>
 */
class massDelete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection
    )
    {
        parent::__construct($context);

        $this->connection = $resourceConnection->getConnection(
            ResourceConnection::DEFAULT_CONNECTION
        );
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $this->connection->delete(
            $this->connection->getTableName(
                'botta_cigar_catalog_subscription'
            ),
            sprintf('id IN (%s)', implode(
                ', ',
                $data['selected']
            ))
        );

        $this->messageManager->addSuccessMessage(__('Subscriptions deleted successfuly.'));

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
