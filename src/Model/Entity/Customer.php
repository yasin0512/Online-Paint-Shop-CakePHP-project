<?php declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Customer extends Entity {
    protected array $_accessible = [
        'name'     => true,
        'phone'    => true,
        'email'    => true,
        'address'  => true,
        'password' => true,
        'orders'   => true,
        'payments' => true,
        'shipments'=> true,
    ];

    protected array $_hidden = ['password'];
}
