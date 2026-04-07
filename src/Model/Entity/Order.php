<?php declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Order extends Entity {
    protected array $_accessible = [
        'customer_id'   => true,
        'date'          => true,
        'status'        => true,
        'total'         => true,
        'customer'      => true,
        'orders_paints' => true,
        'payments'      => true,
        'shipments'     => true,
    ];
}
