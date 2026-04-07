<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', ['foreignKey' => 'customer_id', 'joinType' => 'INNER']);
        $this->hasMany('OrdersPaints', ['foreignKey' => 'order_id']);
        $this->hasMany('Payments',     ['foreignKey' => 'order_id']);
        $this->hasMany('Shipments',    ['foreignKey' => 'order_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->integer('customer_id')->notEmptyString('customer_id');
        $validator->decimal('total')->notEmptyString('total');
        $validator->inList('status', ['pending','inspecting','shipped','delivered','returned']);
        return $validator;
    }
}
