<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceCsv\Model\Reader;

use Magento\ImportExport\Model\Import\AbstractEntity;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\Source\ReaderAbstract;
use Magento\ImportService\Model\Source\ReaderInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\ImportServiceCsv\Model\SourceCsv;
use Magento\ImportServiceCsv\Model\SourceCsvFactory;
use Magento\ImportServiceCsv\Model\SourceFormatCsv;

/**
 * CSV Reader Implementation
 */
class Csv extends ReaderAbstract implements ReaderInterface
{

    /**
     * @var array
     */
    protected $_colNames = [];

    /**
     * Quantity of columns
     *
     * @var int
     */
    protected $_colQty;

    /**
     * Current row
     *
     * @var array
     */
    protected $_row = [];

    /**
     * Current row number
     * -1 means "out of bounds"
     *
     * @var int
     */
    protected $_key = -1;

    /**
     * @var bool
     */
    protected $_foundWrongQuoteFlag = false;

    /**
     * @var \Magento\Framework\Filesystem\File\Read
     */
    protected $_file;

    /**
     * Delimiter.
     *
     * @var string
     */
    protected $_delimiter = ',';

    /**
     * @var string
     */
    protected $_enclosure = '';
    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;
    /**
     * @var \Magento\ImportServiceCsv\Model\Readerr\SourceCsvFactory
     */
    private $sourceCsvFactory;

    /**
     * @var \Magento\ImportService\Api\Data\SourceInterface
     */
    private $source;

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        SourceCsvFactory $sourceCsvFactory
    ) {
        register_shutdown_function([$this, 'destruct']);
        $this->filesystem = $filesystem;
        $this->sourceCsvFactory = $sourceCsvFactory;
    }

    public function init(SourceInterface $source, $filePath)
    {
        try {
            $directory = $this->filesystem->getDirectoryRead('var');
            $this->_file = $directory->openFile($directory->getRelativePath($filePath), 'r');
        } catch (\Magento\Framework\Exception\FileSystemException $e) {
            throw new \LogicException("Unable to open file: '{$filePath}'");
        }

        $this->source = $source;
        //$format = $source->getFormat();//string because SourceInterface loaded instead of CsvSourceInterface
        $this->_delimiter = ',';
        $this->_enclosure = '"';
        $colNames = $this->_getNextRow();
        $this->_colNames = $colNames;
        $this->_colQty = count($colNames);
    }

    /**
     * Close file handle
     *
     * @return void
     */
    public function destruct()
    {
        if (is_object($this->_file)) {
            $this->_file->close();
        }
    }

    /**
     * Read next line from CSV-file
     *
     * @return array|bool
     */
    protected function _getNextRow()
    {
        $parsed = $this->_file->readCsv(0, $this->_delimiter, $this->_enclosure);
        if (is_array($parsed) && count($parsed) != $this->_colQty) {
            foreach ($parsed as $element) {
                if (strpos($element, "'") !== false) {
                    $this->_foundWrongQuoteFlag = true;
                    break;
                }
            }
        } else {
            $this->_foundWrongQuoteFlag = false;
        }
        return is_array($parsed) ? $parsed : [];
    }

    /**
     * Rewind the \Iterator to the first element (\Iterator interface)
     *
     * @return void
     */
    public function rewind()
    {
        $this->_file->seek(0);
        $this->_getNextRow();
        // skip first line with the header
        $this->_key = -1;
        $this->_row = [];
        $this->next();
    }

    /**
     * Column names getter.
     *
     * @return array
     */
    public function getColNames()
    {
        return $this->_colNames;
    }

    /**
     * Return the current element
     * Returns the row in associative array format: array(<col_name> =>
     * <value>, ...)
     *
     * @return array
     */
    public function current()
    {
        $row = $this->_row;
        if (count($row) != $this->_colQty) {
            if ($this->_foundWrongQuoteFlag) {
                throw new \InvalidArgumentException(AbstractEntity::ERROR_CODE_WRONG_QUOTES);
            } else {
                throw new \InvalidArgumentException(AbstractEntity::ERROR_CODE_COLUMNS_NUMBER);
            }
        }
        return array_combine($this->_colNames, $row);
    }

    /**
     * Move forward to next element (\Iterator interface)
     *
     * @return void
     */
    public function next()
    {
        $this->_key++;
        $row = $this->_getNextRow();
        if (false === $row || [] === $row) {
            $this->_row = [];
            $this->_key = -1;
        } else {
            $this->_row = $row;
        }
    }

    /**
     * Return the key of the current element (\Iterator interface)
     *
     * @return int -1 if out of bounds, 0 or more otherwise
     */
    public function key()
    {
        return $this->_key;
    }

    /**
     * Checks if current position is valid (\Iterator interface)
     *
     * @return bool
     */
    public function valid()
    {
        return -1 !== $this->_key;
    }

    /**
     * Seeks to a position (Seekable interface)
     *
     * @param int $position The position to seek to 0 or more
     * @return void
     * @throws \OutOfBoundsException
     */
    public function seek($position)
    {
        if ($position == $this->_key) {
            return;
        }
        if (0 == $position || $position < $this->_key) {
            $this->rewind();
        }
        if ($position > 0) {
            do {
                $this->next();
                if ($this->_key == $position) {
                    return;
                }
            } while ($this->_key != -1);
        }
        throw new \OutOfBoundsException('Please correct the seek position.');
    }
}
