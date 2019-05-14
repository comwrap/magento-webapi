<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ResourceModel\Source;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;
use Magento\ImportService\Model\Source;

/**
 * Collection of Import Service Sources
 */
class Collection extends AbstractCollection
{
    /**
     * Source collection constructor
     */
    protected function _construct()
    {
        $this->_init(Source::class, SourceResourceModel::class);
    }

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        foreach($this as &$item) {
            $item->decorate();
        }
        return parent::_afterLoad();
    }
}
