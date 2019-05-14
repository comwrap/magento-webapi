<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\ImportConfigExtensionInterface;
use Magento\ImportService\Api\Data\ImportConfigInterface;

/**
 * Class ImportConfig
 */
class ImportConfig extends AbstractExtensibleModel implements ImportConfigInterface
{
    /**
     * @inheritdoc
     */
    public function getBehaviour(): string
    {
        return $this->getData(self::BEHAVIOUR);
    }

    /**
     * @inheritdoc
     */
    public function setBehaviour(string $behaviour): void
    {
        $this->setData(self::BEHAVIOUR, $behaviour);
    }

    /**
     * @inheritdoc
     */
    public function getAllowedErrorCount(): int
    {
        return $this->getData(self::ALLOWED_ERROR_COUNT);
    }

    /**
     * @inheritdoc
     */
    public function setAllowedErrorCount(int $allowedErrorCount): void
    {
        $this->setData(self::ALLOWED_ERROR_COUNT, $allowedErrorCount);
    }

    /**
     * @inheritdoc
     */
    public function getValidationStrategy(): string
    {
        return $this->getData(self::VALIDATION_STRATEGY);
    }

    /**
     * @inheritdoc
     */
    public function setValidationStrategy(string $validationStrategy): void
    {
        $this->setData(self::VALIDATION_STRATEGY, $validationStrategy);
    }

    /**
     * @inheritdoc
     */
    public function getImportImageArchive(): string
    {
        return $this->getData(self::IMPORT_IMAGE_ARCHIVE);
    }
    /**
     * @inheritdoc
     */
    public function setImportImageArchive(string $importImageArchive): void
    {
        $this->setData(self::IMPORT_IMAGE_ARCHIVE, $importImageArchive);
    }
    /**
     * @inheritdoc
     */
    public function getImportImagesFileDir(): string
    {
        return $this->getData(self::IMPORT_IMAGES_FILE_DIR);
    }
    /**
     * @inheritdoc
     */
    public function setImportImagesFileDir(string $importImagesFileDir): void
    {
        $this->setData(self::IMPORT_IMAGES_FILE_DIR, $importImagesFileDir);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): \Magento\ImportService\Api\Data\ImportConfigExtensionInterface
    {
        $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(\Magento\ImportService\Api\Data\ImportConfigExtensionInterface $extensionAttributes): void
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
