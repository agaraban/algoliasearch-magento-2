<?php

namespace Algolia\AlgoliaSearch\Factory;

use Magento\Framework\Module\Manager;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CatalogPermissionsFactory
{
    const CATALOG_PERMISSIONS_ENABLED_CONFIG_PATH = 'catalog/magento_catalogpermissions/enabled';

    private $scopeConfig;
    private $moduleManager;
    private $objectManager;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Manager $moduleManager,
        ObjectManagerInterface $objectManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->moduleManager = $moduleManager;
        $this->objectManager = $objectManager;
    }

    public function isCatalogPermissionsEnabled($storeId)
    {
        return $this->scopeConfig->isSetFlag(
            self::CATALOG_PERMISSIONS_ENABLED_CONFIG_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function isCatalogPermissionsModuleEnabled()
    {
        return $this->moduleManager->isEnabled('Magento_CatalogPermissions');
    }

    public function getPermissionsIndex()
    {
        return $this->isCatalogPermissionsModuleEnabled() ?
            $this->objectManager->create('\Magento\CatalogPermissions\Model\Permission\Index') : false;
    }

    public function getPermissionsHelper()
    {
        return $this->isCatalogPermissionsModuleEnabled() ?
            $this->objectManager->create('\Magento\CatalogPermissions\Helper\Data') : false;
    }
}
