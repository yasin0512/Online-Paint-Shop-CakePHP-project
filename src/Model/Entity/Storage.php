<?php declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Storage extends Entity {
    protected array $_accessible = [
        'location' => true, 'capacity' => true,
        'paints_storages' => true,
    ];
}
