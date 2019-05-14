<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;
use Magento\ImportService\Model\Source\Command\GetListInterface;
use Magento\ImportService\Model\Source\Command\DeleteByUuidInterface;

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
     * @var GetListInterface
     */
    private $commandGetList;

    /*
     * @var DeleteByUuidInterface
     */
    private $commandDeleteByUuid;

    /**
     * @param SourceFactory $sourceFactory
     * @param SourceResourceModel $sourceResourceModel
     * @param GetListInterface $commandGetList
     * @param DeleteByUuidInterface $commandDeleteByUuid
     */
    public function __construct(
        SourceFactory $sourceFactory,
        SourceResourceModel $sourceResourceModel,
        GetListInterface $commandGetList,
        DeleteByUuidInterface $commandDeleteByUuid
    ) {
        $this->sourceFactory        = $sourceFactory;
        $this->sourceResourceModel  = $sourceResourceModel;
        $this->commandGetList = $commandGetList;
        $this->commandDeleteByUuid = $commandDeleteByUuid;
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
     */
    public function deleteByUuid(string $uuid): void
    {
        $this->commandDeleteByUuid->execute($uuid);
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        return $this->commandGetList->execute($searchCriteria);
    }
}
