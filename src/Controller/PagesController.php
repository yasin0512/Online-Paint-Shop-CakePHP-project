<?php
declare(strict_types=1);

namespace App\Controller;

class PagesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['home']);
    }

    public function home(): void
    {
        // Show featured paints on homepage
        $featuredPaints = $this->fetchTable('Paints')
            ->find()
            ->limit(6)
            ->orderBy(['Paints.name' => 'ASC'])
            ->all();

        $this->set(compact('featuredPaints'));
    }
}
