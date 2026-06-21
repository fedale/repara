<?php

namespace App\DataFixtures\Domain;

/**
 * Resolves the active {@see DomainProfile} from the FIXTURE_DOMAIN env var, so a
 * Repara instance loads coherent data for its own business field.
 */
final class DomainProfileProvider
{
    /**
     * @param iterable<DomainProfile> $profiles all registered domain profiles
     * @param string                  $activeKey value of FIXTURE_DOMAIN
     */
    public function __construct(
        private readonly iterable $profiles,
        private readonly string $activeKey,
    ) {
    }

    public function get(): DomainProfile
    {
        $available = [];
        foreach ($this->profiles as $profile) {
            if ($profile->key() === $this->activeKey) {
                return $profile;
            }
            $available[] = $profile->key();
        }

        throw new \RuntimeException(\sprintf(
            'No fixture domain profile registered for FIXTURE_DOMAIN="%s". Available: %s.',
            $this->activeKey,
            $available ? \implode(', ', $available) : '(none)',
        ));
    }
}
