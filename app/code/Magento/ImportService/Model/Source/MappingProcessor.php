<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;
use Magento\ImportService\Model\Import\SourceTypePool;
use Magento\ImportService\Model\Import\Type\SourceTypeInterface;

class MappingProcessor
{
    /**
     * @var \Magento\ImportService\Model\Source\ReaderInterface[]
     */
    private $readers;

    /**
     * @var \Magento\ImportService\Model\Import\SourceTypePool
     */
    private $sourceTypePool;

    /**
     * ParserPool constructor.
     *
     * @param \Magento\ImportService\Model\Import\SourceTypePool $sourceTypePool
     * @param ReaderInterface[] $readers
     */
    public function __construct(
        SourceTypePool $sourceTypePool,
        $readers = []
    ) {
        $this->readers = $readers;
        $this->sourceTypePool = $sourceTypePool;
    }

    public function test()
    {
        
    }
}
