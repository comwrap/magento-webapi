<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceCsv\Model;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\ImportService\Model\Source\PathResolverInterface;

class CsvPathResolver implements PathResolverInterface
{

    /**
     * @var \Magento\Framework\Stdlib\ArrayManager
     */
    private $arrayManager;

    public function __construct(
        ArrayManager $arrayManager
    ) {
        $this->arrayManager = $arrayManager;
    }

    /**
     * @inheritDoc
     */
    public function get($item, $path)
    {
        return $this->arrayManager->get($path, $item, null, '.');
    }

    /**
     * @inheritDoc
     */
    public function set($item, $path, $value)
    {
        return $this->arrayManager->set($path, $item, $value, '.');
    }
}
