<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

/**
 * Factory class for \Magento\ImportService\Model\ImportStatusResponse
 */
class ImportStatusResponseFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Magento\\ImportService\\Model\\ImportStatusResponse')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Magento\ImportService\Model\ImportStatusResponse
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }

    /**
     * Create class instance with specified parameters
     *
     * @param string $error
     * @return \Magento\ImportService\Model\ImportStatusResponse
     */
    public function createFailure(string $error = "")
    {
        $response = $this->_objectManager->create($this->_instanceName, []);
        $response->setError($error);
        $response->setStatus(\Magento\ImportService\Api\Data\ImportStatusResponseInterface::STATUS_FAILED);
        return $response;
    }
}
