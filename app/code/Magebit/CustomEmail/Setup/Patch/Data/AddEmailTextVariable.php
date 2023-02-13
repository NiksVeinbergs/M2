<?php

/**
 * SchemaPatch
 *
 * @category     Magebit
 * @package      Magebit_CustomEmail
 * @author       Niks Veinbergs
 * @copyright    Copyright (c) 2023 Magebit, Ltd.(https://www.magebit.com/)
 */

declare(strict_types=1);

namespace Magebit\CustomEmail\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class AddEmailTextVariable
 */
class AddEmailTextVariable implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Description.
     *Add email-text Custom variable to variable table
     *
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();

        $data[] = [
            'code' => 'email-text',
            'name' => 'email-text'
        ];

        $this->moduleDataSetup->getConnection()->insertArray(
            $this->moduleDataSetup->getTable('variable'),
            ['code', 'name'],
            $data
        );
        $this->moduleDataSetup->endSetup();
    }

    /**
     * Description.
     *
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
     *
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
