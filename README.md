

![](http://i.imgur.com/4QHCz3r.png)

This is probably only of use to me, but I have need of it in multiple apps so I packaged it up in case you want it too. :)

***

# Amazo
A game management package for damage types. Everything need to add / edit / manage damage types (and modifiers) for your game. _(standard, lethal, critical, brutal, fire, ice, electrical, etc...)_

## Overview
Out of the box, Amazo contains all the views necessary to enable "Game Damage Type" management. It also uses the config file for you to easily define the necessary permissions to secure your site so that only those allowed to perform the admin functions are permitted _(or you can disable ACL altogether)_. Since it is a config file, all views and permissions are configurable so you are free to provide your own views and change the permissions the way your app requires them.

Amazo will also let you set modifiers on the damage types you add. For example, you can have "Critical" always be worth double damage of "Standard".

Amazo's config file will allow you to specify the route information(prefix, group, etc...), views, permissions and more.

If you have a need for in-game damage type management this will be a package to help with that.

## Installation

This page is intended for installation, please check out the [wiki](https://github.com/SmarchSoftware/amazo/wiki) for more information about usage.

#### :black_square_button: Composer

    composer require "smarch/amazo"

#### :pencil: Service Provider

Amazo uses the [HTML Forms](https://laravelcollective.com/docs/5.1/html) package from the "Laravel Collective" for Html & Form rendering so composer will install that as well if you don't already have it installed _(you probably do...or should)_. Once composer has installed the necessary packages for Amazo to function you need to open your laravel config page for service providers and add Amazo _(and if necessary the Laravel Collective Html provider)_. To properly function you need to have both service providers referenced : [HTML Forms](https://laravelcollective.com/docs/5.1/html) and Amazo.

*config/app.php*
       
       /*
        * Third Party Service Providers
        */
        Collective\Html\HtmlServiceProvider::class, // For Amazo to function
        Smarch\Amazo\AmazoServiceProvider::class, // For Amazo

#### :pencil: Facades
Next you will need to add the Amazo and Forms Facades to your config app file.

*config/app.php*

        /*
        * Third Party Service Providers
        */
        'Form'  => Collective\Html\FormFacade::class,	// required for Amazo Forms
        'HTML'  => Collective\Html\HtmlFacade::class,	// required for Amazo Forms
        'Amazo'	=> Smarch\Amazo\Facades\AmazoFacade::class, // required for Amazo:: 

#### :card_index: Database Migrations

Next you need to add the migration to create the Amazo "damage types" table and the Amazo "damage modififers" table to hold your all your damage tyep information. From your command prompt (wherever you run your artisan commands) enter the following command <kbd>php artisan vendor:publish</kbd>. This will create the Amazo config file *(which allows you to define any views / permissions you wish to change from their defaults)*.

    php artisan vendor:publish

After you have adjusted the config file to your needs, then run the migration command <kbd>php artisan migrate</kbd>. This should properly create both necessary tables.

    php artisan migrate

#### :trident: Why "Amazo"?
I've been a DC geek for over 30 years now. Amazo in DC has the power of duplicating the powers _(damage types)_ of other metahumans so..."Amazo". :smile:
   
