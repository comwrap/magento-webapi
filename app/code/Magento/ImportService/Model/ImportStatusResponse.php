<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\ImportStatusResponseInterface;

class ImportStatusResponse extends AbstractModel implements ImportStatusResponseInterface
{
    /**
     * Get import status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get error if there is any with import process
     *
     * @return string|null
     */
    public function getError()
    {
        return $this->getData(self::ERROR);
    }

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
     * Get imported entity type
     *
     * @return string
     */
    public function getEntityType()
    {
        return $this->getData(self::ENTITY_TYPE);
    }

    /**
     * Retrieve current user ID
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * Retrieve current user type
     *
     * @return int
     */
    public function getUserType()
    {
        return $this->getData(self::USER_TYPE);
    }

    /**
     * Get import items status
     *
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface[]
     */
    public function getItems()
    {
        return $this->getData(self::ITEMS);
    }

    /**
     * Set import process status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set import process error if there is any
     *
     * @param string $error
     * @return $this
     */
    public function setError($error)
    {
        return $this->setData(self::ERROR, $error);
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
     * Set imported entity type
     *
     * @param string $entityType
     * @return $this
     */
    public function setEntityType($entityType)
    {
        return $this->setData(self::ENTITY_TYPE, $entityType);
    }

    /**
     * Set user id
     *
     * @param int $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Set user type
     *
     * @param int $userType
     * @return $this
     */
    public function setUserType($userType)
    {
        return $this->setData(self::USER_TYPE, $userType);
    }

    /**
     * Set imported items
     *
     * @param \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface[] $items
     * @return $this
     */
    public function setItems($items)
    {
        return $this->setData(self::ITEMS, $items);
    }
}
