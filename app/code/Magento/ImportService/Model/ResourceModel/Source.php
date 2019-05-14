<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\ImportService\Api\Data\SourceInterface;

/**
 * Class SourceResourceModel
 */
class Source extends AbstractDb
{
    const TABLE_NAME = 'import_service_source';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, SourceInterface::ENTITY_ID);
    }
}
