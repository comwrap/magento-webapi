<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\ImportStatusResponseItemInterface;

class ImportStatusResponseItem extends AbstractModel implements ImportStatusResponseItemInterface
{
    /**
     * Get uuid
     *
     * @return int
     */
    public function getUuid()
    {
        return $this->getData(self::UUID);
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get serialized data
     *
     * @return string
     */
    public function getSerializedData()
    {
        return $this->getData(self::SERIALIZED_DATA);
    }

    /**
     * Get serialized data result
     *
     * @return string
     */
    public function getResultSerializedData()
    {
        return $this->getData(self::RESULT_SERIALIZED_DATA);
    }

    /**
     * Get error code
     *
     * @return string|null
     */
    public function getErrorCode()
    {
        return $this->getData(self::ERROR_CODE);
    }

    /**
     * Get result message
     *
     * @return string
     */
    public function getResultMessage()
    {
        return $this->getData(self::RESULT_MESSAGE);
    }

    /**
     * Set uuid
     *
     * @param int $uuid
     * @return $this
     */
    public function setUuid($uuid)
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * Set imported status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set serialized data
     *
     * @param string $serializedData
     * @return $this
     */
    public function setSerializedData($serializedData)
    {
        return $this->setData(self::SERIALIZED_DATA, $serializedData);
    }

    /**
     * Set serialized result data
     *
     * @param string $resultSerializedData
     * @return $this
     */
    public function setResultSerializedData($resultSerializedData)
    {
        return $this->setData(self::RESULT_SERIALIZED_DATA, $resultSerializedData);
    }

    /**
     * Set error code if occured
     *
     * @param string $errorCode
     * @return $this
     */
    public function setErrorCode($errorCode)
    {
        return $this->setData(self::ERROR_CODE, $errorCode);
    }

    /**
     * Set result message for process
     *
     * @param string $resultMessage
     * @return $this
     */
    public function setResultMessage($resultMessage)
    {
        return $this->setData(self::RESULT_MESSAGE, $resultMessage);
    }
}
