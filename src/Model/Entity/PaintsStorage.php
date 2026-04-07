<?php declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class PaintsStorage extends Entity {
    protected array $_accessible = [
        'paint_id' => true, 'storage_id' => true,
        'quantity' => true, 'start_date' => true, 'end_date' => true,
        'paint' => true, 'storage' => true,
    ];
}
