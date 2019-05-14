<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

/**
 * Find Sources by SearchCriteria command
 *
 * Separate command interface to which repository proxies initial GetList call
 *
 * @see \Magento\ImportService\Api\SourceRepositoryInterface
 */
interface GetListInterface
{
    /**
     * Find sources by given search criteria. Search criteria is not required because load all sources is useful case
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultsInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface;
}
