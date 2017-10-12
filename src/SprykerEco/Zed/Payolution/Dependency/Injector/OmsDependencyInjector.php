<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Dependency\Injector;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Dependency\Injector\AbstractDependencyInjector;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\CommandCollectionInterface;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Condition\ConditionCollectionInterface;
use Spryker\Zed\Oms\OmsDependencyProvider;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Command\CapturePlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Command\PreAuthorizePlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Command\ReAuthorizePlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Command\RefundPlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Command\RevertPlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Condition\IsCaptureApprovedPlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Condition\IsPreAuthorizationApprovedPlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Condition\IsReAuthorizationApprovedPlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Condition\IsRefundApprovedPlugin;
use SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Condition\IsReversalApprovedPlugin;

class OmsDependencyInjector extends AbstractDependencyInjector
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function injectBusinessLayerDependencies(Container $container)
    {
        $container = $this->injectCommands($container);
        $container = $this->injectConditions($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function injectCommands(Container $container)
    {
        $container->extend(OmsDependencyProvider::COMMAND_PLUGINS, function (CommandCollectionInterface $commandCollection) {
            $commandCollection
                ->add(new PreAuthorizePlugin(), 'Payolution/PreAuthorize')
                ->add(new ReAuthorizePlugin(), 'Payolution/ReAuthorize')
                ->add(new RevertPlugin(), 'Payolution/Revert')
                ->add(new CapturePlugin(), 'Payolution/Capture')
                ->add(new RefundPlugin(), 'Payolution/Refund');

            return $commandCollection;
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function injectConditions(Container $container)
    {
        $container->extend(OmsDependencyProvider::CONDITION_PLUGINS, function (ConditionCollectionInterface $conditionCollection) {
            $conditionCollection
                ->add(new IsPreAuthorizationApprovedPlugin(), 'Payolution/IsPreAuthorizationApproved')
                ->add(new IsReAuthorizationApprovedPlugin(), 'Payolution/IsReAuthorizationApproved')
                ->add(new IsReversalApprovedPlugin(), 'Payolution/IsReversalApproved')
                ->add(new IsCaptureApprovedPlugin(), 'Payolution/IsCaptureApproved')
                ->add(new IsRefundApprovedPlugin(), 'Payolution/IsRefundApproved');

            return $conditionCollection;
        });

        return $container;
    }
}
