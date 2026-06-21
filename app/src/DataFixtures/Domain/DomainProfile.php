<?php

namespace App\DataFixtures\Domain;

/**
 * Describes the whole vocabulary of a single business field (e.g. "idrotermica
 * sanitaria", "manutenzione porte e serrande").
 *
 * One implementation = one domain. To spin up a Repara instance for a new field,
 * add a class implementing this interface and select it via the FIXTURE_DOMAIN
 * env var; the fixtures themselves stay domain-agnostic.
 */
interface DomainProfile
{
    /** Stable identifier used to select the profile (matches FIXTURE_DOMAIN). */
    public function key(): string;

    /** Human readable label, e.g. "Idrotermica sanitaria". */
    public function label(): string;

    /** Verbs used to compose project names, e.g. "Manutenzione". @return string[] */
    public function projectActions(): array;

    /** Things a project acts on, e.g. "centrale termica". @return string[] */
    public function projectSubjects(): array;

    /** Verbs used to compose task names, e.g. "Sostituzione". @return string[] */
    public function taskActions(): array;

    /** Components a task acts on, e.g. "valvola di sicurezza". @return string[] */
    public function taskSubjects(): array;

    /** Asset type names, e.g. "Climatizzazione". @return string[] */
    public function assetTypes(): array;

    /** Brand names relevant to the field, e.g. "Vaillant". @return string[] */
    public function assetBrands(): array;

    /** Equipment names used to compose asset names, e.g. "Caldaia a condensazione". @return string[] */
    public function assetEquipment(): array;

    /** Commercial product-line names used to compose model names, e.g. "EcoTherm Plus". @return string[] */
    public function assetModelSeries(): array;

    /** Subjects for asset attachment images/documents, e.g. "Foto installazione caldaia". @return string[] */
    public function attachmentSubjects(): array;
}
