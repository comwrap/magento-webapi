<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\SourceInterface;

/**
 * Interface SourceRepositoryInterface
 */
interface SourceRepositoryInterface
{
    /**
     * Saves source
     *
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return \Magento\ImportService\Api\Data\SourceInterface
     */
    public function save(SourceInterface $source);

    /**
     * Provides source by UUID
     *
     * @param string $uuid
     * @return \Magento\ImportService\Api\Data\SourceInterface
     */
    public function getByUuid($uuid);

    /**
     * Provides sources which match a specific criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria);

    /**
     * Deletes source
     *
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return bool
     */
    public function delete(\Magento\ImportService\Api\Data\SourceInterface $source);

    /**
     * Deletes source by UUID
     *
     * @param string $uuid
     * @return bool
     */
    public function deleteByUuid($uuid);
}
