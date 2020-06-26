<?php

namespace Botta\CigarCatalog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var SchemaSetupInterface
     */
    private $setup;

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->setup = $setup;

        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->addIndexToEmail();
        }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $this->createEmailConfigurationForNotify();
        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $this->setup->getConnection()->changeColumn(
                $this->setup->getTable('botta_cigar_catalog_subscription'),
                'full_name',
                'firstname',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 150,
                    'nullable' => false,
                    'comment' => 'First Name'
                ]
            );

            $this->setup->getConnection()->addColumn(
                $this->setup->getTable('botta_cigar_catalog_subscription'),
                'lastname',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 150,
                    'nullable' => false,
                    'comment' => 'Last Name'
                ]
            );

            $this->setup->getConnection()->dropIndex(
                $this->setup->getTable('botta_cigar_catalog_subscription'),
                $this->setup->getIdxName(
                    'botta_cigar_catalog_subscription',
                    'email',
                    AdapterInterface::INDEX_TYPE_UNIQUE
                )
            );

            $this->setup->getConnection()->modifyColumn(
                $this->setup->getTable('botta_cigar_catalog_subscription'),
                'email',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 100,
                    'nullable' => true,
                    'comment' => 'Email'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $ccContent = $setup->getConnection()->newTable(
                $setup->getTable('botta_cigar_catalog_content')
            )->addColumn(
                'id',
                Table::TYPE_SMALLINT,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true,
                    'primary' => true,
                    'identity' => true
                ],
                'Primary Key'
            )->addColumn(
                'image',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'Image path'
            );

            $setup->getConnection()->createTable($ccContent);
        }

        $setup->endSetup();
    }

    private function addIndexToEmail()
    {
        $this->setup->getConnection()->addIndex(
            $this->setup->getTable('botta_cigar_catalog_subscription'),
            $this->setup->getIdxName(
                'botta_cigar_catalog_subscription',
                'email',
                AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            'email',
            AdapterInterface::INDEX_TYPE_UNIQUE
        );
    }

    private function createEmailConfigurationForNotify()
    {
        $this->setup->getConnection()->insert(
            $this->setup->getTable('mkc_emails_configuration_from_to'),
            [
                'email_id' => 'new_cigar_catalog_subscription',
                'to_email' => 'aleli@mikescigars.com',
                'type' => 'backend',
                'label' => 'New Catalog Subscription'
            ]
        );
    }
}