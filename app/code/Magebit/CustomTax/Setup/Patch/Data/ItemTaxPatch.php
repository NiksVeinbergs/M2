<?php

/**
 * Magebit_CustomTax
 *
 * @category     Magebit
 * @package      Magebit_CustomTax
 * @author       Niks Veinbergs
 * @copyright    Copyright (c) 2023 Magebit, Ltd.(https://www.magebit.com/)
 */
declare(strict_types=1);

namespace Magebit\CustomTax\Setup\Patch\Data;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Tax\Api\Data\TaxRateInterfaceFactory;
use Magento\Tax\Api\Data\TaxRuleInterfaceFactory;
use Magento\Tax\Api\TaxRateRepositoryInterface;
use Magento\Tax\Model\TaxRuleRepository;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollectionFactory;
use Magento\Tax\Model\ClassModel;
use Magento\Tax\Api\TaxClassRepositoryInterface;
use Magento\Tax\Model\ClassModelFactory;

/**
 * Class ItemTaxPatch
 */
class ItemTaxPatch implements DataPatchInterface
{
    /**
     *Constants for Default Customer Tax Class and Product Tax Class
     */
    const DEFAULT_CUSTOMER_TAX_CLASS_ID = 3;
    const DEFAULT_PRODUCT_TAX_CLASS_ID = 2;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var TaxRateInterfaceFactory
     */
    private $taxRateFactory;
    /**
     * @var TaxRuleInterfaceFactory
     */
    private $taxRuleFactory;
    /**
     * @var TaxRateRepositoryInterface
     */
    private $taxRateRepository;
    /**
     * @var TaxRuleRepository
     */
    private $taxRuleRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var State
     */
    private $appState;

    /**
     * @var ProductFactory
     */
    private $productFactory;
    /**
     * @var CountryCollectionFactory
     */
    private $countryCollectionFactory;
    /**
     * @var TaxClassRepositoryInterface
     */
    private $taxClassRepository;
    /**
     * @var ClassModelFactory
     */
    private $taxClassFactory;


    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param TaxRateInterfaceFactory $taxRateFactory
     * @param TaxRuleInterfaceFactory $taxRuleFactory
     * @param TaxRateRepositoryInterface $taxRateRepository
     * @param TaxRuleRepository $taxRuleRepository
     * @param ProductFactory $productFactory
     * @param ProductRepository $productRepository
     * @param State $appState
     * @param CountryCollectionFactory $countryCollectionFactory
     * @param TaxClassRepositoryInterface $taxClassRepository
     * @param ClassModelFactory $taxClassFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        TaxRateInterfaceFactory $taxRateFactory,
        TaxRuleInterfaceFactory $taxRuleFactory,
        TaxRateRepositoryInterface $taxRateRepository,
        TaxRuleRepository $taxRuleRepository,
        ProductFactory $productFactory,
        ProductRepository $productRepository,
        State $appState,
        CountryCollectionFactory $countryCollectionFactory,
        TaxClassRepositoryInterface $taxClassRepository,
        ClassModelFactory $taxClassFactory,
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->taxRateFactory = $taxRateFactory;
        $this->taxRuleFactory = $taxRuleFactory;
        $this->taxRateRepository = $taxRateRepository;
        $this->taxRuleRepository = $taxRuleRepository;
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->appState = $appState;
        $this->countryCollectionFactory = $countryCollectionFactory;
        $this->taxClassRepository = $taxClassRepository;
        $this->taxClassFactory = $taxClassFactory;
    }

    /**
     * Description.
     *Data patch creates Custom product, Taxes for all countries, new Tax class for custom product and
     * add 2 new Tax rules.
     *
     * @return void
     * @throws InputException
     * @throws LocalizedException
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function apply(): void
    {
        $this->appState->setAreaCode(Area::AREA_ADMINHTML);
        $this->moduleDataSetup->startSetup();
        $taxRateIdArray[] = [];
        $allCountries = $this->countryCollectionFactory->create()->loadData()->toOptionArray(false);

        //Create Tax Class for Single Item
        $taxClass = $this->taxClassFactory->create();
        $taxClass->setClassName('Tax Class For Custom Product')
            ->setClassType(ClassModel::TAX_CLASS_TYPE_PRODUCT);
        $taxClassID = $this->taxClassRepository->save($taxClass);

        //Create Great Britain Tax Rate
        $taxRate = $this->taxRateFactory->create();
        $taxRate->setCode('Great Britain')
            ->setRate('20')
            ->setTaxCountryId('GB')
            ->setTaxPostcode('*');
        $taxRate = $this->taxRateRepository->save($taxRate);

        //Add Tax Rule for Great Britain Tax Rate to Default Product Tax Class and newly Created Custom Product Tax
        $taxRuleDataObject = $this->taxRuleFactory->create();
        $taxRuleDataObject->setCode('Great Britain')
            ->setTaxRateIds([$taxRate->getId()])
            ->setCustomerTaxClassIds([self::DEFAULT_CUSTOMER_TAX_CLASS_ID])
            ->setProductTaxClassIds([self::DEFAULT_PRODUCT_TAX_CLASS_ID, $taxClassID])
            ->setPriority(0)
            ->setPosition(0);
        $this->taxRuleRepository->save($taxRuleDataObject);

        //Create 5% Tax For Each Country
        foreach ($allCountries as $country) {
            $taxRate = $this->taxRateFactory->create();
            $taxRate->setCode($country['value'] . '_TAX_RATE')
                ->setTaxCountryId($country['value'])
                ->setRate(5)
                ->setTaxPostcode('*');
            $taxRate = $this->taxRateRepository->save($taxRate);
            $taxRateIdArray[] = $taxRate->getId();
        }

        //Create Tax Rule for just made tax rates
        $taxRule = $this->taxRuleFactory->create()
            ->setCode('Tax Rule for Custom Product')
            ->setCustomerTaxClassIds([self::DEFAULT_CUSTOMER_TAX_CLASS_ID])
            ->setProductTaxClassIds([$taxClassID])
            ->setTaxRateIds($taxRateIdArray)
            ->setPriority(0)
            ->setPosition(0);
        $this->taxRuleRepository->save($taxRule);

        //Make New Product and set custom tax class
        $product = $this->productFactory->create();
        $product->setName('Custom made product')
            ->setPrice(20)
            ->setSku('12233524')
            ->setAttributeSetId(4)
            ->setData('tax_class_id', $taxClassID);
        $this->productRepository->save($product);
    }

    /**
     * Description.
     *
     * @return array|string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Description.
     *
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
