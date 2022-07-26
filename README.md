# CleverAge/SyliusColissimoPlugin

[![Latest Version][ico-version]](https://packagist.org/packages/cleverage/sylius-colissimo-plugin) 
[![Software License][ico-license]](LICENSE)

## Introduction

This sylius plugin allows you to manage parcel shipments with colissimo.
You can define delivery methods such as `colissimo pickup points` or `colissimo home delivery`. 

For pickup point deliveries, an interactive map with the list of pickup points is generated according to the delivery address entered the tunnel by the user.

## Usage

TODO add screenshots

## Installation

### Step 1: Install and enable plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this plugin:

```bash
$ composer require cleverage/sylius-colissimo-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

Add bundle to your `config/bundles.php`:

```php
<?php
# config/bundles.php

return [
    // ...
    CleverAge\SyliusColissimoPlugin\CleverAgeSyliusColissimoPlugin::class => ['all' => true],
    // ...
];
```

### Step 2: Import routing and configs

#### Import routing

````yaml
# config/routes/clerverage_sylius_colissimo.yaml
clever_age_sylius_colissimo_shop:
  resource: "@CleverAgeSyliusColissimoPlugin/Resources/config/shop_routing.yml"

clever_age_sylius_colissimo_admin:
  resource: "@CleverAgeSyliusColissimoPlugin/Resources/config/admin_routing.yml"
  prefix: /admin
````

#### Import application config

````yaml
# config/packages/_sylius.yaml
imports:
  - { resource: "@CleverAgeSyliusColissimoPlugin/Resources/config/config.yaml" }
````

### Step 3: Update templates

#### Admin section

Add the following to the admin template `SyliusAdminBundle/ShippingMethod/_form.html.twig`

```twig
<h4 class="ui dividing header">{{ 'clever_age.admin.ui.shipping_method.title'|trans }}</h4>
{{ form_row(form.colissimoPickup) }}
{{ form_row(form.colissimoHomeDelivery) }}
```

See an example [here](tests/Application/templates/bundles/SyliusAdminBundle/ShippingMethod/_form.html.twig).

Next add the following to the admin template `SyliusAdminBundle/Order/Show/_shipment.html.twig`
after shipment header:

```twig
{% include "@CleverAgeSyliusColissimoPlugin/Label/Shipment/pickupPoint.html.twig" %}
```

See an example [here](tests/Application/templates/bundles/SyliusAdminBundle/Order/Show/_shipment.html.twig).

#### Shop section

Add the following to the shop template `SyliusShopBundle/Checkout/SelectShipping/_choice.html.twig`

```twig
// ...
{% if not method.isColissimoPickup %}
    {% include '@CleverAgeSyliusColissimoPlugin/Shipment/selectedPickupPoint.html.twig' %}
{% endif %}
// ...
{% if method.isColissimoPickup %}
    {% include '@CleverAgeSyliusColissimoPlugin/Shipment/map.html.twig' with {
        'pickupPoints': [myPickupPoints]
    } %}
{% endif %}
```

See an example [here](tests/Application/templates/bundles/SyliusShopBundle/Checkout/SelectShipping/_choice.html.twig).

Next add the following to the shop template `SyliusShopBundle/Common/Order/_shipments.html.twig`
after shipment method header:

```twig
{% include "@CleverAgeSyliusColissimoPlugin/Label/Shipment/pickupPoint.html.twig" %}
```

See an example [here](tests/Application/templates/bundles/SyliusShopBundle/Common/Order/_shipments.html.twig).

## Step 4 : Update styles, scripts and install assets

Add the following to the shop template `SyliusShopBundle/_styles.html.twig`

```twig
{% include '@SyliusUi/_stylesheets.html.twig' with { 'path': 'bundles/cleveragesyliuscolissimoplugin/css/map.css' } %}
{% include '@SyliusUi/_stylesheets.html.twig' with { 'path': 'bundles/cleveragesyliuscolissimoplugin/css/popup.css' } %}

{# Important for the map ! #}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
      integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
      crossorigin=""
/>
```

See an example [here](tests/Application/templates/bundles/SyliusShopBundle/_styles.html.twig).

Next the following to the shop template `SyliusShopBundle/_scripts.html.twig`

```twig
<script src="{{ asset('bundles/cleveragesyliuscolissimoplugin/js/map.js') }}" type="module"></script>
{% include '@SyliusUi/_javascripts.html.twig' with { 'path': 'bundles/cleveragesyliuscolissimoplugin/js/select-pickup-point.js' } %}
{% include '@SyliusUi/_javascripts.html.twig' with { 'path': 'bundles/cleveragesyliuscolissimoplugin/js/change-pickup-point.js' } %}
{% include '@SyliusUi/_javascripts.html.twig' with { 'path': 'bundles/cleveragesyliuscolissimoplugin/js/select-shipping.js' } %}
```

See an example [here](tests/Application/templates/bundles/SyliusShopBundle/_scripts.html.twig).

### Install assets

```bash
bin/console assets:install --symlink
```

# Step 5 : Customize resources

**Shipping method resource**

If you haven't extended the shipping method resource yet, here is what it should look like :

```php
<?php
// src/Entity/ShippingMethod.php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use CleverAge\SyliusColissimoPlugin\Model\ShippingMethodInterface;
use CleverAge\SyliusColissimoPlugin\Model\ShippingMethodTrait;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;

/**
 * @ORM\Entity()
 * @ORM\Table(name="sylius_shipping_method")
 */
class ShippingMethod extends BaseShippingMethod implements ShippingMethodInterface
{
    use ShippingMethodTrait;
}

```

**Order resource**

If you haven't extended the order resource yet, here is what it should look like :

```php
<?php
// src/Entity/Order.php

declare(strict_types=1);

namespace App\Entity;

use CleverAge\SyliusColissimoPlugin\Model\OrderInterface;
use CleverAge\SyliusColissimoPlugin\Model\OrderTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Order as BaseOrder;

/**
 * @ORM\Entity()
 * @ORM\Table(name="sylius_order")
 */
class Order extends BaseOrder implements OrderInterface
{
    use OrderTrait;
}
```

You can read about extending resources [here](https://docs.sylius.com/en/latest/customization/model.html).

**Update shipping and order resources config**

Next you need to tell Sylius that you will use your own extended resources :

```yaml
# config/packages/_sylius.yaml

sylius_shipping:
  resources:
    shipping_method:
      classes:
        model: App\Entity\ShippingMethod

sylius_order:
  resources:
    order:
      classes:
        model: App\Entity\Order
```

# Step 6 : Update database schema 

```bash
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate 
```

# Step 7 : Configure plugin

```yaml
// config/packages/cleverage_sylius_colissimo.yaml

clever_age_sylius_colissimo:
  encryptionKey: 'your encryption key'
```

Enjoy now ! 

[ico-version]: https://poser.pugx.org/cleverage/sylius-colissimo-plugin/v/stable
[ico-license]: https://poser.pugx.org/cleverage/sylius-colissimo-plugin/license
