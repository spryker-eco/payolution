<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Payolution;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\Money\Plugin\MoneyPlugin;
use SprykerEco\Yves\Payolution\Form\DataProvider\InstallmentFormDataProvider;
use SprykerEco\Yves\Payolution\Form\DataProvider\InvoiceFormDataProvider;
use SprykerEco\Yves\Payolution\Form\InstallmentSubForm;
use SprykerEco\Yves\Payolution\Form\InvoiceSubForm;
use SprykerEco\Yves\Payolution\Handler\PayolutionHandler;

class PayolutionFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createInvoiceForm()
    {
        return new InvoiceSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createInstallmentForm()
    {
        return new InstallmentSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createInstallmentFormDataProvider()
    {
        return new InstallmentFormDataProvider($this->getPayolutionClient(), $this->createMoneyPlugin());
    }

    /**
     * @return \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    public function createMoneyPlugin()
    {
        return new MoneyPlugin();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createInvoiceFormDataProvider()
    {
        return new InvoiceFormDataProvider();
    }

    /**
     * @return \SprykerEco\Yves\Payolution\Handler\PayolutionHandlerInterface
     */
    public function createPayolutionHandler()
    {
        return new PayolutionHandler($this->getPayolutionClient());
    }

    /**
     * @return \SprykerEco\Client\Payolution\PayolutionClientInterface
     */
    public function getPayolutionClient()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::CLIENT_PAYOLUTION);
    }
}
