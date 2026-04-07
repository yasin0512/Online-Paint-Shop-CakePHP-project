<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;

/**
 * OrdersController
 *
 * Handles checkout flow and order management.
 */
class OrdersController extends AppController
{
    /**
     * GET /orders — customer's own order history
     */
    public function index(): void
    {
        $customer = $this->Authentication->getIdentity();
        $orders = $this->Orders->find()
            ->where(['Orders.customer_id' => $customer->get('id')])
            ->contain(['OrdersPaints.Paints'])
            ->orderBy(['Orders.date' => 'DESC'])
            ->all();

        $this->set(compact('orders'));
    }

    /**
     * GET /orders/{id} — view a single order
     */
    public function view(int $id): void
    {
        $customer = $this->Authentication->getIdentity();
        $order = $this->Orders->get($id, contain: ['OrdersPaints.Paints', 'Customers', 'Payments', 'Shipments']);

        // Only allow the owner or admin to view
        if ($order->customer_id !== $customer->get('id')) {
            $this->Flash->error(__('Not authorised.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('order'));
    }

    /**
     * GET/POST /orders/checkout — review cart & enter info
     */
    public function checkout(): void
    {
        $customer = $this->Authentication->getIdentity();
        $cartItems = $this->_getCartWithPaints();

        if (empty($cartItems)) {
            $this->Flash->error(__('Your cart is empty.'));
            return $this->redirect(['controller' => 'Carts', 'action' => 'index']);
        }

        $subtotal = array_sum(array_column($cartItems, 'subtotal'));
        $shipping = 150;
        $total    = $subtotal + $shipping;

        $this->set(compact('cartItems', 'subtotal', 'shipping', 'total', 'customer'));
    }

    /**
     * POST /orders/confirm — place the order
     */
    public function confirm(): \Cake\Http\Response
    {
        $this->request->allowMethod(['post']);
        $customer  = $this->Authentication->getIdentity();
        $cartItems = $this->_getCartWithPaints();

        if (empty($cartItems)) {
            $this->Flash->error(__('Your cart is empty.'));
            return $this->redirect(['controller' => 'Carts', 'action' => 'index']);
        }

        $subtotal = array_sum(array_column($cartItems, 'subtotal'));
        $shipping = 150;
        $total    = $subtotal + $shipping;

        // Build order entity
        $orderData = [
            'customer_id'   => $customer->get('id'),
            'date'          => new DateTime(),
            'status'        => 'pending',
            'total'         => $total,
            'orders_paints' => array_map(fn($item) => [
                'paint_id' => $item['paint']->id,
                'quantity' => $item['quantity'],
                'subtotal' => $item['subtotal'],
            ], $cartItems),
            'payments' => [[
                'customer_id' => $customer->get('id'),
                'type'        => $this->request->getData('payment_type', 'cash'),
                'acct_no'     => $this->request->getData('acct_no', ''),
                'amount'      => $total,
            ]],
            'shipments' => [[
                'customer_id' => $customer->get('id'),
                'seq_num'     => rand(100000, 999999),
                'type'        => $this->request->getData('shipment_type', 'standard'),
            ]],
        ];

        $order = $this->Orders->newEntity($orderData, [
            'associated' => ['OrdersPaints', 'Payments', 'Shipments'],
        ]);

        if ($this->Orders->save($order, ['associated' => ['OrdersPaints', 'Payments', 'Shipments']])) {
            // Deduct stock
            foreach ($cartItems as $item) {
                $this->_deductStock($item['paint']->id, $item['quantity']);
            }
            // Clear cart
            $this->request->getSession()->delete('cart');
            $this->Flash->success(__('Order #{0} placed successfully!', $order->id));
            return $this->redirect(['action' => 'view', $order->id]);
        }

        $this->Flash->error(__('Could not place order. Please try again.'));
        return $this->redirect(['action' => 'checkout']);
    }

    /**
     * GET /admin/orders — staff view of all orders
     */
    public function adminIndex(): void
    {
        $orders = $this->Orders->find()
            ->contain(['Customers', 'OrdersPaints.Paints'])
            ->orderBy(['Orders.date' => 'DESC'])
            ->all();

        $this->set(compact('orders'));
        $this->render('admin_index');
    }

    /**
     * POST /admin/orders/update-status/{id}
     */
    public function updateStatus(int $id): \Cake\Http\Response
    {
        $this->request->allowMethod(['post']);
        $order  = $this->Orders->get($id);
        $status = $this->request->getData('status');
        $order  = $this->Orders->patchEntity($order, compact('status'));

        if ($this->Orders->save($order)) {
            $this->Flash->success(__('Order status updated to "{0}".', $status));
        } else {
            $this->Flash->error(__('Could not update status.'));
        }

        return $this->redirect(['action' => 'adminIndex']);
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------
    private function _getCartWithPaints(): array
    {
        $cart = $this->request->getSession()->read('cart') ?? [];
        if (empty($cart)) return [];

        $paints = $this->fetchTable('Paints')
            ->find()->where(['Paints.id IN' => array_keys($cart)])
            ->all()->indexBy('id')->toArray();

        $items = [];
        foreach ($cart as $paintId => $qty) {
            if (isset($paints[$paintId])) {
                $items[] = [
                    'paint'    => $paints[$paintId],
                    'quantity' => $qty,
                    'subtotal' => $paints[$paintId]->price * $qty,
                ];
            }
        }
        return $items;
    }

    private function _deductStock(int $paintId, int $qty): void
    {
        $psTable = $this->fetchTable('PaintsStorages');
        $records = $psTable->find()
            ->where(['paint_id' => $paintId, 'quantity >' => 0])
            ->orderBy(['id' => 'ASC'])
            ->all();

        foreach ($records as $rec) {
            if ($qty <= 0) break;
            $deduct = min($rec->quantity, $qty);
            $rec->quantity -= $deduct;
            $qty -= $deduct;
            $psTable->save($rec);
        }
    }
}
