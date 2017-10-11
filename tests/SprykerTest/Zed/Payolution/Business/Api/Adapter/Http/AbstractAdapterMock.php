<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Payolution\Business\Api\Adapter\Http;

use SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface;

abstract class AbstractAdapterMock implements AdapterInterface
{

    /**
     * @var bool
     */
    private $expectSuccess = true;

    /**
     * @var array
     */
    protected $requestData = [];

    /**
     * @return $this
     */
    public function expectSuccess()
    {
        $this->expectSuccess = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function expectFailure()
    {
        $this->expectSuccess = false;

        return $this;
    }

    /**
     * @param array|string $data
     *
     * @return string
     */
    public function sendRequest($data)
    {
        $this->requestData = $data;

        if ($this->expectSuccess === true) {
            return $this->getSuccessResponse();
        }

        return $this->getFailureResponse();
    }

    /**
     * @param array|string $data
     * @param string $user
     * @param string $password
     *
     * @return string
     */
    public function sendAuthorizedRequest($data, $user, $password)
    {
    }

    /**
     * @return string
     */
    abstract public function getSuccessResponse();

    /**
     * @return string
     */
    abstract public function getFailureResponse();

}
