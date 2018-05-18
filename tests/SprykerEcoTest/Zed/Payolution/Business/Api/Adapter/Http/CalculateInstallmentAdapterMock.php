<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http;

class CalculateInstallmentAdapterMock extends AbstractAdapterMock
{
    /**
     * @param array|string $data
     * @param string $user
     * @param string $password
     *
     * @return string
     */
    public function sendAuthorizedRequest($data, $user, $password)
    {
        return
            '<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<Response version="2.0">
    <TransactionType>B2C</TransactionType>
    <OperationType>CALCULATION</OperationType>
    <PaymentType>INSTALLMENT</PaymentType>
    <Identification>
        <TransactionID></TransactionID>
        <UniqueID>foobarbaz</UniqueID>
    </Identification>
    <Status>OK</Status>
    <StatusCode>0.0.0</StatusCode>
    <Description>Calculation performed successfully.</Description>
    <PaymentDetails>
        <Installment>
            <Amount>30.00</Amount>
            <Due>2017-11-20</Due>
        </Installment>
        <Installment>
            <Amount>30.00</Amount>
            <Due>2017-12-20</Due>
        </Installment>
        <Installment>
            <Amount>30.00</Amount>
            <Due>2018-01-20</Due>
        </Installment>
        <OriginalAmount>90.00</OriginalAmount>
        <TotalAmount>100.00</TotalAmount>
        <MinimumInstallmentFee>0</MinimumInstallmentFee>
        <Duration>3</Duration>
        <InterestRate>42.42</InterestRate>
        <EffectiveInterestRate>45.45</EffectiveInterestRate>
        <Usage>Calculated by calculation service</Usage>
        <Currency>EUR</Currency>
        <StandardCreditInformationUrl>https://test-payment.payolution.com/payolution-payment/rest/query/customerinfo/pdf?foobarbaz&amp;duration=3</StandardCreditInformationUrl>
    </PaymentDetails>
    <PaymentDetails>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2017-11-20</Due>
        </Installment>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2017-12-20</Due>
        </Installment>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2018-01-20</Due>
        </Installment>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2018-02-20</Due>
        </Installment>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2018-03-20</Due>
        </Installment>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2018-04-20</Due>
        </Installment>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2018-05-20</Due>
        </Installment>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2018-06-20</Due>
        </Installment>
        <Installment>
            <Amount>10.00</Amount>
            <Due>2018-07-20</Due>
        </Installment>
        <OriginalAmount>90.00</OriginalAmount>
        <TotalAmount>100.00</TotalAmount>
        <MinimumInstallmentFee>0</MinimumInstallmentFee>
        <Duration>9</Duration>
        <InterestRate>42.42</InterestRate>
        <EffectiveInterestRate>49.49</EffectiveInterestRate>
        <Usage>Calculated by calculation service</Usage>
        <Currency>EUR</Currency>
        <StandardCreditInformationUrl>https://test-payment.payolution.com/payolution-payment/rest/query/customerinfo/pdf?foobarbaz&amp;duration=9</StandardCreditInformationUrl>
    </PaymentDetails>
    <AdditionalInformation>
        <TacUrl>https://test-payment.payolution.com/payolution-payment/infoport/termsandconditions?channelId=spryker-installment</TacUrl>
        <DataPrivacyConsentUrl>https://test-payment.payolution.com/payolution-payment/infoport/dataprivacydeclaration?channelId=spryker-installment</DataPrivacyConsentUrl>
    </AdditionalInformation>
</Response>';
    }

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
