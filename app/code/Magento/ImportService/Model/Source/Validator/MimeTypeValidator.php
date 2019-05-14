<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;
use Magento\Framework\Filesystem\Driver\Http\Proxy as Http;
use Magento\ImportService\Model\Import\SourceTypePool;
use Magento\Framework\File\Mime\Proxy as Mime;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class MimeTypeValidator
 */
class MimeTypeValidator implements ValidatorInterface
{
    /**
     * @var \Magento\Framework\Filesystem\Driver\Http
     */
    private $httpDriver;

    /**
     * @var SourceTypePool
     */
    private $sourceTypePool;

    /**
     * @var Mime
     */
    private $mime;

    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @param Http $httpDriver
     * @param SourceTypePool $sourceTypePool
     * @param Mime $mime
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     */
    public function __construct(
        Http $httpDriver,
        SourceTypePool $sourceTypePool,
        Mime $mime,
        File $fileSystemIo,
        Filesystem $fileSystem
    ) {
        $this->httpDriver = $httpDriver;
        $this->sourceTypePool = $sourceTypePool;
        $this->mime = $mime;
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

        /** @var $mimeType */
        $mimeType = false;

        /** validate import source for remote url or local path */
        if(filter_var($source->getImportData(), FILTER_VALIDATE_URL)) {
            /** check empty variable */
            $importData = $source->getImportData();

            if(isset($importData) && $importData != "") {
                $externalSourceUrl = preg_replace("(^https?://)", "", $importData);

                /** check for file exists */
                if($this->httpDriver->isExists($externalSourceUrl)) {
                    /** @var array $stat */
                    $stat = $this->httpDriver->stat($externalSourceUrl);
                    if (isset($stat['type'])) {
                        $mimeType = $stat['type'];
                    }
                }
            }
        } else {
            /** @var \Magento\Framework\Filesystem\Directory\Write $write */
            $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

            /** create absolute path */
            $absoluteFilePath = $write->getAbsolutePath($source->getImportData());

            /** check if file exist */
            if($this->fileSystemIo->fileExists($absoluteFilePath)) {
                $mimeType = $this->mime->getMimeType($absoluteFilePath);
            }
        }

        if($mimeType) {
        	$mimeType = trim(explode(";", $mimeType)[0]);
        	if (!in_array($mimeType, $this->sourceTypePool->getAllowedMimeTypes())) {
                $errors[] = __('Invalid mime type: %1, expected is one of: %2', $mimeType, implode(", ", $this->sourceTypePool->getAllowedMimeTypes()));
            }
        }

        return $errors;
    }
}
