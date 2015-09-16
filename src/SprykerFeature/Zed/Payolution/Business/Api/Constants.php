<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerFeature\Zed\Payolution\Business\Api;

use SprykerFeature\Shared\Library\ConfigInterface;

interface Constants extends ConfigInterface
{

    const PAYMENT_CODE_PRE_CHECK = 'VA.PA';
    const PAYMENT_CODE_PRE_AUTHORIZATION = 'VA.PA';
    const PAYMENT_CODE_RE_AUTHORIZACTION = 'VA.PA';
    const PAYMENT_CODE_CAPTURE = 'VA.CP';
    const PAYMENT_CODE_REVERSAL = 'VA.RV';
    const PAYMENT_CODE_REFUND = 'VA.RF';

    const TRANSACTION_MODE_TEST = 'CONNECTOR_TEST';
    const TRANSACTION_MODE_LIVE = 'LIVE';

    const SEX_MALE = 'M';
    const SEX_FEMALE = 'F';

    const ACCOUNT_BRAND_INVOICE = 'PAYOLUTION_INVOICE';
    const ACCOUNT_BRAND_INSTALLMENT = 'PAYOLUTION_INS';

    const STATUS_CODE_SUCCESS = '90';
    const REASON_CODE_SUCCESS = '00';
    const STATUS_REASON_CODE_SUCCESS = self::STATUS_CODE_SUCCESS . '.' . self::REASON_CODE_SUCCESS;

    /**
     * Analysis/Criteria keys
     */
    const CRITERION_CSS_PATH = 'PAYOLUTION_CSS_PATH';
    const CRITERION_REQUEST_SYSTEM_VENDOR = 'PAYOLUTION_REQUEST_SYSTEM_VENDOR';
    const CRITERION_REQUEST_SYSTEM_VERSION = 'PAYOLUTION_REQUEST_SYSTEM_VERSION';
    const CRITERION_REQUEST_TYPE = 'PAYOLUTION_REQUEST_TYPE';
    const CRITERION_MODULE_NAME = 'PAYOLUTION_MODULE_NAME';
    const CRITERION_MODULE_VERSION = 'PAYOLUTION_MODULE_VERSION';
    const CRITERION_SHIPPING_STREET = 'PAYOLUTION_SHIPPING_STREET';
    const CRITERION_SHIPPING_ZIP = 'PAYOLUTION_SHIPPING_ZIP';
    const CRITERION_SHIPPING_CITY = 'PAYOLUTION_SHIPPING_CITY';
    const CRITERION_SHIPPING_STATE = 'PAYOLUTION_SHIPPING_STATE';
    const CRITERION_SHIPPING_COUNTRY = 'PAYOLUTION_SHIPPING_COUNTRY';
    const CRITERION_SHIPPING_GIVEN = 'PAYOLUTION_SHIPPING_GIVEN';
    const CRITERION_SHIPPING_FAMILY = 'PAYOLUTION_SHIPPING_FAMILY';
    const CRITERION_SHIPPING_COMPANY = 'PAYOLUTION_SHIPPING_COMPANY';
    const CRITERION_SHIPPING_ADDITIONAL = 'PAYOLUTION_SHIPPING_ADDITIONAL';
    const CRITERION_SHIPPING_TYPE = 'PAYOLUTION_SHIPPING_TYPE';
    const CRITERION_TRANSPORTATION_COMPANY = 'PAYOLUTION_TRANSPORTATION_COMPANY';
    const CRITERION_TRANSPORTATION_TRACKING = 'PAYOLUTION_TRANSPORTATION_TRACKING';
    const CRITERION_TRANSPORTATION_RETURN_TRACKING = 'PAYOLUTION_TRANSPORTATION_RETURN_TRACKING';
    const CRITERION_ITEM_DESCR_XX = 'PAYOLUTION_DESCR_XX';
    const CRITERION_ITEM_PRICE_XX = 'PAYOLUTION_PRICE_XX';
    const CRITERION_ITEM_TAX_XX = 'PAYOLUTION_TAX_XX';
    const CRITERION_ITEM_CATEGORY_XX = 'PAYOLUTION_CATEGORY_XX';
    const CRITERION_TAX_AMOUNT = 'PAYOLUTION_TAX_AMOUNT';
    const CRITERION_PRE_CHECK = 'PAYOLUTION_PRE_CHECK';
    const CRITERION_PRE_CHECK_ID = 'PAYOLUTION_PRE_CHECK_ID';
    const CRITERION_TRX_TYPE = 'PAYOLUTION_TRX_TYPE';
    const CRITERION_COMPANY_NAME = 'PAYOLUTION_COMPANY_NAME';
    const CRITERION_COMPANY_UID = 'PAYOLUTION_COMPANY_UID';
    const CRITERION_COMPANY_TRADEREGISTRY_NUMBER = 'PAYOLUTION_COMPANY_TRADEREGISTRY_NUMBER';
    const CRITERION_INSTALLMENT_AMOUNT = 'PAYOLUTION_INSTALLMENT_AMOUNT';
    const CRITERION_DURATION = 'PAYOLUTION_DURATION';
    const CRITERION_ACCOUNT_COUNTRY = 'PAYOLUTION_ACCOUNT_COUNTRY';
    const CRITERION_ACCOUNT_HOLDER = 'PAYOLUTION_ACCOUNT_HOLDER';
    const CRITERION_ACCOUNT_BIC = 'PAYOLUTION_ACCOUNT_BIC';
    const CRITERION_ACCOUNT_IBAN = 'PAYOLUTION_ACCOUNT_IBAN';
    const CRITERION_CUSTOMER_LANGUAGE = 'PAYOLUTION_CUSTOMER_LANGUAGE';
    const CRITERION_CUSTOMER_NUMBER = 'PAYOLUTION_CUSTOMER_NUMBER';
    const CRITERION_CUSTOMER_GROUP = 'PAYOLUTION_CUSTOMER_GROUP';
    const CRITERION_CUSTOMER_CONFIRMED_ORDERS = 'PAYOLUTION_CUSTOMER_CONFIRMED_ORDERS';
    const CRITERION_CUSTOMER_CONFIRMED_AMOUNT = 'PAYOLUTION_CUSTOMER_CONFIRMED_AMOUNT';
    const CRITERION_CUSTOMER_INTERNAL_SCORE = 'PAYOLUTION_CUSTOMER_INTERNAL_SCORE';
    const CRITERION_WEBSHOP_URL = 'PAYOLUTION_WEBSHOP_URL';

    /**
     * Available values for CRITERION_SHIPPING_TYPE
     */
    const CRITERION_SHIPPING_TYPE_BRANCH_PICKUP = 'BRANCH_PICKUP';
    const CRITERION_SHIPPING_TYPE_POST_OFFICE_PICKUP = 'POST_OFFICE_PICKUP';
    const CRITERION_SHIPPING_TYPE_PACK_STATION = 'PACK_STATION';

}
