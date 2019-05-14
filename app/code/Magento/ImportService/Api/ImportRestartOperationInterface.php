<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

/**
 * Class ImportRestartOperation
 */
interface ImportRestartOperationInterface
{
    /**
     * restart failed operation.
     *
     * @param int $uuid
     * @param string $serializedData
     * @return void
     */
    public function execute(int $uuid, string $serializedData): void;
}
