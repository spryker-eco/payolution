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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstallmentSubForm extends AbstractPayolutionSubForm
{
    protected const PAYMENT_PROVIDER = PayolutionConfig::PROVIDER_NAME;
    protected const PAYMENT_METHOD = 'installment';
    protected const FIELD_INSTALLMENT_PAYMENT_DETAIL_INDEX = 'installment_payment_detail_index';
    protected const FIELD_BANK_ACCOUNT_HOLDER = 'bank_account_holder';
    protected const FIELD_BANK_ACCOUNT_IBAN = 'bank_account_iban';
    protected const FIELD_BANK_ACCOUNT_BIC = 'bank_account_bic';

    public const OPTION_INSTALLMENT_PAYMENT_DETAIL = 'installment_payment_detail';

    /**
     * @return string
     */
    public function getName()
    {
        return PaymentTransfer::PAYOLUTION_INSTALLMENT;
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return PaymentTransfer::PAYOLUTION_INSTALLMENT;
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
        ])->setRequired(SubFormInterface::OPTIONS_FIELD_NAME);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addInstallmentPaymentDetails($builder, $options)
             ->addDateOfBirth($builder)
             ->addBankAccountHolder($builder)
             ->addBankAccountIban($builder)
             ->addBankAccountBic($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    public function addInstallmentPaymentDetails(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            static::FIELD_INSTALLMENT_PAYMENT_DETAIL_INDEX,
            ChoiceType::class,
            [
                'choices' => array_flip($options['select_options'][static::OPTION_INSTALLMENT_PAYMENT_DETAIL]),
                'label' => false,
                'required' => true,
                'expanded' => false,
                'multiple' => false,
                'placeholder' => false,
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBankAccountHolder(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_BANK_ACCOUNT_HOLDER,
            TextType::class,
            [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'payolution_installment.bank_account_holder',
                ],
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBankAccountIban(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_BANK_ACCOUNT_IBAN,
            TextType::class,
            [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'payolution_installment.bank_account_iban',
                ],
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBankAccountBic(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_BANK_ACCOUNT_BIC,
            TextType::class,
            [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'payolution_installment.bank_account_bic',
                ],
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }
}
