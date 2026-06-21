<?php

namespace App\DataFixtures;

trait SlugifyTrait
{
    private function slugify(string $value): string
    {
        $value = \transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $value);
        $value = \preg_replace('/[^a-z0-9]+/', '-', $value);

        return \trim($value, '-');
    }
}
