<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Payolution;

interface PayolutionConstants
{

    const PAYOLUTION = 'payolution';
    const TRANSACTION_GATEWAY_URL = 'PAYOLUTION_TRANSACTION_GATEWAY_URL';
    const CALCULATION_GATEWAY_URL = 'PAYOLUTION_CALCULATION_GATEWAY_URL';

    const TRANSACTION_SECURITY_SENDER = 'PAYOLUTION_SECURITY_SENDER';
    const TRANSACTION_USER_LOGIN = 'PAYOLUTION_USER_LOGIN';
    const TRANSACTION_USER_PASSWORD = 'PAYOLUTION_USER_PASSWORD';
    const CALCULATION_SENDER = 'PAYOLUTION_CALCULATION_SENDER';
    const CALCULATION_USER_LOGIN = 'PAYOLUTION_CALCULATION_USER_LOGIN';
    const CALCULATION_USER_PASSWORD = 'PAYOLUTION_CALCULATION_USER_PASSWORD';

    const TRANSACTION_MODE = 'PAYOLUTION_TRANSACTION_MODE';
    const CALCULATION_MODE = 'PAYOLUTION_CALCULATION_MODE';

    const TRANSACTION_CHANNEL_INVOICE = 'PAYOLUTION_CHANNEL_INVOICE';
    const TRANSACTION_CHANNEL_INSTALLMENT = 'PAYOLUTION_CHANNEL_INSTALLMENT';
    const TRANSACTION_CHANNEL_PRE_CHECK = 'PAYOLUTION_CHANNEL_PRE_CHECK_ID';
    const CALCULATION_CHANNEL = 'PAYOLUTION_CALCULATION_CHANNEL';

    const MIN_ORDER_GRAND_TOTAL_INVOICE = 'PAYOLUTION_MIN_ORDER_GRAND_TOTAL_INVOICE';
    const MAX_ORDER_GRAND_TOTAL_INVOICE = 'PAYOLUTION_MAX_ORDER_GRAND_TOTAL_INVOICE';
    const MIN_ORDER_GRAND_TOTAL_INSTALLMENT = 'PAYOLUTION_MIN_ORDER_GRAND_TOTAL_INSTALLMENT';
    const MAX_ORDER_GRAND_TOTAL_INSTALLMENT = 'PAYOLUTION_MAX_ORDER_GRAND_TOTAL_INSTALLMENT';

    const PAYOLUTION_BCC_EMAIL = 'PAYOLUTION_BCC_EMAIL';
    const EMAIL_TEMPLATE_NAME = 'PAYOLUTION_EMAIL_TEMPLATE_NAME';
    const EMAIL_FROM_NAME = 'PAYOLUTION_EMAIL_FROM_NAME';
    const EMAIL_FROM_ADDRESS = 'PAYOLUTION_EMAIL_FROM_ADDRESS';
    const EMAIL_SUBJECT = 'EMAIL_SUBJECT';

    const BRAND_INVOICE = 'PAYOLUTION_INVOICE';
    const BRAND_INSTALLMENT = 'PAYOLUTION_INS';

    const PAYMENT_CODE_PRE_CHECK = 'VA.PA';

    const STATUS_CODE_SUCCESS = '90';
    const REASON_CODE_SUCCESS = '00';
    const STATUS_REASON_CODE_SUCCESS = self::STATUS_CODE_SUCCESS . '.' . self::REASON_CODE_SUCCESS;
    const SUCCESSFUL_PRE_AUTHORIZATION_PROCESSING_CODE = 'VA.PA.90.00';

    /** @deprecated Please use PayolutionConstants::BASE_URL_YVES instead */
    const HOST_YVES = 'HOST_YVES';

    /**
     * Base URL for Yves including scheme and port (e.g. http://www.de.demoshop.local:8080)
     *
     * @api
     */
    const BASE_URL_YVES = 'PAYOLUTION:BASE_URL_YVES';

}
