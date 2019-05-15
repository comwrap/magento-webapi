<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Source Reader Interface
 */
interface ReaderInterface extends \SeekableIterator
{
    const FILE_PATH = 'file_path';
    const SOURCE = 'source';

    public function init(SourceInterface $source, $filePath);
    /**
     * @return string
     */
    public function getFilePath();

    /**
     * @param string $filePath
     * @return $this
     */
    public function setFilePath(string $filePath);

    /**
     * @return SourceInterface
     */
    public function getSource();

    /**
     * @param SourceInterface $source
     * @return $this
     */
    public function setSource(SourceInterface $source);

}
