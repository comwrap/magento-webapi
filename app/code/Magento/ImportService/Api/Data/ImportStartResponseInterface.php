<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface ImportStartResponseInterface
 */
interface ImportStartResponseInterface
{
    const UUID = 'uuid';
    const STATUS = 'status';
    const ERROR = 'error';
    const STATUS_RUNNING = 'running';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAIL = 'fail';

    /**
     * Get UUID
     *
     * @return string
     */
    public function getUuid(): string;

    /**
     * Set UUID
     *
     * @param string $uuid
     * @return void
     */
    public function setUuid(string $uuid): void;

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Set status
     *
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void;

    /**
     * Get error
     *
     * @return string
     */
    public function getError(): string;

    /**
     * Set error
     *
     * @param string $error
     * @return void
     */
    public function setError(string $error): void;
}
