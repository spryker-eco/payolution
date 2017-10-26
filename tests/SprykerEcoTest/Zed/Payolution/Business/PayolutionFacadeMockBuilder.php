<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

use Codeception\Test\Unit;
use Spryker\Zed\Money\Business\MoneyFacade;
use SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Payolution\Business\PayolutionBusinessFactory;
use SprykerEco\Zed\Payolution\Business\PayolutionFacade;
use SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyBridge;
use SprykerEco\Zed\Payolution\PayolutionConfig;
use SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainer;

class PayolutionFacadeMockBuilder
{
    /**
     * @param \SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface $adapter
     * @param \Codeception\Test\Unit $testCase
     *
     * @return \SprykerEco\Zed\Payolution\Business\PayolutionFacade|\PHPUnit_Framework_MockObject_MockObject
     */
    public static function build(AdapterInterface $adapter, Unit $testCase)
    {
        // Mock business factory to override return value of createExecutionAdapter to
        // place a mocked adapter that doesn't establish an actual connection.
        $businessFactoryMock = self::getBusinessFactoryMock($testCase);
        $businessFactoryMock->setConfig(self::getConfigMock($testCase));
        $businessFactoryMock
            ->expects($testCase->any())
            ->method('createAdapter')
            ->will($testCase->returnValue($adapter));

        // Business factory always requires a valid query container. Since we're creating
        // functional/integration tests there's no need to mock the database layer.
        $queryContainer = new PayolutionQueryContainer();
        $businessFactoryMock->setQueryContainer($queryContainer);

        // Mock the facade to override getFactory() and have it return out
        // previously created mock.
        $facade = $testCase->getMockBuilder(PayolutionFacade::class)
            ->setMethods(['getFactory'])->getMock();

        $facade->expects($testCase->any())
            ->method('getFactory')
            ->will($testCase->returnValue($businessFactoryMock));

        return $facade;
    }

    /**
     * @param \Codeception\Test\Unit $testCase
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Payolution\Business\PayolutionBusinessFactory
     */
    protected static function getBusinessFactoryMock(Unit $testCase)
    {
        $businessFactoryMock = $testCase->getMockBuilder(PayolutionBusinessFactory::class)
            ->setMethods(
                ['createAdapter', 'getMoneyFacade']
            )->getMock();

        $payolutionToMoneyBridge = new PayolutionToMoneyBridge(new MoneyFacade());
        $businessFactoryMock->method('getMoneyFacade')->willReturn($payolutionToMoneyBridge);

        return $businessFactoryMock;
    }

    /**
     * @param \Codeception\Test\Unit $testCase
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Payolution\PayolutionConfig
     */
    protected static function getConfigMock(Unit $testCase)
    {
        $configMock = $testCase->getMockBuilder(PayolutionConfig::class)->getMock();
        $configMock->expects($testCase->any())
            ->method('getMaxOrderGrandTotalInvoice')
            ->willReturn(999999);
        return $configMock;
    }
}
