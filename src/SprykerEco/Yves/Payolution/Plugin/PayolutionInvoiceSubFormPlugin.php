<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Payolution\Plugin;

use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface;

/**
 * @method \SprykerEco\Yves\Payolution\PayolutionFactory getFactory()
 */
class PayolutionInvoiceSubFormPlugin extends AbstractPlugin implements SubFormPluginInterface
{
    /**
     * @return \SprykerEco\Yves\Payolution\Form\InvoiceSubForm
     */
    public function createSubForm()
    {
        return $this->getFactory()->createInvoiceForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createSubFormDataProvider()
    {
        return $this->getFactory()->createInvoiceFormDataProvider();
    }
}
