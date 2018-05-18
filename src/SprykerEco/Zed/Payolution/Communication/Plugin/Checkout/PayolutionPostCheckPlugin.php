<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog;
use Spryker\Zed\Kernel\Communication\AbstractPlugin as BaseAbstractPlugin;
use Spryker\Zed\Payment\Dependency\Plugin\Checkout\CheckoutPostCheckPluginInterface;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainerInterface getQueryContainer()
 */
class PayolutionPostCheckPlugin extends BaseAbstractPlugin implements CheckoutPostCheckPluginInterface
{
    const ERROR_CODE_PAYMENT_FAILED = 'payment failed';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function execute(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $transactionStatusLogEntity = $this->getTransactionStatusLog($checkoutResponseTransfer);

        if (!$this->isPreAuthorizationApproved($transactionStatusLogEntity)) {
            $checkoutErrorTransfer = new CheckoutErrorTransfer();
            $checkoutErrorTransfer
                ->setErrorCode(self::ERROR_CODE_PAYMENT_FAILED)
                ->setMessage($transactionStatusLogEntity->getProcessingReason());

            $checkoutResponseTransfer->addError($checkoutErrorTransfer);
            $checkoutResponseTransfer->setIsSuccess(false);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog
     */
    protected function getTransactionStatusLog(CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $transactionStatusLogQuery = $this->getQueryContainer()->queryTransactionStatusLogBySalesOrderId($checkoutResponseTransfer->getSaveOrder()->getIdSalesOrder());
        $transactionStatusLogEntity = $transactionStatusLogQuery->findOne();
        if ($transactionStatusLogEntity === null) {
            throw new NotFoundHttpException('TransactionStatusLog entity could not be found');
        }

        return $transactionStatusLogEntity;
    }

    /**
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $transactionStatusLogEntity
     *
     * @return bool
     */
    protected function isPreAuthorizationApproved(SpyPaymentPayolutionTransactionStatusLog $transactionStatusLogEntity)
    {
        $successStatusCode = ApiConfig::PAYMENT_CODE_PRE_AUTHORIZATION . '.' . ApiConfig::STATUS_REASON_CODE_SUCCESS;

        return ($transactionStatusLogEntity && $transactionStatusLogEntity->getProcessingCode() === $successStatusCode);
    }
}
