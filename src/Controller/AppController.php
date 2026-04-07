<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

/**
 * AppController — base controller for Online Paint Shop.
 */
class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication', [
            'logoutRedirect' => ['controller' => 'Customers', 'action' => 'login'],
        ]);

        // Make current user available in all views
        $this->set('currentUser', $this->Authentication->getIdentity());
    }
}
