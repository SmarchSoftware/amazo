<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Master Layout
    |--------------------------------------------------------------------------
    |
    | Amazo comes with the form/pages needed to operate. It is assumed and
    | expected that you already have your own master layout to use. You
    | should specify the master layout to use here.
    |
    |
    */   
   'layout' => 'watchtower::layouts.master',

    /*
    |--------------------------------------------------------------------------
    | Content Section name
    |--------------------------------------------------------------------------
    |
    | In your master layout, this is the name of the section that your master
    | layout uses. Amazo will use this name for it's sectional content.
    |
    | i.e. if you use yield('content') in your master layout for the position
    | where you want Amazo to appear then the section is called "content".
    |
    */
   'section' => 'content',

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    |
    | Amazo comes pre-equipped with views that will work right out of the box.
    | However, you are free to define you own views to use here instead.
    |
    */   
   'views' => [
        'index'         => 'amazo::index',            
        'create'        => 'amazo::create',
        'show'          => 'amazo::edit',
        'edit'          => 'amazo::edit',
        'unauthorized'  => 'amazo::unauthorized'
    ],

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Title header of the index page and other views.
    |
    */   
   'title' => 'Damage Types',

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | How many currencies to load per page?
    |
    */   
   'pagination' => '15',

    /*
    |--------------------------------------------------------------------------
    | Authorization ?
    |--------------------------------------------------------------------------
    |
    | Out of the box, amazo can optionally use Laravel's built in authorization
    | methods. If you wish to make use of them, switch the enable param
    | to true and then use the permissions that your app requires.
    |
    | Note : amazo itself  does not provide authorization and when/if you
    | decide to enable the ACL options, the Auth::user() method "can"
    | must already have those permissions defined. Installing and 
    | enabling authorization is outside Amazo's scope.
    |
    | ACL overview :
    | 'enable' true/false
    | 'driver' [ "laravel" or "shinobi" or "sentinel" ]
    | 'index' is to view the index page.
    | 'create' is to create new currencies.
    | 'show' is to view individual currencies.
    | 'edit' is to change existing currencies.
    | 'destroy' is to delete existing currencies.
    |
    */  
   'acl' => [
        'enable'    => false,
        'driver'    => 'laravel',
        'index'     => 'amazo.index',            
        'create'    => 'amazo.create',
        'show'      => 'amazo.show',
        'edit'      => 'amazo.edit',
        'destroy'   => 'amazo.destroy'       
    ],

];