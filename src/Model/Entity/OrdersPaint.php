<?php declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class OrdersPaint extends Entity {
    protected array $_accessible = [
        'order_id' => true, 'paint_id' => true,
        'quantity' => true, 'subtotal' => true,
        'order' => true, 'paint' => true,
    ];
}
