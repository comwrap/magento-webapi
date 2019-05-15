<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;
use Magento\ImportService\Model\ResourceModel\Source\CollectionFactory as SourceCollectionFactory;

/**
 * Class SourceRepository
 */
class SourceRepository implements SourceRepositoryInterface
{
    /**
     * @var SourceFactory
     */
    private $sourceFactory;

    /**
     * @var SourceResourceModel
     */
    private $sourceResourceModel;

    /**
     * @var SourceCollectionFactory
     */
    private $sourceCollectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @param SourceFactory $sourceFactory
     * @param SourceResourceModel $sourceResourceModel
     * @param SourceCollectionFactory $sourceCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        SourceFactory $sourceFactory,
        SourceResourceModel $sourceResourceModel,
        SourceCollectionFactory $sourceCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->sourceFactory        = $sourceFactory;
        $this->sourceResourceModel  = $sourceResourceModel;
        $this->sourceCollectionFactory    = $sourceCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     *
     * @throws CouldNotSaveException
     */
    public function save(SourceInterface $source)
    {
        try {
            $this->sourceResourceModel->save($source);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $source;
    }

    /**
     * @inheritdoc
     *
     * @throws NoSuchEntityException
     */
    public function getByUuid($uuid)
    {
        /** @var \Magento\ImportService\Api\Data\SourceInterface $source */
        $source = $this->sourceFactory->create();
        $this->sourceResourceModel->load($source, $uuid, $source::UUID);
        if (!$source->getUuid()) {
            throw new NoSuchEntityException(__('Source with uuid "%1" does not exist.', $uuid));
        }

        return $source;
    }

    /**
     * @inheritdoc
     *
     * @throws CouldNotDeleteException
     */
    public function delete(SourceInterface $source)
    {
        try {
            /** @var AbstractModel|SourceInterface $source */
            $this->sourceResourceModel->delete($source);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @inheritdoc
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteByUuid($uuid)
    {
        return $this->delete($this->getByUuid($uuid));
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $sourceCollection = $this->sourceCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $sourceCollection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($sourceCollection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $sourceCollection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $sourceCollection->setCurPage($criteria->getCurrentPage());
        $sourceCollection->setPageSize($criteria->getPageSize());
        $sources = [];
        foreach ($sourceCollection as $sourceModel) {
            $sources[] = $sourceModel;
        }
        $searchResults->setItems($sources);

        return $searchResults;
    }
}
