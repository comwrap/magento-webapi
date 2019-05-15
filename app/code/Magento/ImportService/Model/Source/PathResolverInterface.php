<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source;

use Magento\Framework\Exception\NotFoundException;

interface PathResolverInterface
{
    /**
     * Get item value by path
     * @param string $path
     * @return mixed
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function get($item, $path);

    /**
     * Set item value by path
     *
     * @param mixed $item
     * @param string $path
     * @param mixed $value
     * @return mixed
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function set($item, $path, $value);
}
