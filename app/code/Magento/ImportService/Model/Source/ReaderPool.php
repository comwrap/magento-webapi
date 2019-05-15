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

/**
 *  Source Reader Pool
 */
class ReaderPool
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
     * ReaderPool constructor.
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
    /**
     * {@inheritdoc}
     * @throws ImportServiceException
     * @return ReaderInterface
     */
    public function getReader(SourceInterface $source)
    {
        $sourceType = $this->sourceTypePool->getSourceType($source);
        $filePath = $sourceType->getAbsolutePathToFile($source);

        foreach ($this->readers as $key => $readerFactory) {
            if ($source->getSourceType() == $key) {
                /** @var \Magento\ImportService\Model\Source\ReaderInterface $reader */
                $reader = $readerFactory->create();
                $reader->init($source, $filePath);
                return $reader;
            }
        }
        throw new ImportServiceException(
            __('Reader for Source type "%1" not exist.', $source->getSourceType())
        );
    }
}
