<?php declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Payment extends Entity {
    protected array $_accessible = [
        'order_id' => true, 'customer_id' => true,
        'acct_no' => true, 'type' => true,
        'amount' => true, 'paid_at' => true,
    ];
}
