<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CartsController
 *
 * Session-based shopping cart.
 * Cart structure stored in session: ['cart' => [paint_id => quantity, ...]]
 */
class CartsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Cart requires login
    }

    /**
     * GET /cart
     */
    public function index(): void
    {
        $cartItems = $this->_getCartWithPaints();
        $subtotal  = $this->_calcSubtotal($cartItems);
        $shipping  = $subtotal > 0 ? 150 : 0;
        $total     = $subtotal + $shipping;

        $this->set(compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    /**
     * POST /cart/add/{id}
     */
    public function add(int $id): \Cake\Http\Response
    {
        $this->request->allowMethod(['post']);

        $paint = $this->fetchTable('Paints')->get($id, contain: ['PaintsStorages']);
        $totalStock = array_sum(array_column($paint->paints_storages, 'quantity'));

        $cart = $this->request->getSession()->read('cart') ?? [];
        $currentQty = $cart[$id] ?? 0;
        $wantedQty  = $currentQty + (int)($this->request->getData('quantity', 1));

        if ($wantedQty > $totalStock) {
            $this->Flash->error(__('Insufficient inventory. Only {0} can(s) available.', $totalStock));
        } else {
            $cart[$id] = $wantedQty;
            $this->request->getSession()->write('cart', $cart);
            $this->Flash->success(__('"{0}" added to cart.', $paint->name));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * POST /cart/remove/{id}
     */
    public function remove(int $id): \Cake\Http\Response
    {
        $this->request->allowMethod(['post']);
        $cart = $this->request->getSession()->read('cart') ?? [];
        unset($cart[$id]);
        $this->request->getSession()->write('cart', $cart);
        $this->Flash->success(__('Item removed from cart.'));
        return $this->redirect(['action' => 'index']);
    }

    /**
     * POST /cart/clear
     */
    public function clear(): \Cake\Http\Response
    {
        $this->request->allowMethod(['post']);
        $this->request->getSession()->delete('cart');
        $this->Flash->success(__('Cart cleared.'));
        return $this->redirect(['action' => 'index']);
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------
    private function _getCartWithPaints(): array
    {
        $cart = $this->request->getSession()->read('cart') ?? [];
        if (empty($cart)) {
            return [];
        }

        $paints = $this->fetchTable('Paints')
            ->find()
            ->where(['Paints.id IN' => array_keys($cart)])
            ->all()
            ->indexBy('id')
            ->toArray();

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

    private function _calcSubtotal(array $cartItems): float
    {
        return array_sum(array_column($cartItems, 'subtotal'));
    }
}
