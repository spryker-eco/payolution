<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Payolution\Form;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayolutionPaymentTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceSubForm extends AbstractPayolutionSubForm
{
    protected const PAYMENT_METHOD = 'invoice';

    /**
     * @return string
     */
    public function getName()
    {
        return PaymentTransfer::PAYOLUTION_INVOICE;
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return PaymentTransfer::PAYOLUTION_INVOICE;
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return PayolutionConfig::PROVIDER_NAME . '/' . static::PAYMENT_METHOD;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PayolutionPaymentTransfer::class,
            SubFormInterface::OPTIONS_FIELD_NAME => [],
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addDateOfBirth($builder);
    }
}
