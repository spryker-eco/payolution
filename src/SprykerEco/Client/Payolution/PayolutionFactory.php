<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Payolution;

use Spryker\Client\Kernel\AbstractFactory;
use SprykerEco\Client\Payolution\Session\PayolutionSession;
use SprykerEco\Client\Payolution\Zed\PayolutionStub;

class PayolutionFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Client\Payolution\Session\PayolutionSessionInterface
     */
    public function createPayolutionSession()
    {
        return new PayolutionSession($this->getSessionClient());
    }

    /**
     * @return \Spryker\Client\Session\SessionClientInterface
     */
    protected function getSessionClient()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::CLIENT_SESSION);
    }

    /**
     * @return \SprykerEco\Client\Payolution\Zed\PayolutionStubInterface
     */
    public function createPayolutionStub()
    {
        return new PayolutionStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
