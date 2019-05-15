<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Type;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportService\ImportServiceException;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\PartialSourceInterface;

/**
 * Partial Source Type
 */
class PartialSourceType implements SourceTypeInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Partial File Type constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbsolutePathToFile(SourceInterface $source)
    {
        /** @var string $contentFilePath */
        $contentFilePath = SourceTypeInterface::IMPORT_SOURCE_FILE_PATH . $source->getImportData();

        /** @var \Magento\Framework\Filesystem\Directory\Write $var */
        $dirReader = $this->filesystem->getDirectoryRead(DirectoryList::VAR_DIR);
        return $dirReader->getAbsolutePath($contentFilePath);
    }

    /**
     * generate file name with source type
     *
     * @param string $dataHash
     * @param int $pieceNumber
     * @return string
     */
    private function generateFilePath($dataHash, $pieceNumber)
    {
        return SourceTypeInterface::IMPORT_SOURCE_FILE_PATH . $dataHash . DIRECTORY_SEPARATOR . $pieceNumber;
    }

    /**
     * Check valid partial source
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return bool
     */
    public function isValidSource(SourceInterface $source)
    {
        /** check the valid source interface */
        if($source instanceof PartialSourceInterface)
        {
            /** check the partial import fields */
            if(!is_null($source->getDataHash())
                && !is_null($source->getPiecesCount())
                && !is_null($source->getPieceNumber()))
            {
                return true;
            }

            /** throw error if partial parameters is not valid */
            throw new ImportServiceException(
                __('Invalid partial source import parameters')
            );
        }

        return false;
    }

    /**
     * Check if source piece is final piece or not and throw error if any piece missing for partial import source
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return bool
     */
    public function isFinalPiece(SourceInterface $source)
    {
        /** @var Magento\Framework\Filesystem\Directory\Read $var */
        $var = $this->filesystem->getDirectoryRead(DirectoryList::VAR_DIR);

        /** @var int[] $missingPieces */
        $missingPieces = [];

        for($pieceNumber = 1; $pieceNumber <= $source->getPiecesCount(); $pieceNumber++)
        {
            /** @var string $contentFilePath */
            $contentFilePath =  $this->generateFilePath($source->getDataHash(), $pieceNumber);

            /** check piece file exist */
            if(!$var->isExist($contentFilePath))
            {
                $missingPieces[] = $pieceNumber;
            }
        }

        /** if thare are missing pieces, check if current piece is final piece or not */
        if(count($missingPieces))
        {
            /** if current piece is final piece throw an error to complete the process */
            if($source->getPiecesCount() == $source->getPieceNumber())
            {
                /** missing piece from partial import error */
                throw new ImportServiceException(
                    __('Trying to save final piece of partial import request, but there are missing pieces: %1. Please try again with missing piece to merge partial source(s)', implode(", ", $missingPieces))
                );
            }
        }
        else
            return true;

        return false;
    }

    /**
     * Check valid partial source
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return bool
     */
    public function merge(SourceInterface $source)
    {
        /** @var Magento\Framework\Filesystem\Directory\Read $var */
        $var = $this->filesystem->getDirectoryRead(DirectoryList::VAR_DIR);

        $contents = [];

        for($pieceNumber = 1; $pieceNumber <= $source->getPiecesCount(); $pieceNumber++)
        {
            try
            {
                /** @var string $contentFilePath */
                $contentFilePath =  $this->generateFilePath($source->getDataHash(), $pieceNumber);

                /** read content and remove end carriage return and new line words */
                $contents[] = rtrim($var->readFile($contentFilePath), "\r\n");
            }
            catch(\Exception $e)
            {
                /** missing piece from partial import error */
                throw new ImportServiceException(
                    __('The content from partial piece: %1 can\'t be read', $pieceNumber)
                );
            }
        }

        /** @var Magento\Framework\Filesystem\Directory\Write $var */
        $var = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);

        /** delete partial piece directory to complete the process */
        $var->delete(SourceTypeInterface::IMPORT_SOURCE_FILE_PATH . $source->getDataHash());

        return implode("\r\n", $contents);
    }

    /**
     * save source content
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return SourceInterface
     */
    public function save(SourceInterface $source)
    {
        /** @var string $contentFilePath */
        $contentFilePath =  $this->generateFilePath($source->getDataHash(), $source->getPieceNumber());

        /** @var Magento\Framework\Filesystem\Directory\Write $var */
        $var = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);

        if(!$var->writeFile($contentFilePath, $source->getImportData()))
        {
            /** @var array $lastError */
            $lastError = error_get_last();

            /** @var string $errorMessage */
            $errorMessage = isset($lastError['message']) ? $lastError['message'] : '';

            throw new ImportServiceException(
                __('Cannot create file with given source: %1', $errorMessage)
            );
        }

        /** set updated data to source */
        $source->setImportData($source->getDataHash())->setStatus(SourceInterface::STATUS_UPLOADED);

        return $source;
    }
}
