<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Form\Extension;

use CleverAge\SyliusColissimoPlugin\Model\ShippingMethodInterface;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodChoiceType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ShippingMethodChoiceTypeExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $defaultAttr = [
            'class' => 'input-shipping-method',
        ];

        $resolver->setDefault('choice_attr', function (ShippingMethodInterface $choiceValue) use ($defaultAttr): array {
            if (!$choiceValue->isColissimoPickup()) {
                return $defaultAttr;
            }

            return [
                'data-colissimo-pickup' => true,
            ] + $defaultAttr;
        });
    }

    public static function getExtendedTypes(): iterable
    {
        return [ShippingMethodChoiceType::class];
    }
}
