<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface PartialSourceInterface
 */
interface PartialSourceInterface extends SourceInterface
{
    const DATA_HASH = 'data_hash';
    const PIECES_COUNT = 'pieces_count';
    const PIECE_NUMBER = 'piece_number';

    /**
     * Retrieve data source type
     *
     * @return string
     */
    public function getDataHash();

    /**
     * Set data hash sha256
     *
     * @param string $dataHash
     * @return $this
     */
    public function setDataHash($dataHash);

    /**
     * Retrieve total source pieces count
     *
     * @return int
     */
    public function getPiecesCount();

    /**
     * Set total source pieces count
     *
     * @param int $piecesCount
     * @return $this
     */
    public function setPiecesCount($piecesCount);

    /**
     * Get current piece number
     *
     * @return int
     */
    public function getPieceNumber();

    /**
     * Set current piece number
     *
     * @param int $pieceNumber
     * @return $this
     */
    public function setPieceNumber($pieceNumber);
}
