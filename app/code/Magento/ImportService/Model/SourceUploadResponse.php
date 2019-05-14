<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\Api\Data\SourceInterface;

class SourceUploadResponse extends AbstractModel implements SourceUploadResponseInterface
{
    /**
     * Get file UUID
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->getData(self::UUID);
    }

    /**
     * Get file status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get error
     * @return string
     */
    public function getError()
    {
        return $this->getData(self::ERROR);
    }

    /**
     * Get source
     *
     * @return SourceInterface
     */
    public function getSource()
    {
        return $this->getData(self::SOURCE_MODEL);
    }

    /**
     * @param $uuid
     * @return SourceUploadResponse|mixed
     */
    public function setUuid($uuid)
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * @param $status
     * @return SourceUploadResponse|mixed
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param $error
     * @return SourceUploadResponse|mixed
     */
    public function setError($error)
    {
        return $this->setData(self::ERROR, $error);
    }

    /**
     * @param SourceInterface $source
     * @return mixed
     */
    public function setSource(SourceInterface $source)
    {
        return $this->setData(self::SOURCE_MODEL, $source);
    }
}
