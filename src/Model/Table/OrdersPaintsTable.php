<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class OrdersPaintsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('orders_paints');
        $this->setPrimaryKey('id');
        $this->belongsTo('Orders', ['foreignKey' => 'order_id']);
        $this->belongsTo('Paints', ['foreignKey' => 'paint_id']);
    }
}
