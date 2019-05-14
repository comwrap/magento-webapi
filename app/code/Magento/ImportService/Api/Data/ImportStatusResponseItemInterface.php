<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Class ImportStatusResponseItem
 */
interface ImportStatusResponseItemInterface
{
    const UUID = 'uuid';
    const STATUS = 'status';
    const SERIALIZED_DATA = 'serialized_data';
    const RESULT_SERIALIZED_DATA = 'result_serialized_data';
    const ERROR_CODE = 'error_code';
    const RESULT_MESSAGE = 'result_message';

    /**
     * Get uuid
     *
     * @return int
     */
    public function getUuid();

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get serialized data
     *
     * @return string
     */
    public function getSerializedData();

    /**
     * Get serialized data result
     *
     * @return string
     */
    public function getResultSerializedData();

    /**
     * Get error code
     *
     * @return string|null
     */
    public function getErrorCode();

    /**
     * Get result message
     *
     * @return string
     */
    public function getResultMessage();

    /**
     * Set uuid
     *
     * @param int $uuid
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface
     */
    public function setUuid($uuid);

    /**
     * Set imported status
     *
     * @param string $status
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface
     */
    public function setStatus($status);

    /**
     * Set serialized data
     *
     * @param string $serializedData
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface
     */
    public function setSerializedData($serializedData);

    /**
     * Set serialized result data
     *
     * @param string $resultSerializedData
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface
     */
    public function setResultSerializedData($resultSerializedData);

    /**
     * Set error code if occured
     *
     * @param string $errorCode
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface
     */
    public function setErrorCode($errorCode);

    /**
     * Set result message for process
     *
     * @param string $resultMessage
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface
     */
    public function setResultMessage($resultMessage);
}
