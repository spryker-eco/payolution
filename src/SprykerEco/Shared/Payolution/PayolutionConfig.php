<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Payolution;

interface PayolutionConfig
{
    public const PROVIDER_NAME = 'Payolution';

    public const PAYMENT_METHOD_INVOICE = 'payolutionInvoice';
    public const PAYMENT_METHOD_INSTALLMENT = 'payolutionInstallment';

    public const BRAND_INVOICE = 'PAYOLUTION_INVOICE';
    public const BRAND_INSTALLMENT = 'PAYOLUTION_INS';

    public const PAYMENT_CODE_PRE_CHECK = 'VA.PA';
    public const PAYMENT_CODE_REFUND = 'VA.RF';

    public const STATUS_CODE_SUCCESS = '90';
    public const REASON_CODE_SUCCESS = '00';
    public const STATUS_REASON_CODE_SUCCESS = self::STATUS_CODE_SUCCESS . '.' . self::REASON_CODE_SUCCESS;
    public const SUCCESSFUL_PRE_AUTHORIZATION_PROCESSING_CODE = 'VA.PA.90.00';
}
