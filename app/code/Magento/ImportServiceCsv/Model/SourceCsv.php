<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceCsv\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\ImportService\Model\Source;
use Magento\ImportService\Model\Source\FieldMappingFactory;
use Magento\ImportServiceCsv\Api\Data\SourceCsvInterface;
use Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterface;
use Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterfaceFactory;

/**
 * Class Source
 */
class SourceCsv extends Source implements SourceCsvInterface
{
    const SOURCE_EXTENSION = 'csv';
    /**
     * @var \Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterfaceFactory
     */
    private $formatCsvInterfaceFactory;

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
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        FieldMappingFactory $fieldMappingFactory,
        SourceFormatCsvInterfaceFactory $formatCsvInterfaceFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->formatCsvInterfaceFactory = $formatCsvInterfaceFactory;
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $fieldMappingFactory, $resource, $resourceCollection, $data);
    }

    /**
     * @inheritDoc
     */
    public function getFormat(): ?SourceFormatCsvInterface
    {
        return $this->getData(self::FORMAT);
    }

    /**
     * @inheritDoc
     */
    public function setFormat(SourceFormatCsvInterface $format): SourceCsvInterface
    {
        return $this->setData(self::FORMAT, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function afterLoad()
    {
        $formatJson = $this->getData(self::FORMAT);
        if (isset($formatJson)) {
            $formatData = json_decode($formatJson, true);
            $format = $this->formatCsvInterfaceFactory->create()->setData($formatData);
            $this->setFormat($format);
        }

        parent::afterLoad();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
        /** @var \Magento\ImportServiceCsv\Model\SourceFormatCsv $format */
        $format = $this->getFormat();
        if (isset($format)) {
            $format = $format->toJson();
            $this->setData(self::FORMAT, $format);
        }

        parent::beforeSave();
    }
}
