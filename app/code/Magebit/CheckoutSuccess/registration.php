<?php

/**
 * @author       Niks Veinbergs
 * @copyright    Copyright (c) 2023
 */

use Magento\Framework\Component\ComponentRegistrar;

    ComponentRegistrar::register(
        ComponentRegistrar::MODULE,
        'Magebit_CheckoutSuccess',
        __DIR__
    );
