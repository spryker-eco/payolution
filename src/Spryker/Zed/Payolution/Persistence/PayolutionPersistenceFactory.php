<?php

/**
 * This file is part of the Spryker Platform.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\Payolution\Persistence;

use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionQuery;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLogQuery;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLogQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Spryker\Zed\Payolution\PayolutionConfig getConfig()
 * @method \Spryker\Zed\Payolution\Persistence\PayolutionQueryContainer getQueryContainer()
 */
class PayolutionPersistenceFactory extends AbstractPersistenceFactory
{

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionQuery
     */
    public function createPaymentPayolutionQuery()
    {
        return SpyPaymentPayolutionQuery::create();
    }

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLogQuery
     */
    public function createPaymentPayolutionTransactionStatusLogQuery()
    {
        return SpyPaymentPayolutionTransactionStatusLogQuery::create();
    }

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLogQuery
     */
    public function createPaymentPayolutionTransactionRequestLogQuery()
    {
        return SpyPaymentPayolutionTransactionRequestLogQuery::create();
    }

}
