<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CustomersController
 *
 * Handles customer registration, login, and logout.
 */
class CustomersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }

    /**
     * GET/POST /register
     */
    public function register(): void
    {
        $customer = $this->Customers->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Hash password
            $data['password'] = md5($data['password']);
            $customer = $this->Customers->patchEntity($customer, $data);

            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('Registration successful! Please log in.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Could not register. Please check the form.'));
        }

        $this->set(compact('customer'));
    }

    /**
     * GET/POST /login
     */
    public function login(): void
    {
        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();
            if ($result->isValid()) {
                $redirect = $this->request->getQuery('redirect', ['controller' => 'Pages', 'action' => 'home']);
                return $this->redirect($redirect);
            }
            $this->Flash->error(__('Invalid email or password.'));
        }
    }

    /**
     * GET /logout
     */
    public function logout(): \Cake\Http\Response
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
        }
        return $this->redirect(['action' => 'login']);
    }
}
