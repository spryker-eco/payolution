<?php

/**
 * Copy over the following configs to your config
 */

use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Zed\Oms\OmsConfig;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEco\Shared\Payolution\PayolutionConstants;

$config[PayolutionConstants::TRANSACTION_GATEWAY_URL] = '';
$config[PayolutionConstants::CALCULATION_GATEWAY_URL] = '';
$config[PayolutionConstants::TRANSACTION_SECURITY_SENDER] = '';
$config[PayolutionConstants::TRANSACTION_USER_LOGIN] = '';
$config[PayolutionConstants::TRANSACTION_USER_PASSWORD] = '';
$config[PayolutionConstants::CALCULATION_SENDER] = '';
$config[PayolutionConstants::CALCULATION_USER_LOGIN] = '';
$config[PayolutionConstants::CALCULATION_USER_PASSWORD] = '';
$config[PayolutionConstants::TRANSACTION_MODE] = '';
$config[PayolutionConstants::CALCULATION_MODE] = '';
$config[PayolutionConstants::TRANSACTION_CHANNEL_PRE_CHECK] = '';
$config[PayolutionConstants::TRANSACTION_CHANNEL_INVOICE] = '';
$config[PayolutionConstants::TRANSACTION_CHANNEL_INSTALLMENT] = '';
$config[PayolutionConstants::CALCULATION_CHANNEL] = '';
$config[PayolutionConstants::MIN_ORDER_GRAND_TOTAL_INVOICE] = '';
$config[PayolutionConstants::MAX_ORDER_GRAND_TOTAL_INVOICE] = '';
$config[PayolutionConstants::MIN_ORDER_GRAND_TOTAL_INSTALLMENT] = '';
$config[PayolutionConstants::MAX_ORDER_GRAND_TOTAL_INSTALLMENT] = '';
$config[PayolutionConstants::PAYOLUTION_BCC_EMAIL_ADDRESS] = '';

$config[OmsConstants::PROCESS_LOCATION] = [
    OmsConfig::DEFAULT_PROCESS_LOCATION,
    APPLICATION_VENDOR_DIR . '/spryker-eco/payolution/config/Zed/Oms',
];

$config[OmsConstants::ACTIVE_PROCESSES] = [
    'PayolutionInstalmentPayment01',
    'PayolutionInvoicePayment01',
];

$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    PayolutionConfig::PAYMENT_METHOD_INSTALLMENT => 'PayolutionInstalmentPayment01',
    PayolutionConfig::PAYMENT_METHOD_INVOICE => 'PayolutionInvoicePayment01',
];
