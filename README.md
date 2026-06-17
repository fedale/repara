# repara — app di test / demo

App Symfony di test e demo per i bundle Fedale.

## Struttura dei repository

Il bundle **Gridview** vive ora in un **repo git separato** (destinato a Packagist
come `fedale/gridview-bundle`), tenuto come directory *sibling* di questo repo:

```
~/Documenti/projects/
├── gridview-bundle/      ← repo del bundle (fedale/gridview-bundle)
└── repara/               ← questo repo (app demo)
    ├── app/              ← app Symfony
    └── FedaleCalendarBundle/  ← ancora path bundle interno
```

L'app consuma il bundle Gridview come path repository di Composer (vedi
`app/composer.json` → `repositories`), che punta a `../gridview-bundle`.

## Setup locale (Docker)

Il bundle Gridview NON è più nel build context: in sviluppo viene fornito tramite
volume mount (`docker-compose.yml`: `../gridview-bundle:/srv/gridview-bundle`) e
Composer va eseguito **dentro il container** (così i path `../gridview-bundle`
relativi a `/srv/app` risolvono correttamente).

```bash
# clona entrambi i repo come sibling
git clone <url-app>            repara
git clone <url-gridview>       gridview-bundle

cd repara
docker compose up -d --build
docker compose exec app composer install
```

Le modifiche al sorgente del bundle in `../gridview-bundle` sono immediatamente
visibili nell'app (Composer crea un symlink in `vendor/fedale/gridview-bundle`).

## Note

- **Build di produzione**: attualmente disattivato (vedi `TODO(prod)` nel
  `Dockerfile`). Andrà riabilitato consumando `fedale/gridview-bundle` da Packagist
  con una versione stabile, invece del path repo locale.
- **FedaleCalendarBundle** resta per ora un path bundle interno a questo repo.
