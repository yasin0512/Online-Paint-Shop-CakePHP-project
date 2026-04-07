<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * PaintsController
 *
 * Handles product listing and detail pages.
 */
class PaintsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Allow unauthenticated access to product pages
        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }

    /**
     * GET /paints
     * Show all available paints with their current stock.
     */
    public function index(): void
    {
        $query = $this->Paints->find()
            ->contain(['PaintsStorages'])
            ->orderBy(['Paints.name' => 'ASC']);

        $paints = $this->paginate($query);

        $this->set(compact('paints'));
    }

    /**
     * GET /paints/{id}
     * Show a single paint product with stock info.
     */
    public function view(int $id): void
    {
        $paint = $this->Paints->get($id, contain: ['PaintsStorages.Storages']);

        if (!$paint) {
            throw new NotFoundException(__('Paint not found.'));
        }

        // Total stock across all storage locations
        $totalStock = array_sum(array_column($paint->paints_storages, 'quantity'));

        $this->set(compact('paint', 'totalStock'));
    }

    /**
     * GET /admin/paints
     * Admin: manage paint inventory.
     */
    public function adminIndex(): void
    {
        $this->request->allowMethod(['get']);
        $paints = $this->Paints->find()->contain(['PaintsStorages'])->all();
        $this->set(compact('paints'));
        $this->render('admin_index');
    }
}
