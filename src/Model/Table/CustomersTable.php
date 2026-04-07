<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CustomersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Orders',   ['foreignKey' => 'customer_id']);
        $this->hasMany('Payments', ['foreignKey' => 'customer_id']);
        $this->hasMany('Shipments',['foreignKey' => 'customer_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('name');
        $validator->email('email');
        $validator->notEmptyString('password');
        $validator->notEmptyString('address');

        $validator
            ->scalar('phone')
            ->regex('phone', '/^[\d\-\(\) ]+$/', 'Phone must contain only digits, dashes, or parentheses.');

        return $validator;
    }

    public function findAuth(\Cake\ORM\Query\SelectQuery $query, array $options): \Cake\ORM\Query\SelectQuery
    {
        return $query->where(['Customers.email' => $options['email']]);
    }
}
