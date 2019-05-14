<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceFormatMappingInterface;

/**
 * Class SourceFormatMapping
 */
class SourceFormatMapping extends AbstractModel implements SourceFormatMappingInterface
{
    /**
     * @inheritDoc
     */
    public function getSourceAttribute(): ?string
    {
        return $this->getData(self::SOURCE_ATTRIBUTE);
    }

    /**
     * @inheritDoc
     */
    public function setSourceAttribute(string $sourceAttribute): SourceFormatMappingInterface
    {
        return $this->setData(self::SOURCE_ATTRIBUTE, $sourceAttribute);
    }

    /**
     * @inheritDoc
     */
    public function getDestinationAttribute(): ?string
    {
        return $this->getData(self::DESTINATION_ATTRIBUTE);
    }

    /**
     * @inheritDoc
     */
    public function setDestinationAttribute(string $destinationAttribute): SourceFormatMappingInterface
    {
        return $this->setData(self::DESTINATION_ATTRIBUTE, $destinationAttribute);
    }

    /**
     * @inheritDoc
     */
    public function getProcessingRules(): ?string
    {
        return $this->getData(self::PROCESSING_RULES);
    }

    /**
     * @inheritDoc
     */
    public function setProcessingRules(string $processingRules): SourceFormatMappingInterface
    {
        return $this->setData(self::PROCESSING_RULES, $processingRules);
    }

    /**
     * @inheritDoc
     */
    public function getTaxonomy(): ?string
    {
        return $this->getData(self::TAXONOMY);
    }

    /**
     * @inheritDoc
     */
    public function setTaxonomy(string $taxonomy): SourceFormatMappingInterface
    {
        return $this->setData(self::TAXONOMY, $taxonomy);
    }

    /**
     * @inheritDoc
     */
    public function getValuesMapping(): ?array
    {
        return $this->getData(self::VALUES_MAPPING);
    }

    /**
     * @inheritDoc
     */
    public function setValuesMapping(array $valuesMapping): SourceFormatMappingInterface
    {
        return $this->setData(self::VALUES_MAPPING, $valuesMapping);
    }
}
