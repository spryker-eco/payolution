<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business\Payment\Method;

interface ApiConfig
{
    public const ACCOUNT_BRAND = 'ACCOUNT.BRAND';

    public const TRANSACTION_MODE = 'TRANSACTION.MODE';
    public const TRANSACTION_MODE_TEST = 'CONNECTOR_TEST';
    public const TRANSACTION_MODE_LIVE = 'LIVE';
    public const TRANSACTION_CHANNEL = 'TRANSACTION.CHANNEL';

    public const SECURITY_SENDER = 'SECURITY.SENDER';
    public const USER_LOGIN = 'USER.LOGIN';
    public const USER_PWD = 'USER.PWD';

    public const PRESENTATION_AMOUNT = 'PRESENTATION.AMOUNT';
    public const PRESENTATION_USAGE = 'PRESENTATION.USAGE';
    public const PRESENTATION_CURRENCY = 'PRESENTATION.CURRENCY';

    public const IDENTIFICATION_TRANSACTIONID = 'IDENTIFICATION.TRANSACTIONID';
    public const IDENTIFICATION_SHOPPERID = 'IDENTIFICATION.SHOPPERID';
    public const IDENTIFICATION_REFERENCEID = 'IDENTIFICATION.REFERENCEID';

    public const NAME_GIVEN = 'NAME.GIVEN';
    public const NAME_FAMILY = 'NAME.FAMILY';
    public const NAME_TITLE = 'NAME.TITLE';
    public const NAME_SEX = 'NAME.SEX';
    public const NAME_BIRTHDATE = 'NAME.BIRTHDATE';

    public const SEX_MALE = 'M';
    public const SEX_FEMALE = 'F';

    public const ADDRESS_STREET = 'ADDRESS.STREET';
    public const ADDRESS_ZIP = 'ADDRESS.ZIP';
    public const ADDRESS_CITY = 'ADDRESS.CITY';
    public const ADDRESS_COUNTRY = 'ADDRESS.COUNTRY';

    public const CONTACT_EMAIL = 'CONTACT.EMAIL';
    public const CONTACT_PHONE = 'CONTACT.PHONE';
    public const CONTACT_MOBILE = 'CONTACT.MOBILE';
    public const CONTACT_IP = 'CONTACT.IP';

    public const PAYMENT_CODE = 'PAYMENT.CODE';

    public const PAYMENT_CODE_PRE_CHECK = 'VA.PA';
    public const PAYMENT_CODE_PRE_AUTHORIZATION = 'VA.PA';
    public const PAYMENT_CODE_RE_AUTHORIZATION = 'VA.PA';
    public const PAYMENT_CODE_CAPTURE = 'VA.CP';
    public const PAYMENT_CODE_REVERSAL = 'VA.RV';
    public const PAYMENT_CODE_REFUND = 'VA.RF';

    public const TRANSACTION_REQUEST_CONTENT_TYPE = 'FORM';
    public const CALCULATION_REQUEST_CONTENT_TYPE = 'XML';

    public const STATUS_CODE_SUCCESS = '90';
    public const REASON_CODE_SUCCESS = '00';
    public const STATUS_REASON_CODE_SUCCESS = self::STATUS_CODE_SUCCESS . '.' . self::REASON_CODE_SUCCESS;

    public const CALCULATION_REQUEST_VERSION = '2.0';
    public const CALCULATION_OPERATION_TYPE = 'CALCULATION';
    public const CALCULATION_PAYMENT_TYPE = 'INSTALLMENT';
    public const CALCULATION_TARGET_COUNTRY = 'PAYOLUTION_CALCULATION_TARGET_COUNTRY';

    /**
     * Calculation request XML
     */
    public const CALCULATION_XML_ELEMENT_NAME = 'name';
    public const CALCULATION_XML_ELEMENT_ATTRIBUTES = 'attributes';
    public const CALCULATION_XML_ELEMENT_VALUE = 'value';
    public const CALCULATION_XML_REQUEST_ELEMENT = 'Request';
    public const CALCULATION_XML_REQUEST_VERSION_ATTRIBUTE = 'version';
    public const CALCULATION_XML_SENDER_ELEMENT = 'Sender';
    public const CALCULATION_XML_TRANSACTION_ELEMENT = 'Transaction';
    public const CALCULATION_XML_TRANSACTION_MODE_ATTRIBUTE = 'mode';
    public const CALCULATION_XML_TRANSACTION_CHANNEL_ATTRIBUTE = 'channel';
    public const CALCULATION_XML_IDENTIFICATION_ELEMENT = 'Identification';
    public const CALCULATION_XML_TRANSACTIONID_ELEMENT = 'TransactionID';
    public const CALCULATION_XML_PAYMENT_ELEMENT = 'Payment';
    public const CALCULATION_XML_OPERATION_TYPE_ELEMENT = 'OperationType';
    public const CALCULATION_XML_PAYMENT_TYPE_ELEMENT = 'PaymentType';
    public const CALCULATION_XML_PRESENTATION_ELEMENT = 'Presentation';
    public const CALCULATION_XML_CURRENCY_ELEMENT = 'Currency';
    public const CALCULATION_XML_USAGE_ELEMENT = 'Usage';
    public const CALCULATION_XML_AMOUNT_ELEMENT = 'Amount';
    public const CALCULATION_XML_VAT_ELEMENT = 'VAT';
    public const CALCULATION_XML_ANALYSIS_ELEMENT = 'Analysis';
    public const CALCULATION_XML_CRITERION_ELEMENT = 'Criterion';

    /**
     * Analysis Criteria keys
     */
    public const CRITERION_CSS_PATH = 'CRITERION.PAYOLUTION_CSS_PATH';

    public const CRITERION_REQUEST_SYSTEM_VENDOR = 'CRITERION.PAYOLUTION_REQUEST_SYSTEM_VENDOR';
    public const CRITERION_REQUEST_SYSTEM_VERSION = 'CRITERION.PAYOLUTION_REQUEST_SYSTEM_VERSION';
    public const CRITERION_REQUEST_SYSTEM_TYPE = 'CRITERION.PAYOLUTION_REQUEST_SYSTEM_TYPE';
    public const CRITERION_REQUEST_SYSTEM_VENDOR_VALUE = 'Spryker';
    public const CRITERION_REQUEST_SYSTEM_VERSION_VALUE = '1.0'; //@todo #360 ddmoshop
    public const CRITERION_REQUEST_SYSTEM_TYPE_VALUE = 'Webshop';

    public const CRITERION_MODULE_NAME = 'CRITERION.PAYOLUTION_MODULE_NAME';
    public const CRITERION_MODULE_VERSION = 'CRITERION.PAYOLUTION_MODULE_VERSION';
    public const CRITERION_MODULE_NAME_VALUE = 'Payolution';
    public const CRITERION_MODULE_VERSION_VALUE = '2.0';

    public const CRITERION_SHIPPING_STREET = 'CRITERION.PAYOLUTION_SHIPPING_STREET';
    public const CRITERION_SHIPPING_ZIP = 'CRITERION.PAYOLUTION_SHIPPING_ZIP';
    public const CRITERION_SHIPPING_CITY = 'CRITERION.PAYOLUTION_SHIPPING_CITY';
    public const CRITERION_SHIPPING_STATE = 'CRITERION.PAYOLUTION_SHIPPING_STATE';
    public const CRITERION_SHIPPING_COUNTRY = 'CRITERION.PAYOLUTION_SHIPPING_COUNTRY';
    public const CRITERION_SHIPPING_GIVEN = 'CRITERION.PAYOLUTION_SHIPPING_GIVEN';
    public const CRITERION_SHIPPING_FAMILY = 'CRITERION.PAYOLUTION_SHIPPING_FAMILY';
    public const CRITERION_SHIPPING_COMPANY = 'CRITERION.PAYOLUTION_SHIPPING_COMPANY';
    public const CRITERION_SHIPPING_ADDITIONAL = 'CRITERION.PAYOLUTION_SHIPPING_ADDITIONAL';
    public const CRITERION_SHIPPING_TYPE = 'CRITERION.PAYOLUTION_SHIPPING_TYPE';
    public const CRITERION_SHIPPING_TYPE_BRANCH_PICKUP = 'CRITERION.BRANCH_PICKUP';
    public const CRITERION_SHIPPING_TYPE_POST_OFFICE_PICKUP = 'CRITERION.POST_OFFICE_PICKUP';
    public const CRITERION_SHIPPING_TYPE_PACK_STATION = 'CRITERION.PACK_STATION';

    public const CRITERION_TRANSPORTATION_COMPANY = 'CRITERION.PAYOLUTION_TRANSPORTATION_COMPANY';
    public const CRITERION_TRANSPORTATION_TRACKING = 'CRITERION.PAYOLUTION_TRANSPORTATION_TRACKING';
    public const CRITERION_TRANSPORTATION_RETURN_TRACKING = 'CRITERION.PAYOLUTION_TRANSPORTATION_RETURN_TRACKING';

    public const CRITERION_ITEM_DESCR_XX = 'CRITERION.PAYOLUTION_DESCR_XX';
    public const CRITERION_ITEM_PRICE_XX = 'CRITERION.PAYOLUTION_PRICE_XX';
    public const CRITERION_ITEM_TAX_XX = 'CRITERION.PAYOLUTION_TAX_XX';
    public const CRITERION_ITEM_CATEGORY_XX = 'CRITERION.PAYOLUTION_CATEGORY_XX';

    public const CRITERION_TAX_AMOUNT = 'CRITERION.PAYOLUTION_TAX_AMOUNT';

    public const CRITERION_PRE_CHECK = 'CRITERION.PAYOLUTION_PRE_CHECK';
    public const CRITERION_PRE_CHECK_ID = 'CRITERION.PAYOLUTION_PRE_CHECK_ID';

    public const CRITERION_TRX_TYPE = 'CRITERION.PAYOLUTION_TRX_TYPE';

    public const CRITERION_COMPANY_NAME = 'CRITERION.PAYOLUTION_COMPANY_NAME';
    public const CRITERION_COMPANY_UID = 'CRITERION.PAYOLUTION_COMPANY_UID';
    public const CRITERION_COMPANY_TRADEREGISTRY_NUMBER = 'CRITERION.PAYOLUTION_COMPANY_TRADEREGISTRY_NUMBER';

    public const CRITERION_CUSTOMER_LANGUAGE = 'CRITERION.PAYOLUTION_CUSTOMER_LANGUAGE';
    public const CRITERION_CUSTOMER_NUMBER = 'CRITERION.PAYOLUTION_CUSTOMER_NUMBER';
    public const CRITERION_CUSTOMER_GROUP = 'CRITERION.PAYOLUTION_CUSTOMER_GROUP';
    public const CRITERION_CUSTOMER_CONFIRMED_ORDERS = 'CRITERION.PAYOLUTION_CUSTOMER_CONFIRMED_ORDERS';
    public const CRITERION_CUSTOMER_CONFIRMED_AMOUNT = 'CRITERION.PAYOLUTION_CUSTOMER_CONFIRMED_AMOUNT';
    public const CRITERION_CUSTOMER_INTERNAL_SCORE = 'CRITERION.PAYOLUTION_CUSTOMER_INTERNAL_SCORE';

    public const CRITERION_WEBSHOP_URL = 'CRITERION.PAYOLUTION_WEBSHOP_URL';

    public const CRITERION_CALCULATION_ID = 'CRITERION.PAYOLUTION_CALCULATION_ID';
    public const CRITERION_INSTALLMENT_AMOUNT = 'CRITERION.PAYOLUTION_INSTALLMENT_AMOUNT';
    public const CRITERION_DURATION = 'CRITERION.PAYOLUTION_DURATION';
    public const CRITERION_ACCOUNT_HOLDER = 'CRITERION.PAYOLUTION_ACCOUNT_HOLDER';
    public const CRITERION_ACCOUNT_COUNTRY = 'CRITERION.PAYOLUTION_ACCOUNT_COUNTRY';
    public const CRITERION_ACCOUNT_BIC = 'CRITERION.PAYOLUTION_ACCOUNT_BIC';
    public const CRITERION_ACCOUNT_IBAN = 'CRITERION.PAYOLUTION_ACCOUNT_IBAN';

    public const CHECKOUT_ERROR_CODE_PAYMENT_FAILED = 'payment failed';
}
