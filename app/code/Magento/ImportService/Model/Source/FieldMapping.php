<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\Source;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\FieldMappingInterface;

class FieldMapping extends DataObject implements FieldMappingInterface
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getSourceName()
    {
        return self::SOURCE_NAME_PREFIX.'_'.$this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getTargetName()
    {
        return self::TARGET_NAME_PREFIX.'_'.$this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getSourcePath()
    {
        return $this->getData(self::SOURCE_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setSourcePath($sourcePath)
    {
        return $this->setData(self::SOURCE_PATH, $sourcePath);
    }

    /**
     * @inheritDoc
     */
    public function getTargetPath()
    {
        return $this->getData(self::TARGET_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setTargetPath($targetPath)
    {
        return $this->setData(self::TARGET_PATH, $targetPath);
    }

    /**
     * @inheritDoc
     */
    public function getProcessingRules()
    {
        return $this->getData(self::PROCESSING_RULES);
    }

    /**
     * @inheritDoc
     */
    public function setProcessingRules($processingRules)
    {
        return $this->setData(self::PROCESSING_RULES, $processingRules);
    }
}
