<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceCsv\Model;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\ImportService\Model\Source\PathResolverInterface;

class JsonPathResolver implements PathResolverInterface
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
        $item = json_decode($item, true);
        return $this->arrayManager->get($path, $item, null, '.');
    }

    /**
     * @inheritDoc
     */
    public function set($item, $path, $value)
    {
        $item = (isset($item)) ? json_decode($item, true) : [];
        $item = $this->arrayManager->set($path, $item, $value, '.');
        return json_encode($item);
    }
}
