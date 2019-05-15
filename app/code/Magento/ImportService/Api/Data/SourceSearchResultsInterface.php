<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

interface SourceSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get sources list.
     *
     * @return \Magento\ImportService\Api\Data\SourceInterface[]
     */
    public function getItems();

    /**
     * Set sources list.
     *
     * @param \Magento\ImportService\Api\Data\SourceInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
