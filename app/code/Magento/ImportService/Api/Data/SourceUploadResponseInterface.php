<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface ImportResponseInterface
 */
interface SourceUploadResponseInterface
{
    const UUID = 'uuid';
    const STATUS = 'status';
    const ERROR = 'error';
    const SOURCE_MODEL = 'source';

    /**
     * Get file UUID
     *
     * @return string
     */
    public function getUuid();

    /**
     * Get file status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get error
     *
     * @return string
     */
    public function getError();

    /**
     * Get source
     *
     * @return \Magento\ImportService\Api\Data\SourceInterface
     */
    public function getSource();

    /**
     * @param $uuid
     * @return mixed
     */
    public function setUuid($uuid);

    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

    /**
     * @param $error
     * @return mixed
     */
    public function setError($error);

    /**
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return mixed
     */
    public function setSource(\Magento\ImportService\Api\Data\SourceInterface $source);
}
