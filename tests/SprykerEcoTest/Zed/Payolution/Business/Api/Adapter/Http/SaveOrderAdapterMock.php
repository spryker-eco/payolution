<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http;

class SaveOrderAdapterMock extends AbstractAdapterMock
{
    /**
     * @return string
     */
    public function getSuccessResponse()
    {
        return 'not used — success';
    }

    /**
     * @return string
     */
    public function getFailureResponse()
    {
        return 'not used — failure';
    }
}
