<?php declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Paint extends Entity {
    protected array $_accessible = [
        'name'        => true,
        'color'       => true,
        'color_code'  => true,
        'type'        => true,
        'description' => true,
        'price'       => true,
        'image'       => true,
        'paints_storages' => true,
        'orders_paints'   => true,
    ];
}
