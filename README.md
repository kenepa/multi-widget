# Multi Widget

<a href="https://github.com/kenepa/resource-lock" class="filament-hidden">
<img style="width: 100%; max-width: 100%;" alt="filament-multi-widget-art" src="https://raw.githubusercontent.com/kenepa/Kenepa/main/art/MultiWidget/filament-multi-widget-banner.png" >
</a>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kenepa/multi-widget.svg?style=flat-square)](https://packagist.org/packages/kenepa/multi-widget)
[![Total Downloads](https://img.shields.io/packagist/dt/kenepa/multi-widget.svg?style=flat-square)](https://packagist.org/packages/kenepa/multi-widget)

Filament Multi Widget adds a new type of widget to your Filament application. The Multi Widget allows you to combine multiple widgets into a single widget, that can be switched using tabs. This plugin helps clean up your Filament dashboard.

<img style="width: 100%; max-width: 100%;" alt="filament-multi-widget-art" src="https://raw.githubusercontent.com/kenepa/Kenepa/main/art/MultiWidget/filamet-multi-widget-demo.gif" >

## Installation

You can install the package via composer:

| Plugin Version | Filament Version | PHP Version |
|----------------|-----------------|-------------|
| 1.x            | 2.x   | \> 8.0      |
| 2.x            | 3.x             | \> 8.1      |

```bash
composer require kenepa/multi-widget
```

## Usage

Create a new Multi Widget by extending the `Kenepa\MultiWidget\MultiWidget` class.

```php
// app/Filament/Widgets/UserMultiWidget.php

class UserMultiWidget extends MultiWidget
{
    public array $widgets = [
        MySubmittedComments::class,
        MySubmittedFeedback::class,
        MySubscriptions::class,
    ];
}
```

The `$widgets` property contains the classes of all the widgets that should be added to your Multi Widget. These are normal [Filament widgets](https://filamentphp.com/docs/2.x/admin/resources/widgets) that you created.  
The Multi Widget above will now render as follows:  

<img src="https://raw.githubusercontent.com/kenepa/multi-widget/2.x/.github/usermultiwidget-example.png">

It is advised to make the `canView` method return false on the widgets, so that they are not rendered twice.

## Persist tabs in session
To persist the tabs in the user's session, use the shouldPersistMultiWidgetTabsInSession() method:

```php
// app/Filament/Widgets/UserMultiWidget.php

class UserMultiWidget extends MultiWidget
{
    public array $widgets = [
        MySubmittedComments::class,
        MySubmittedFeedback::class,
        MySubscriptions::class,
    ];
    
    public function shouldPersistMultiWidgetTabsInSession(): bool
    {
        return true;
    }
}
```



## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.