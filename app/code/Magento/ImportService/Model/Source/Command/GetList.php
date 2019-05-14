<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\ImportService\Model\ResourceModel\Source\Collection;
use Magento\ImportService\Model\ResourceModel\Source\CollectionFactory;

/**
 * @inheritdoc
 */
class GetList implements GetListInterface
{
    /**
     * @var CollectionFactory
     */
    private $sourceCollectionFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @param CollectionFactory $sourceCollectionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        CollectionFactory $sourceCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->sourceCollectionFactory = $sourceCollectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->sourceCollectionFactory->create();

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        /** build item array for search result */
        $sources = [];

        foreach($collection as $item) {
            /** get format object, check for null and convert object into array */
            $format = $item->getFormat();
            if(isset($format)) {
                /** get format mapping object array, check for null and convert object into array */
                $formatMapping = $format->getMapping();
                if(isset($formatMapping)) {
                    $mappingArray = [];
                    foreach($formatMapping as $mapping) {
                        /** get value mapping object array, check for null and convert object into array */
                        $valuesMapping = $mapping->getValuesMapping();
                        if(isset($valuesMapping)) {
                            $valuesMappingArray = [];
                            foreach($valuesMapping as $values) {
                                $valuesMappingArray[] = $values->toArray();
                            }
                            /** set converted array into object field */
                            $mapping->setData('values_mapping', $valuesMappingArray);
                        }
                        $mappingArray[] = $mapping->toArray();
                    }
                    /** set converted array into object field */
                    $format->setData('mapping', $mappingArray);
                }
                /** set converted array into object field */
                $item->setData('format', $format->toArray());
            }
            $sources[] = $item->toArray();
        }

        /** @var SearchResultsInterfaceFactory $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($sources);
        $searchResult->setTotalCount(count($sources));
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult;
    }
}
