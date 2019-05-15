<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Storage;

class MagentoRest implements StorageInterface
{

    /**
     * @var \Magento\Framework\App\DeploymentConfig
     */
    private $deploymentConfig;
    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    private $httpClientFactory;
    /**
     * @var \Magento\Framework\HTTP\Adapter\CurlFactory
     */
    private $curlFactory;

    public function __construct(
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \Magento\Framework\HTTP\Adapter\CurlFactory $curlFactory
    ) {

        $this->deploymentConfig = $deploymentConfig;
        $this->httpClientFactory = $httpClientFactory;
        $this->curlFactory = $curlFactory;
    }

    /**
     * @param mixed $item
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return string
     */
    public function execute($item, $source)
    {
        $config = $this->deploymentConfig->getConfigData('import_service');
        $magentoApiConfig = $config['magento'];
        $url = $magentoApiConfig['url'] .
            '/V1/products';
        $body = $item;

        $curlObject = $this->curlFactory->create();
        $curlObject->setConfig(
            [
                'timeout' => 18000
            ]
        );

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'cache-control: no-cache',
            "Authorization: Bearer {$magentoApiConfig['token']}"
        ];

        $curlObject->write(
            \Zend_Http_Client::POST,
            $url,
            CURL_HTTP_VERSION_NONE,
            $headers,
            $body
        );
        $curlObject->addOption(CURLOPT_FOLLOWLOCATION, true);
        $response = $curlObject->read();
        $curlObject->close();

        return $response;
    }
}
