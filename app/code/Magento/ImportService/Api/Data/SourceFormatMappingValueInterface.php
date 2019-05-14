<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface SourceFormatMappingValueInterface
 */
interface SourceFormatMappingValueInterface
{
    const OLD_VALUE = 'old_value';
    const NEW_VALUE = 'new_value';

    /**
     * @return string|null
     */
    public function getOldValue(): ?string;

    /**
     * Set Old Value
     *
     * @param string $oldValue
     * @return $this
     */
    public function setOldValue(string $oldValue): SourceFormatMappingValueInterface;

    /**
     * @return string|null
     */
    public function getNewValue(): ?string;

    /**
     * Set New Value
     *
     * @param string $newValue
     * @return $this
     */
    public function setNewValue(string $newValue): SourceFormatMappingValueInterface;
}