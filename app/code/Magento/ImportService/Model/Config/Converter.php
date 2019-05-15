<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\Config;

use Magento\Framework\Module\Manager;
use Magento\Framework\App\Utility\Classes;

class Converter implements \Magento\Framework\Config\ConverterInterface
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    private $moduleManager;

    /**
     * @param Manager $moduleManager
     */
    public function __construct(Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    /**
     * Convert dom node tree to array
     *
     * @param \DOMDocument $source
     * @return array
     * @throws \InvalidArgumentException
     */
    public function convert($source)
    {
        return [];
        $output = ['imports' => []];
        /** @var \DOMNodeList $entities */
        $entities = $source->getElementsByTagName('import');
        /** @var \DOMElement $import */
        foreach ($entities as $import) {
            if ($import->nodeType != XML_ELEMENT_NODE) {
                continue;
            }
            $type = $import->attributes->getNamedItem('type')->nodeValue;

            /** @var \DOMElement $service */
            $mappingProcessor = $import->getElementsByTagName('mappingProcessor')->item(0);
            $mpSourceClass = $mappingProcessor->attributes->getNamedItem('sourceClass')->nodeValue;
            $mpTargetClass = $mappingProcessor->attributes->getNamedItem('targetClass')->nodeValue;

            $behaviours = $import->getElementsByTagName('behaviours')->item(0);
            $behavioursEl = $behaviours->getElementsByTagName('behaviour');
            /** @var \DOMElement $behaviour */
            foreach ($behavioursEl as $behaviour) {
                $behaviourCode = $behaviour->attributes->getNamedItem('code')->nodeValue;
            }

            if (!$this->isModelEnabled($mpSourceClass) || !$this->isModelEnabled($mpTargetClass)) {
                continue;
            }
            $output['imports'][$type] = [
                'type' => $type,
                'behaviors' => $label,
                'mappingProcessor' => $behavior,
                'mappingFields' => $apiEndpoint,
            ];
        }

        /** @var \DOMNodeList $entityTypes */
        $entityTypes = $source->getElementsByTagName('entityType');
        /** @var \DOMNode $entityTypeConfig */
        foreach ($entityTypes as $entityTypeConfig) {
            $attributes = $entityTypeConfig->attributes;
            $name = $attributes->getNamedItem('name')->nodeValue;
            $model = $attributes->getNamedItem('model')->nodeValue;
            $entity = $attributes->getNamedItem('entity')->nodeValue;

            if (isset($output['entities'][$entity])) {
                $output['entities'][$entity]['types'][$name] = [
                    'name' => $name,
                    'model' => $model
                ];
            }
        }

        return $output;
    }

    private function isModelEnabled($model)
    {
        return $this->moduleManager->isEnabled(Classes::getClassModuleName($model));
    }
}
