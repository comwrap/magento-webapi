<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model;

/**
 * Provides import sync configuration
 */
interface ConfigInterface
{
    /**
     * Retrieve import entities configuration
     *
     * @return array
     */
    public function getEntities();

    /**
     * Retrieve import entity types configuration
     *
     * @param string $entity
     * @return array
     */
    public function getEntityTypes($entity);
}
