<?php declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Table;
class StoragesTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);
        $this->setTable('storages');
        $this->addBehavior('Timestamp');
        $this->hasMany('PaintsStorages', ['foreignKey' => 'storage_id']);
    }
}
