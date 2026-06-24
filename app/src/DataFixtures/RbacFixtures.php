<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Fedale\RbacBundle\Bridge\Doctrine\Entity\AuthAssignment;
use Fedale\RbacBundle\Bridge\Doctrine\Entity\AuthItem;
use Fedale\RbacBundle\Bridge\Doctrine\Entity\AuthItemChild;
use Fedale\RbacBundle\Enum\AuthItemType;

/**
 * RBAC seed (fedale/rbac-bundle) for the DynamicVoter demo on EDIT_INVOICE.
 *
 *   - ROLE_EDITOR (role) -> EDIT_INVOICE (permission): users who have
 *     ROLE_EDITOR in their token (e.g. massimo, gabriella) get EDIT_INVOICE
 *     through the hierarchy.
 *   - EDIT_INVOICE assigned DIRECTLY to 'gianna' (ROLE_TECHNICIAN only):
 *     showcase of the direct-to-user permission — bypasses the hierarchy
 *     without granting ROLE_EDITOR.
 *
 * No dependency on UserFixtures: auth_assignment.user_id is the userIdentifier
 * (the provider's `username` property), not a FK to User.
 */
final class RbacFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roleEditor = (new AuthItem())
            ->setName('ROLE_EDITOR')
            ->setType(AuthItemType::ROLE)
            ->setDescription('Editor');

        $editInvoice = (new AuthItem())
            ->setName('EDIT_INVOICE')
            ->setType(AuthItemType::PERMISSION)
            ->setDescription('Edit invoices');

        $manager->persist($roleEditor);
        $manager->persist($editInvoice);

        // Role -> permission hierarchy.
        $manager->persist(new AuthItemChild($roleEditor, $editInvoice));

        // Direct permission assignment to a user (bypasses the hierarchy).
        $manager->persist(new AuthAssignment($editInvoice, 'gianna'));

        $manager->flush();
    }
}
