<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Resolves the request locale from the `gv_locale` cookie written by the
 * gridview language switcher. This keeps the server's first paint and its
 * date/number formatting aligned with the locale the user last picked, so a
 * full page reload shows no language "flash". Client-side switching stays
 * instant (the JS runtime owns that); this only matters on full reloads.
 *
 * Runs before Symfony's LocaleListener (priority 16) so our value wins.
 */
final class LocaleSubscriber implements EventSubscriberInterface
{
    /** @param string[] $enabledLocales */
    public function __construct(
        private array $enabledLocales = ['en'],
        private string $defaultLocale = 'en',
        private string $cookieName = 'gv_locale',
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $locale = $request->cookies->get($this->cookieName);

        if (\is_string($locale) && \in_array($locale, $this->enabledLocales, true)) {
            $request->setLocale($locale);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => [['onKernelRequest', 20]]];
    }
}
