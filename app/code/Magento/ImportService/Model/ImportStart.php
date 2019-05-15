<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\ObjectManagerInterface;
use Magento\ImportService\Api\Data\ImportConfigInterface;
use Magento\ImportService\Api\Data\ImportStartResponseInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\ImportStartInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\Model\Import\SourceTypePool;
use Magento\ImportService\Model\Source\ReaderPool;
use Magento\ImportService\Model\Config\Reader as ImportServiceConfig;
use Magento\ImportService\Model\Storage\MagentoRest;
use Magento\ImportServiceCsv\Model\CsvPathResolver;
use Magento\ImportServiceCsv\Model\JsonPathResolver;

/**
 * Class ImportStart
 */
class ImportStart implements ImportStartInterface
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;
    /**
     * @var ImportStartResponseFactory
     */
    private $importStartResponseFactory;
    /**
     * @var \Magento\ImportService\Api\SourceRepositoryInterface
     */
    private $sourceRepository;
    /**
     * @var \Magento\ImportService\Model\Import\SourceTypePool
     */
    private $sourceTypePool;
    /**
     * @var \Magento\ImportService\Model\Source\ReaderPool
     */
    private $readerPool;
    /**
     * @var \Magento\ImportService\Model\Config\Reader
     */
    private $importServiceConfig;

    /**
     * ImportStart constructor.
     *
     * @param \Magento\ImportService\Model\ImportStartResponseFactory $importStartResponseFactory
     * @param \Magento\ImportService\Api\SourceRepositoryInterface $sourceRepository
     * @param \Magento\ImportService\Model\Source\ReaderPool $readerPool
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ImportServiceConfig $importServiceConfig,
        ImportStartResponseFactory $importStartResponseFactory,
        SourceRepositoryInterface $sourceRepository,
        ReaderPool $readerPool
    ) {
        $this->objectManager = $objectManager;
        $this->importServiceConfig = $importServiceConfig;
        $this->importStartResponseFactory = $importStartResponseFactory;
        $this->sourceRepository = $sourceRepository;
        $this->readerPool = $readerPool;
    }

    /**
     *  {@inheritdoc}
     */
    public function execute($uuid, $type, ImportConfigInterface $importConfig)
    {
        $importStartResponse = $this->importStartResponseFactory->create();

        $source = $this->sourceRepository->getByUuid($uuid);
        $reader = $this->readerPool->getReader($source);

        $config = $this->importServiceConfig->read();
        $reader->rewind();
        foreach ($reader as $sourceItem) {
            $mappingFrom = $this->processMappingFrom($sourceItem, $source);
            $itemToImport = $this->buildItem($mappingFrom, $source);
            $result = $this->importToStorage($itemToImport, $source);
        }

        $importStartResponse->setError('');
        $importStartResponse->setStatus('processing');
        $importStartResponse->setUuid($uuid);
        return $importStartResponse;
    }

    private function processMappingFrom($sourceItem, SourceInterface $source)
    {
        /** @var CsvPathResolver $pathResolver */
        $pathResolver = $this->objectManager->get(CsvPathResolver::class);
        //$mappedData = [];
        $mapping = $source->getMapping();
        foreach ($mapping as &$fieldMapping) {
            //$name = $fieldMapping->getName();
            $value = $pathResolver->get($sourceItem, $fieldMapping->getSourcePath());
            $fieldMapping->setData('value', $value);
        }
        return $mapping;
    }

    private function applyProcessingRules()
    {

    }

    /**
     * @param \Magento\ImportService\Api\Data\FieldMappingInterface[] $mapping
     * @param SourceInterface $source
     * @return mixed
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    private function buildItem($mapping, $source)
    {
        /** @var JsonPathResolver $jsonResolver */
        $jsonResolver = $this->objectManager->get(JsonPathResolver::class);
        $itemData = null;
        foreach ($mapping as $fieldMapping) {
            $itemData = $jsonResolver->set($itemData, $fieldMapping->getTargetPath(), $fieldMapping->getData('value'));
        }
        return $itemData;
    }

    /**
     * @param mixed $item
     * @param SourceInterface $source
     * @return string
     */
    private function importToStorage($item, $source)
    {
        /** @var MagentoRest $storage */
        $storage = $this->objectManager->get(MagentoRest::class);
        return $storage->execute($item, $source);
    }
}
