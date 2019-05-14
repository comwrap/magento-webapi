<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface SourceFormatMappingInterface
 */
interface SourceFormatMappingInterface
{
    const SOURCE_ATTRIBUTE = 'source_attribute';
    const DESTINATION_ATTRIBUTE = 'destination_attribute';
    const PROCESSING_RULES = 'processing_rules';
    const TAXONOMY = 'taxonomy';
    const VALUES_MAPPING = 'values_mapping';

    /**
     * @return string|null
     */
    public function getSourceAttribute(): ?string;

    /**
     * Set Source Attribute
     *
     * @param string $sourceAttribute
     * @return $this
     */
    public function setSourceAttribute(string $sourceAttribute): SourceFormatMappingInterface;

    /**
     * @return string|null
     */
    public function getDestinationAttribute(): ?string;

    /**
     * Set destination attribute
     *
     * @param string $destinationAttribute
     * @return $this
     */
    public function setDestinationAttribute(string $destinationAttribute): SourceFormatMappingInterface;

    /**
     * @return string|null
     */
    public function getProcessingRules(): ?string;

    /**
     * Set processing rules
     *
     * @param string $processingRules
     * @return $this
     */
    public function setProcessingRules(string $processingRules): SourceFormatMappingInterface;

    /**
     * @return string|null
     */
    public function getTaxonomy(): ?string;

    /**
     * Set taxonomy
     *
     * @param string $taxonomy
     * @return $this
     */
    public function setTaxonomy(string $taxonomy): SourceFormatMappingInterface;

    /**
     * @return \Magento\ImportService\Api\Data\SourceFormatMappingValueInterface[]|null
     */
    public function getValuesMapping(): ?array;

    /**
     * Set Value Mapping
     *
     * @param \Magento\ImportService\Api\Data\SourceFormatMappingValueInterface[] $valuesMapping
     * @return $this
     */
    public function setValuesMapping(array $valuesMapping): SourceFormatMappingInterface;
}