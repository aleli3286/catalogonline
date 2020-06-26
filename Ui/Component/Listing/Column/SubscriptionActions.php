<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/27/2018
 * Time: 9:33 AM
 */

namespace Botta\CigarCatalog\Ui\Component\Listing\Column;

class SubscriptionActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    const URL_PATH_DELETE = 'cigarcatalog/subscription/delete';

    protected $urlBuilder;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = [
                        'delete' => [
                            'confirm' => [
                                'message' => __('Are you sure you want to delete this item?'),
                                'title' => 'Confirm action'
                            ],
                            'label' => __('Delete'),
                            'href' => $this->getDeleteUrl($item['id'])
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }

    protected function getDeleteUrl($id)
    {
        return $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $id]);
    }
}