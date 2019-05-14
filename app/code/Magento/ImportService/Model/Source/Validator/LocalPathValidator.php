<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class LocalPathValidator
 */
class LocalPathValidator implements ValidatorInterface
{
    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     */
    public function __construct(
        File $fileSystemIo,
        Filesystem $fileSystem
    ) {
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
    }

    /**
     * return error messages in array
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return array
     */
    public function validate(SourceInterface $source)
    {
        $errors = [];

        /** @var \Magento\Framework\Filesystem\Directory\Write $write */
        $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

        /** create absolute path */
        $absoluteFilePath = $write->getAbsolutePath($source->getImportData());

        /** check if file exist */
        if(!$this->fileSystemIo->fileExists($absoluteFilePath)) {
            $errors[] = __('Local file %1 does not exist.', $source->getImportData());
        }

        return $errors;
    }
}
