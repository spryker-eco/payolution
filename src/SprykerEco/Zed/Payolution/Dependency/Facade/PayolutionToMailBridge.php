<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Dependency\Facade;

use Generated\Shared\Transfer\MailTransfer;

class PayolutionToMailBridge implements PayolutionToMailInterface
{

    /**
     * @var \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    protected $mailFacade;

    /**
     * @param \Spryker\Zed\Mail\Business\MailFacadeInterface $mailFacade
     */
    public function __construct($mailFacade)
    {
        $this->mailFacade = $mailFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return \Generated\Shared\Transfer\SendMailResponsesTransfer
     */
    public function sendMail(MailTransfer $mailTransfer)
    {
        return $this->mailFacade->sendMail($mailTransfer);
    }

}
