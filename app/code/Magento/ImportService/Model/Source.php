<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\SourceExtensionInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResource;
use Magento\ImportService\Api\Data\SourceFormatInterface;
use Magento\ImportService\Model\Source\FieldMappingFactory;

/**
 * Class Source
 */
class Source extends AbstractExtensibleModel implements SourceInterface
{
    const CACHE_TAG = 'magento_import_service_source';
    /**
     * @var \Magento\ImportService\Model\Source\FieldMapping
     */
    private $fieldMappingFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        FieldMappingFactory $fieldMappingFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->fieldMappingFactory = $fieldMappingFactory;
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $resource, $resourceCollection, $data);
    }

    /**
     * Source constructor
     */
    protected function _construct()
    {
        $this->_init(SourceResource::class);
    }

    /**
     * Get unique page cache identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @inheritDoc
     */
    public function getUuid(): ?string
    {
        return $this->getData(self::UUID);
    }

    /**
     * @inheritDoc
     */
    public function setUuid(string $uuid): SourceInterface
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * @inheritDoc
     */
    public function getSourceType(): string
    {
        return $this->getData(self::SOURCE_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setSourceType(string $sourceType): SourceInterface
    {
        return $this->setData(self::SOURCE_TYPE, $sourceType);
    }

    /**
     * @inheritDoc
     */
    public function getImportType(): string
    {
        return $this->getData(self::IMPORT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setImportType(string $importType): SourceInterface
    {
        return $this->setData(self::IMPORT_TYPE, $importType);
    }

    /**
     * @inheritDoc
     */
    public function getMapping(): ?array
    {
        return $this->getData(self::MAPPING);
    }

    /**
     * @inheritDoc
     */
    public function setMapping(array $mapping = null): SourceInterface
    {
        return $this->setData(self::MAPPING, $mapping);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): SourceInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getImportData(): string
    {
        return $this->getData(self::IMPORT_DATA);
    }

    /**
     * @inheritDoc
     */
    public function setImportData(string $importData): SourceInterface
    {
        return $this->setData(self::IMPORT_DATA, $importData);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $date): SourceInterface
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(SourceExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function afterLoad()
    {
        $mappingJson = $this->getData(self::MAPPING);
        $mapping = [];
        if (isset($mappingJson)) {
            $mappingData = json_decode($mappingJson, true);
            foreach ($mappingData as $fieldMapping) {
                $mapping[] = $this->fieldMappingFactory->create()->setData($fieldMapping);
            }
            $this->setMapping($mapping);
        }

        parent::afterLoad();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
        $mapping = $this->getMapping();
        $mappingArray = [];
        if (isset($mapping)) {
            foreach ($mapping as $fieldMapping) {
                $mappingArray[] = json_decode($fieldMapping->toJson(), true);
            }
        }
        $mappingJson = json_encode($mappingArray);
        $this->setData(self::MAPPING, $mappingJson);

        parent::beforeSave();
    }
}
