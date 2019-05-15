<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\Source\ReaderInterface;

abstract class ReaderAbstract extends DataObject implements ReaderInterface
{

    /**
     * @inheritDoc
     */
    public function getFilePath()
    {
        return $this->getData(ReaderInterface::FILE_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setFilePath(string $filePath)
    {
        return $this->setData(ReaderInterface::FILE_PATH, $filePath);
    }

    /**
     * @inheritDoc
     */
    public function getSource()
    {
        return $this->getData(ReaderInterface::SOURCE);
    }

    /**
     * @inheritDoc
     */
    public function setSource(SourceInterface $source)
    {
        return $this->setData(ReaderInterface::SOURCE, $source);
    }
}
