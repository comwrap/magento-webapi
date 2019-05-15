<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magento\Framework\HTTP\Client\Curl;
use Magento\ImportService\Api\Data\FieldMappingInterface;
use Magento\ImportService\Api\Data\ImportEntryInterface;
use Epfremme\Swagger\Factory\SwaggerFactory;
use Dflydev\DotAccessData\Data as DotAccess;
use Magento\ImportService\Api\Data\FormatInterface;

/**
 * Class ImportProcessor
 *
 * @package Magento\ImportService\Model
 */
class ImportManagement implements \Magento\ImportService\Api\ImportManagementInterface
{
    /**
     * @var \Magento\Framework\Filesystem\Directory\ReadFactory
     */
    private $readFactory;
    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    private $httpClientFactory;
    /**
     * @var \Magento\Framework\App\DeploymentConfig
     */
    private $deploymentConfig;
    /**
     * @var \Magento\Framework\HTTP\Adapter\CurlFactory
     */
    private $curlFactory;
    /**
     * @var \Magento\ImportService\Model\ProfileInterfaceFactory
     */
    private $profileFactory;
    /**
     * @var \Magento\ImportService\Model\FieldMappingInterfaceFactory
     */
    private $fieldMappingFactory;

    /**
     * ImportManagement constructor.
     *
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     * @param \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory
     * @param \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory
     */
    public function __construct(
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        ProfileInterfaceFactory $profileFactory,
        FieldMappingInterfaceFactory $fieldMappingFactory,
        CurlFactory $curlFactory
    ) {
        $this->readFactory = $readFactory;
        $this->httpClientFactory = $httpClientFactory;
        $this->deploymentConfig = $deploymentConfig;
        $this->curlFactory = $curlFactory;
        $this->profileFactory = $profileFactory;
        $this->fieldMappingFactory = $fieldMappingFactory;
    }

    /**
     * @inheritdoc
     */
    public function start($importEntry)
    {
        try {
            $source = $importEntry->getSourceId();
            $mapping = [
                'sku' => 'product.sku',
                'name' => 'product.name',
                'price' => 'product.price',
                'qty' => 'product.extension_attributes.stock_item.qty'
            ];

            $entitiesToImport = [];

            $csv = $this->getTestCsvArray();
            foreach ($csv as $row) {
                $dotAcess = new DotAccess();
                foreach ($row as $column => $value) {
                    if (isset($mapping[$column])) {
                        $dotAcess->set($mapping[$column], $value);
                    }
                }
                $entitiesToImport[] = $dotAcess->export();
            }

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return $entitiesToImport;
    }

    /**
     * @TODO remove, tmp code
     * @inheritdoc
     */
    public function startPoC()
    {
        try {
            //$source = $importEntry->getSourceId();
            $mapping = [
                'sku' => 'product.sku',
                'name' => 'product.name',
                'price' => 'product.price',
                //'attribute_set_code' => 'product.attribute_set_code',
                'qty' => 'product.extension_attributes.stock_item.qty'
            ];

            $entitiesToImport = [];

            $csv = $this->getTestCsvArray();
            foreach ($csv as $row) {
                $dotAcess = new DotAccess();
                foreach ($row as $column => $value) {
                    if (isset($mapping[$column])) {
                        $dotAcess->set($mapping[$column], $value);
                    }
                }
                $dotAcess->set('product.attribute_set_id', 4);
                $entitiesToImport[] = $dotAcess->export();
            }

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        $result = [];
        foreach ($entitiesToImport as $entity) {
            $result[] = $this->callApiService($entity);
        }

        return $result;
    }

    private function getProfile()
    {
        /** @var FormatInterface $profile */
        $profile = $this->profileFactory->create();
        $profile->setBehaviour('add_update');
        $profile->setCode('magento.catalog_product.csv_to_api');
        $profile->setFieldMapping($this->getFieldMapping());

        return $profile;
    }

    private function getFieldMapping()
    {
        $fieldsMapping = [];

        /** @var FieldMappingInterface $field */
        $field = $this->fieldMappingFactory->create();

        return $fieldsMapping;
    }

    /**
     * @TODO remove, tmp code
     */
    private function getTestCsvArray()
    {
        $csv = array_map('str_getcsv', explode(PHP_EOL, $this->getTestCsvStr()));
        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);
        return $csv;
    }

    /**
     * @TODO remove, tmp code
     */
    private function callApiService($body)
    {
        $config = $this->deploymentConfig->getConfigData('import_service');
        $magentoApiConfig = $config['magento'];
        $url = $magentoApiConfig['url'] .
            '/V1/products';
        $body = json_encode($body);

        $curlObject = $this->curlFactory->create();
        $curlObject->setConfig(
            [
                'timeout' => 18000
            ]
        );

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'cache-control: no-cache',
            "Authorization: Bearer {$magentoApiConfig['token']}"
        ];

        $curlObject->write(
            \Zend_Http_Client::POST,
            $url,
            CURL_HTTP_VERSION_NONE,
            $headers,
            $body
        );
        $curlObject->addOption(CURLOPT_FOLLOWLOCATION, true);
        $response = $curlObject->read();
        $curlObject->close();

        return $response;
    }

    /**
     * @TODO remove, tmp code
     */
    private function getTestCsvStr()
    {
        $str = <<<EOT
sku,store_view_code,attribute_set_code,product_type,categories,product_websites,name,description,short_description,weight,product_online,tax_class_name,visibility,price,special_price,special_price_from_date,special_price_to_date,url_key,meta_title,meta_keywords,meta_description,created_at,updated_at,new_from_date,new_to_date,display_product_options_in,map_price,msrp_price,map_enabled,gift_message_available,custom_design,custom_design_from,custom_design_to,custom_layout_update,page_layout,product_options_container,msrp_display_actual_price_type,country_of_manufacture,additional_attributes,qty,out_of_stock_qty,use_config_min_qty,is_qty_decimal,allow_backorders,use_config_backorders,min_cart_qty,use_config_min_sale_qty,max_cart_qty,use_config_max_sale_qty,is_in_stock,notify_on_stock_below,use_config_notify_stock_qty,manage_stock,use_config_manage_stock,use_config_qty_increments,qty_increments,use_config_enable_qty_inc,enable_qty_increments,is_decimal_divided,website_id,deferred_stock_update,use_config_deferred_stock_update,related_skus,crosssell_skus,upsell_skus,hide_from_product_page,custom_options,bundle_price_type,bundle_sku_type,bundle_price_view,bundle_weight_type,bundle_values,associated_skus
24-TEST,,Default,simple,"Default Category/Gear,Default Category/Gear/Fitness Equipment",base,Sprite Yoga Strap 6 foot 1,"<p>The Sprite Yoga Strap is your untiring partner in demanding stretches, holds and alignment routines. The strap's 100% organic cotton fabric is woven tightly to form a soft, textured yet non-slip surface. The plastic clasp buckle is easily adjustable, lightweight and urable under strain.</p><ul><li>100% soft and durable cotton.<li>Plastic cinch buckle is easy to use.<li>Three natural colors made from phthalate and heavy metal free dyes.</ul>",,1,1,Taxable Goods,"Catalog, Search",14,,,,sprite-yoga-strap-6-foot,Meta Title,"meta1, meta2, meta3",meta description,"2015-10-25 03:34:20","2015-10-25 03:34:20",,,Block after Info Column,,,,,,,,,,,Use config,,"has_options=1,quantity_and_stock_status=In Stock,required_options=0",100,0,1,0,0,1,1,0,0,1,1,,1,0,1,1,0,1,0,0,1,0,1,"24-WG087,24-WG086","24-WG087,24-WG086","24-WG087,24-WG086",,"name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=,option_title=Gold|name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=,option_title=Silver|name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=yoga3sku,option_title=Platinum",,,,,,
24-TEST-2,,Default,simple,"Default Category/Gear,Default Category/Gear/Fitness Equipment",base,Sprite Yoga Strap 6 foot 2,"<p>The Sprite Yoga Strap is your untiring partner in demanding stretches, holds and alignment routines. The strap's 100% organic cotton fabric is woven tightly to form a soft, textured yet non-slip surface. The plastic clasp buckle is easily adjustable, lightweight and urable under strain.</p><ul><li>100% soft and durable cotton.<li>Plastic cinch buckle is easy to use.<li>Three natural colors made from phthalate and heavy metal free dyes.</ul>",,1,1,Taxable Goods,"Catalog, Search",14,,,,sprite-yoga-strap-6-foot,Meta Title,"meta1, meta2, meta3",meta description,"2015-10-25 03:34:20","2015-10-25 03:34:20",,,Block after Info Column,,,,,,,,,,,Use config,,"has_options=1,quantity_and_stock_status=In Stock,required_options=0",100,0,1,0,0,1,1,0,0,1,1,,1,0,1,1,0,1,0,0,1,0,1,"24-WG087,24-WG086","24-WG087,24-WG086","24-WG087,24-WG086",,"name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=,option_title=Gold|name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=,option_title=Silver|name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=yoga3sku,option_title=Platinum",,,,,,
24-TEST-3,,Default,simple,"Default Category/Gear,Default Category/Gear/Fitness Equipment",base,Sprite Yoga Strap 6 foot 3,"<p>The Sprite Yoga Strap is your untiring partner in demanding stretches, holds and alignment routines. The strap's 100% organic cotton fabric is woven tightly to form a soft, textured yet non-slip surface. The plastic clasp buckle is easily adjustable, lightweight and urable under strain.</p><ul><li>100% soft and durable cotton.<li>Plastic cinch buckle is easy to use.<li>Three natural colors made from phthalate and heavy metal free dyes.</ul>",,1,1,Taxable Goods,"Catalog, Search",14,,,,sprite-yoga-strap-6-foot,Meta Title,"meta1, meta2, meta3",meta description,"2015-10-25 03:34:20","2015-10-25 03:34:20",,,Block after Info Column,,,,,,,,,,,Use config,,"has_options=1,quantity_and_stock_status=In Stock,required_options=0",100,0,1,0,0,1,1,0,0,1,1,,1,0,1,1,0,1,0,0,1,0,1,"24-WG087,24-WG086","24-WG087,24-WG086","24-WG087,24-WG086",,"name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=,option_title=Gold|name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=,option_title=Silver|name=Custom Yoga Option,type=drop_down,required=0,price=10.0000,price_type=fixed,sku=yoga3sku,option_title=Platinum",,,,,,
EOT;
        return $str;
    }

    /**
     * @inheritdoc
     */
    public function processImport(ImportEntryInterface $importEntry)
    {
        try {

            echo "process coming here";
            exit;
            $entityAdapter = $this->getEntityAdapter($importEntry);
            $entityAdapter->importData();

            //$factory = new SwaggerFactory();
            //$swagger = $factory->build('/var/www/html/bulk-api/async-import/var/schema_swagger.json');

            return true;

            $data = [
                'entity' => 'catalog_product',
                'behavior' => 'append',
                'validation_strategy' => 'validation-skip-errors',
                'allowed_error_count' => '10000',
                '_import_field_separator' => ',',
                '_import_multiple_value_separator' => ',',
                '_import_empty_attribute_value_constant' => '__EMPTY__VALUE__',
                'import_images_file_dir' => '',
            ];
            /** @var \Magento\ImportExport\Model\Import $importModel */
            //$importModel = $this->importModelFactory->create($data);
            //$importModel->importSource();

            /** @var \Magento\ImportService\Api\Data\ImportParamsInterface $importParams */
            $importParams = $importEntry->getImportParams();
            $entityType = $importParams->getEntityType();
            $behaviour = $importParams->getBehavior();
            $importServiceConfig = $this->importServiceConfig->getEntities();

            $source = $this->getSource($importEntry);
            $source->rewind();
            while ($source->valid()) {
                $rowData = $source->current();


                $source->next();
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param \Magento\ImportService\Api\Data\ImportEntryInterface $importEntry
     * @return \Magento\ImportService\Model\Entity\AbstractEntity
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getEntityAdapter(ImportEntryInterface $importEntry)
    {
        if (!$this->entityAdapter) {
            /** @var \Magento\ImportService\Api\Data\ImportParamsInterface $importParams */
            $importParams = $importEntry->getImportParams();
            $fieldsMapping = $importEntry->getFieldMapping();

            $entityType = $importParams->getEntityType();
            $entities = $this->importServiceConfig->getEntities();
            if (isset($entities[$entityType])) {
                try {
                    $this->entityAdapter = $this->entityFactory->create($entities[$entityType]['model']);
                } catch (\Exception $e) {
                    $t = 1;
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('Please enter a correct entity model.')
                    );
                }
                if (!$this->entityAdapter instanceof \Magento\ImportService\Model\Entity\AbstractEntity) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __(
                            'The entity adapter object must be an instance of %1 or %2.',
                            \Magento\ImportExport\Model\Import\Entity\AbstractEntity::class,
                            \Magento\ImportExport\Model\Import\AbstractEntity::class
                        )
                    );
                }

                // check for entity codes integrity
                if ($entityType != $this->entityAdapter->getEntityTypeCode()) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('The input entity code is not equal to entity adapter code.')
                    );
                }
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(__('Please enter a correct entity.'));
            }
            $this->entityAdapter->setParameters($importParams);
            $this->entityAdapter->setFieldMapping($fieldsMapping);
            $source = $this->getSource($importEntry);
            $this->entityAdapter->setSource($source);
        }
        return $this->entityAdapter;
    }

    /**
     * @param \Magento\ImportService\Api\Data\ImportEntryInterface $importEntry
     * @return \Magento\ImportExport\Model\Import\AbstractSource
     */
    private function getSource(ImportEntryInterface $importEntry)
    {
        $file = $this->typePool->getFileForType(
            $importEntry->getSource()->getType(),
            $importEntry->getSource()->getImportData()
        );
        $fileName = (string)$file;
        $path = pathinfo($fileName, PATHINFO_DIRNAME);
        $directory = $this->readFactory->create($path);
        $source = $this->fileTypePool->findAdapterFor(
            $importEntry->getSource()->getFileType(),
            $directory,
            $fileName,
            $importEntry->getImportParams()
        );
        $source->rewind();
        return $source;
    }
}
