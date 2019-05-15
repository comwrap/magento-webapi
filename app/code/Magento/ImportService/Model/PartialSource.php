<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\PartialSourceInterface;

/**
 * Class PartialSource
 */
class PartialSource extends Source implements PartialSourceInterface
{
    /**
     * @inheritDoc
     */
    public function getDataHash()
    {
        return $this->getData(self::DATA_HASH);
    }

    /**
     * @inheritDoc
     */
    public function setDataHash($dataHash)
    {
        return $this->setData(self::DATA_HASH, $dataHash);
    }

    /**
     * @inheritDoc
     */
    public function getPiecesCount()
    {
        return $this->getData(self::PIECES_COUNT);
    }

    /**
     * @inheritDoc
     */
    public function setPiecesCount($piecesCount)
    {
        return $this->setData(self::PIECES_COUNT, $piecesCount);
    }

    /**
     * @inheritDoc
     */
    public function getPieceNumber()
    {
        return $this->getData(self::PIECE_NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setPieceNumber($pieceNumber)
    {
        return $this->setData(self::PIECE_NUMBER, $pieceNumber);
    }
}
