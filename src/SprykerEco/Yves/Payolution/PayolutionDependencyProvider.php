<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Payolution;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class PayolutionDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_PAYOLUTION = 'payolution client';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container[self::CLIENT_PAYOLUTION] = function (Container $container) {
            return $container->getLocator()->payolution()->client();
        };

        return $container;
    }
}
