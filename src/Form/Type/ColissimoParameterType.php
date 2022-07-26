<?php

namespace CleverAge\SyliusColissimoPlugin\Form\Type;

use CleverAge\SyliusColissimoPlugin\Entity\ColissimoParameterInterface;
use CleverAge\SyliusColissimoPlugin\Hasher\HasherInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ColissimoParameterType extends AbstractType
{
    private string $encryptionKey;
    private HasherInterface $hasher;

    public function __construct(string $encryptionKey, HasherInterface $hasher)
    {
        $this->encryptionKey = $encryptionKey;
        $this->hasher = $hasher;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('testModeEnabled', CheckboxType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.test_mode_enabled',
                'required' => false,
            ])
            ->add('contractNumber', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.contract_number',
            ])
            ->add('password', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.password',
            ])
            ->add('commercialName', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.commercial_name',
            ])
            ->add('companyName', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.company_name',
            ])
            ->add('line0', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.line0',
                'required' => false,
            ])
            ->add('line1', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.line1',
                'required' => false,
            ])
            ->add('line2', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.line2',
            ])
            ->add('line3', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.line3',
                'required' => false,
            ])
            ->add('countryCode', CountryType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.country_code',
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.zip_code',
            ])
            ->add('city', TextType::class, [
                'label' => 'clever_age.ui.colissimo_parameter.city',
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'decryptCredentials']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ColissimoParameterInterface::class,
        ]);
    }

    public function decryptCredentials(FormEvent $event): void
    {
        /** @var ColissimoParameterInterface $data */
        $data = $event->getData();

        if ($contractNumber = $data->getContractNumber()) {
            $data->setContractNumber(
                $this->hasher->decrypt($contractNumber, $this->encryptionKey),
            );
        }

        if ($password = $data->getPassword()) {
            $data->setPassword(
                $this->hasher->decrypt($password, $this->encryptionKey),
            );
        }
    }
}
