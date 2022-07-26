<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Form\Extension;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ShippingMethodTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('colissimoPickup', CheckboxType::class, [
                'label' => 'clever_age.admin.ui.shipping_method.colissimo_pickup',
            ])
            ->add('colissimoHomeDelivery', CheckboxType::class, [
                'label' => 'clever_age.admin.ui.shipping_method.colissimo_home_delivery',
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [ShippingMethodType::class];
    }
}
