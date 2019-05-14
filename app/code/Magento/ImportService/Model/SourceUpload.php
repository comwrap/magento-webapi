<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\ImportService\Api\SourceUploadInterface;
use Magento\ImportService\Model\Import\Type\FileSourceType;

/**
 * Class SourceUpload
 */
class SourceUpload implements SourceUploadInterface
{

    /**
     * @var SourceProcessorPool
     */
    protected $sourceProcessorPool;

    /**
     * @var SourceUploadResponse
     */
    protected $responseFactory;

    /**
     * @param SourceUploadResponseFactory $responseFactory
     * @param SourceProcessorPool $sourceProcessorPool
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceProcessorPool $sourceProcessorPool
    ) {
        $this->sourceProcessorPool = $sourceProcessorPool;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param string $sourceType
     * @param SourceInterface $source
     * @return SourceUploadResponseFactory
     */
    public function execute(string $sourceType, SourceInterface $source)
    {
        try {
            $source->setSourceType($sourceType);
            $processor = $this->sourceProcessorPool->getProcessor($source);
            $response = $this->responseFactory->create();
            $processor->processUpload($source, $response);
        } catch (\Exception $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }
        return $response;
    }
}
