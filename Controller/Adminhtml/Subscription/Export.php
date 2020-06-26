<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/27/2018
 * Time: 4:14 PM
 */

namespace Botta\CigarCatalog\Controller\Adminhtml\Subscription;

class Export extends \Magento\Backend\App\Action
{
    protected $_fileFactory;
    protected $_converter;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Botta\CigarCatalog\Model\Export\ConvertToCsv $converter
    )
    {
        $this->_fileFactory = $fileFactory;
        $this->_converter = $converter;

        parent::__construct($context);
    }

    public function execute()
    {
        $columns = $this->getRequest()->getParam('columns');

        return $this->_fileFactory->create('export.csv', $this->_converter->getCsvFile($columns), 'var');
    }
}