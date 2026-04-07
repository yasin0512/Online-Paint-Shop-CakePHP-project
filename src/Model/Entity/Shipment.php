<?php declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Shipment extends Entity {
    protected array $_accessible = [
        'order_id' => true, 'customer_id' => true,
        'seq_num' => true, 'type' => true, 'shipped_at' => true,
    ];
}
