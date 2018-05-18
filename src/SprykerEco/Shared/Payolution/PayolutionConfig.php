<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Payolution;

interface PayolutionConfig
{
    const PROVIDER_NAME = 'Payolution';

    const PAYMENT_METHOD_INVOICE = 'payolutionInvoice';
    const PAYMENT_METHOD_INSTALLMENT = 'payolutionInstallment';

    const BRAND_INVOICE = 'PAYOLUTION_INVOICE';
    const BRAND_INSTALLMENT = 'PAYOLUTION_INS';

    const PAYMENT_CODE_PRE_CHECK = 'VA.PA';
    const PAYMENT_CODE_REFUND = 'VA.RF';

    const STATUS_CODE_SUCCESS = '90';
    const REASON_CODE_SUCCESS = '00';
    const STATUS_REASON_CODE_SUCCESS = self::STATUS_CODE_SUCCESS . '.' . self::REASON_CODE_SUCCESS;
    const SUCCESSFUL_PRE_AUTHORIZATION_PROCESSING_CODE = 'VA.PA.90.00';
}
