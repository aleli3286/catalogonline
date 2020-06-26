<?php

namespace Botta\CigarCatalog\Controller\Index;

use Botta\CigarCatalog\Model\Subscription;
use Botta\CigarCatalog\Model\SubscriptionFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Subscribe extends \Magento\Framework\App\Action\Action
{
    private $modelFactory;
    protected $dataPersistor;

    public function __construct(
        Context $context,
        SubscriptionFactory $subscriptionFactory
    )
    {
        parent::__construct($context);

        $this->modelFactory = $subscriptionFactory;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create()->setPath(
            '*/*/'
        );

        $post = $this->getRequest()->getPost();

        try {
            /** @var \Botta\CigarCatalog\Model\Subscription $model */
            $model = $this->modelFactory->create();
            $model->setData(
                $post['subscribe']
            )->setCreatedAt(
                date('Y-m-d H:i:s')
            );

            $model->getResource()->save($model);

            $this->notify($model);

            $this->getDataPersistor()->clear('request_online_catalog_form');

            $this->messageManager->addSuccessMessage(
                __('Subscription request saved successfully.')
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __(
                    'Error while trying to save your data [%1]',
                    $e->getMessage()
                )
            );
        }

        return $resultRedirect;
    }

    protected function notify(Subscription $model)
    {
        /** @var \Mike\Email\Model\Configuration $emailConfiguration */
        $emailConfiguration = $this->getEmailConfiguration();

        if ((null !== $emailConfiguration) && !empty($emailConfiguration->getToEmail())) {
            $sender = $emailConfiguration->getFromEmail() ? [
                $emailConfiguration->getFromEmail() => $emailConfiguration->getFromEmail()
            ] : [
                'customerservice@mikescigars.com' => "Mike's Cigars Customer Service"
            ];
            $recipients = [];
            foreach (explode(',', $emailConfiguration->getToEmail()) as $recipient) {
                $recipients[trim($recipient)] = trim($recipient);
            }

            /** @var \Botta\CigarCatalog\Helper\Email $emailHelper */
            $emailHelper = $this->_objectManager->create(\Botta\CigarCatalog\Helper\Email::class);
            $emailHelper->sendMail(
                'botta_new_catalog_subscription',
                [
                    'model' => $model
                ],
                $sender,
                $recipients
            );
        }
    }

    protected function getEmailConfiguration()
    {
        $configurationId = 'new_cigar_catalog_subscription';

        $configuration = $this->_objectManager->create(
            \Mike\Email\Model\ResourceModel\Configuration\Collection::class
        )->setEmailId(
            $configurationId
        )->getFirstItem();

        return null !== $configuration->getId() ? $configuration : null;
    }

    /**
     * @return DataPersistorInterface
     */
    private function getDataPersistor()
    {
        if ($this->dataPersistor === null) {
            $this->dataPersistor = ObjectManager::getInstance()
                ->get(DataPersistorInterface::class);
        }

        return $this->dataPersistor;
    }
}