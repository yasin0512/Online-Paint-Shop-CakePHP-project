<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class PaintsStoragesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('paints_storages');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', ['events' => ['Model.beforeSave' => ['start_date' => 'new']]]);
        $this->belongsTo('Paints',   ['foreignKey' => 'paint_id']);
        $this->belongsTo('Storages', ['foreignKey' => 'storage_id']);
    }
}
