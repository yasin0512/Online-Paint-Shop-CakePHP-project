<?php
/**
 * routes.php — Online Paint Shop routing
 */
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        // Homepage
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'home']);

        // Customer auth
        $builder->connect('/register', ['controller' => 'Customers', 'action' => 'register']);
        $builder->connect('/login',    ['controller' => 'Customers', 'action' => 'login']);
        $builder->connect('/logout',   ['controller' => 'Customers', 'action' => 'logout']);

        // Paints (product list & detail)
        $builder->connect('/paints',        ['controller' => 'Paints', 'action' => 'index']);
        $builder->connect('/paints/{id}',   ['controller' => 'Paints', 'action' => 'view'])
                ->setPatterns(['id' => '\d+']);

        // Cart
        $builder->connect('/cart',              ['controller' => 'Carts', 'action' => 'index']);
        $builder->connect('/cart/add/{id}',     ['controller' => 'Carts', 'action' => 'add'])
                ->setPatterns(['id' => '\d+']);
        $builder->connect('/cart/remove/{id}',  ['controller' => 'Carts', 'action' => 'remove'])
                ->setPatterns(['id' => '\d+']);
        $builder->connect('/cart/clear',        ['controller' => 'Carts', 'action' => 'clear']);

        // Orders
        $builder->connect('/orders',            ['controller' => 'Orders', 'action' => 'index']);
        $builder->connect('/orders/checkout',   ['controller' => 'Orders', 'action' => 'checkout']);
        $builder->connect('/orders/confirm',    ['controller' => 'Orders', 'action' => 'confirm']);
        $builder->connect('/orders/{id}',       ['controller' => 'Orders', 'action' => 'view'])
                ->setPatterns(['id' => '\d+']);

        // Staff / admin
        $builder->connect('/admin/orders',      ['controller' => 'Orders', 'action' => 'adminIndex']);
        $builder->connect('/admin/orders/update-status/{id}', ['controller' => 'Orders', 'action' => 'updateStatus'])
                ->setPatterns(['id' => '\d+']);
        $builder->connect('/admin/paints',      ['controller' => 'Paints', 'action' => 'adminIndex']);

        // Warehouse
        $builder->connect('/warehouse',         ['controller' => 'PaintsStorages', 'action' => 'index']);
        $builder->connect('/warehouse/restock', ['controller' => 'PaintsStorages', 'action' => 'restock']);

        $builder->fallbacks(DashedRoute::class);
    });
};
