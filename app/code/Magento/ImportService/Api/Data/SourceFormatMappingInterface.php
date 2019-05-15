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

    const NAME = 'name';

    /**
     * Retrieve mapping name
     *
     * @return string|null

    public function getName();*/

    /**
     * Set mapping name
     *
     * @param string $name
     * @return $this

    public function setName($name);*/

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
}
