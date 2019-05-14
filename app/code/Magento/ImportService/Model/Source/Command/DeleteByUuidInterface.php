<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Delete Source by uuid command
 *
 * Separate command interface to which Repository proxies initial Delete call
 *
 * @see \Magento\ImportService\Api\SourceRepositoryInterface
 */
interface DeleteByUuidInterface
{
    /**
     * Delete the source by uuid. If source is not found do nothing
     *
     * @param string $uuid
     * @return void
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function execute(string $uuid);
}
