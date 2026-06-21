<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Smoke test per fedale/access-control-voter-bundle: l'attributo EDIT_INVOICE
 * NON e' un ruolo ne' una costante di codice, e' deciso a runtime dal
 * DynamicVoter leggendo la tabella `permission_rule`.
 *
 * Atteso: 200 per un utente i cui ruoli soddisfano una regola allow su
 * EDIT_INVOICE (es. ROLE_EDITOR), 403 altrimenti.
 *
 * NB: il firewall di richiesta (fedale/access-control-bundle, default deny)
 * gira prima del voter; per raggiungere questa azione serve una regola
 * `access_control` che lasci passare il path ^/demo.
 */
class DemoVoterController extends AbstractController
{
    #[Route('/demo/edit-invoice', name: 'demo_edit_invoice', methods: ['GET'])]
    #[IsGranted('EDIT_INVOICE')]
    public function editInvoice(): JsonResponse
    {
        return $this->json([
            'ok' => true,
            'attribute' => 'EDIT_INVOICE',
            'message' => 'Granted by a DB-driven permission_rule via DynamicVoter.',
        ]);
    }
}
