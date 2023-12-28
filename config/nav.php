<?php


return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard.dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard.dashboard'
    ], [
        'icon' => 'right fas fa-angle-left',
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'dashboard.categories.*',
        'ability' => 'categories.view',
    ], [
        'icon' => 'right fas fa-angle-left',
        'route' => 'dashboard.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*',
        'ability' => 'products.view',
    ], [
        'icon' => 'right fas fa-angle-left',
        'route' => 'dashboard.categories.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*',
        'ability' => 'orders.view',
    ], [
        'icon' => 'fas fa-shield nav-icon',
        'route' => 'dashboard.roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        //'ability' => 'roles.view',
    ],
];
