<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PaintsStoragesController
 *
 * Warehouse keeper: view inventory levels and restock paints.
 * Low-stock threshold: quantity < (50 / 3) ≈ 17 cans.
 */
class PaintsStoragesController extends AppController
{
    private const LOW_STOCK_THRESHOLD = 17; // 1/3 of standard order qty (50)
    private const STANDARD_ORDER_QTY  = 50;

    /**
     * GET /warehouse — inventory overview
     */
    public function index(): void
    {
        $records = $this->PaintsStorages->find()
            ->contain(['Paints', 'Storages'])
            ->orderBy(['Paints.name' => 'ASC'])
            ->all();

        $lowStock = $records->filter(fn($r) => $r->quantity < self::LOW_STOCK_THRESHOLD);

        $this->set([
            'records'           => $records,
            'lowStock'          => $lowStock,
            'lowStockThreshold' => self::LOW_STOCK_THRESHOLD,
        ]);
    }

    /**
     * POST /warehouse/restock — add stock after delivery
     */
    public function restock(): \Cake\Http\Response
    {
        $this->request->allowMethod(['post']);

        $paintId   = (int)$this->request->getData('paint_id');
        $storageId = (int)$this->request->getData('storage_id');
        $qty       = (int)$this->request->getData('quantity', self::STANDARD_ORDER_QTY);

        $record = $this->PaintsStorages->find()
            ->where(['paint_id' => $paintId, 'storage_id' => $storageId])
            ->first();

        if ($record) {
            $record->quantity += $qty;
            $this->PaintsStorages->save($record);
            $this->Flash->success(__('Stock updated. New quantity: {0}', $record->quantity));
        } else {
            $this->Flash->error(__('Storage record not found.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
