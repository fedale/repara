# Data Fixtures — fixtures astratte + profili di dominio

Le fixtures della demo (`app/src/DataFixtures`) sono progettate per popolare
**più istanze di Repara, una per campo di business** (es. *idrotermica
sanitaria*, *manutenzione porte e serrande*) con dati coerenti col dominio,
**senza duplicare le fixtures**.

L'idea: le fixtures sono *astratte* rispetto al dominio (non contengono nomi di
prodotti, marchi o lavorazioni), mentre tutto il vocabolario specifico di un
campo vive in **una sola classe** — il *profilo di dominio*. Cambiare campo =
cambiare profilo, tramite una variabile d'ambiente.

```
src/DataFixtures/
├── Domain/
│   ├── DomainProfile.php             ← interfaccia: il "vocabolario" di un campo
│   ├── HydrothermalDomainProfile.php ← implementazione idrotermica (key: idrotermica)
│   └── DomainProfileProvider.php     ← sceglie il profilo attivo (env FIXTURE_DOMAIN)
├── SlugifyTrait.php                  ← slug condiviso (transliterazione + regex)
├── Project/
│   ├── ProjectFixture.php            ← fixtures agnostiche: leggono dal profilo
│   └── ProjectTaskFixture.php
└── Asset/
    ├── AssetTypeFixtures.php
    ├── AssetFixtures.php
    └── AssetAttachmentFixtures.php
```

## Il profilo di dominio

[`DomainProfile`](../app/src/DataFixtures/Domain/DomainProfile.php) è
un'interfaccia che dichiara tutto il vocabolario specifico di un campo:

| Metodo                  | Uso nelle fixtures                                   |
| ----------------------- | ---------------------------------------------------- |
| `key()`                 | identificatore stabile, confrontato con `FIXTURE_DOMAIN` |
| `label()`               | etichetta leggibile (es. `Idrotermica sanitaria`)    |
| `projectActions()`      | verbi per comporre i nomi dei progetti (`Manutenzione`) |
| `projectSubjects()`     | oggetti dei progetti (`centrale termica`)            |
| `taskActions()`         | verbi per i task (`Sostituzione`)                    |
| `taskSubjects()`        | componenti dei task (`valvola di sicurezza`)         |
| `assetTypes()`          | tipi di asset (`Climatizzazione`)                    |
| `assetBrands()`         | marchi del campo (`Vaillant`)                        |
| `assetEquipment()`      | attrezzature per i nomi degli asset (`Caldaia a condensazione`) |
| `attachmentSubjects()`  | soggetti delle immagini allegate (`Foto installazione caldaia`) |

Ogni campo ha **una** implementazione. Quella fornita è
[`HydrothermalDomainProfile`](../app/src/DataFixtures/Domain/HydrothermalDomainProfile.php)
(`key() === 'idrotermica'`).

## La selezione del profilo

[`DomainProfileProvider`](../app/src/DataFixtures/Domain/DomainProfileProvider.php)
riceve **tutti** i profili registrati e restituisce quello la cui `key()`
combacia con la variabile d'ambiente `FIXTURE_DOMAIN`; se nessuno combacia
lancia un'eccezione elencando le chiavi disponibili.

Il wiring è in [`config/services.yaml`](../app/config/services.yaml):

```yaml
parameters:
    # valore di default del campo se FIXTURE_DOMAIN non è impostata
    env(FIXTURE_DOMAIN): 'idrotermica'

services:
    # ogni profilo viene auto-taggato, così il provider li raccoglie tutti
    _instanceof:
        App\DataFixtures\Domain\DomainProfile:
            tags: ['app.fixture_domain_profile']

    App\DataFixtures\Domain\DomainProfileProvider:
        arguments:
            $profiles: !tagged_iterator app.fixture_domain_profile
            $activeKey: '%env(string:FIXTURE_DOMAIN)%'
```

Le fixtures iniettano il provider e leggono il vocabolario in `load()`:

```php
public function __construct(private readonly DomainProfileProvider $domains) {}

public function load(ObjectManager $manager): void
{
    $domain   = $this->domains->get();
    $actions  = $domain->projectActions();
    $subjects = $domain->projectSubjects();
    // ...
}
```

I valori *non* specifici del dominio (numero di progetti, stati, priorità,
colori, frasi descrittive via Faker) restano nelle fixtures: cambiano per
caso, non per campo.

## Le immagini degli allegati

[`AssetAttachmentFixtures`](../app/src/DataFixtures/Asset/AssetAttachmentFixtures.php)
genera **immagini raster reali** su disco, una per ogni `attachmentSubjects()`
del profilo, e collega gli `AssetAttachment` a quei file.

- Formato **JPEG** (800×500) generato con **GD + FreeType** (estensione
  installata nel `Dockerfile`, vedi sotto). Le immagini sono offline e
  deterministiche: nessun download di rete su migliaia di record.
- I file sono scritti in `public/uploads/asset/`; la directory `public` è
  iniettata via l'argomento `$publicDir` del servizio (vedi `services.yaml`).
- Ogni immagine è una card colorata con un badge (le iniziali del `label()` del
  profilo, es. `IDRO`) e il soggetto centrato (es. *"Schema impianto
  idraulico"*), quindi è coerente col campo.
- Il campo `type` salva l'estensione (`jpg`), com'è la convenzione delle upload
  reali (vedi `AssetAttachmentController`).

### GD nel Dockerfile

La generazione raster richiede l'estensione GD con FreeType e JPEG, installata
nello stage `app` del [`Dockerfile`](../Dockerfile):

```dockerfile
&& apt install -y ... libfreetype6-dev libjpeg62-turbo-dev libpng-dev fonts-dejavu-core \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install gd \
```

Il font usato per le etichette è `DejaVuSans-Bold.ttf` (pacchetto
`fonts-dejavu-core`).

### Visualizzazione e upload (gridview + VichUploader)

- **Cella**: la colonna di tipo `media` ([`MediaType`](../gridview-bundle/src/Column/Type/MediaType.php))
  rende un `<img>` inline per le estensioni immagine (jpg, png, svg, …) o un
  link di download altrimenti; il `value` punta a `/uploads/asset/<filename>`.
- **Upload**: il bundle Gridview gestisce la *fase 1* (ricezione/validazione del
  file: control `media` → `FileType`), poi su `POST_SUBMIT` passa l'`UploadedFile`
  alla closure `upload` del client. La *fase 2* (storage) è delegata a
  **VichUploaderBundle**: la closure in
  [`AssetAttachmentController`](../app/src/Controller/Gridview/AssetAttachmentController.php)
  fa solo `setImageFile($file)` (+ `setPath`); al flush Vich sposta il file in
  `public/uploads/asset` e popola `filename`/`size`/`type`.

Pezzi dell'integrazione Vich:

- `composer require vich/uploader-bundle` (Symfony Flex registra il bundle).
- Config in [`config/packages/vich_uploader.yaml`](../app/config/packages/vich_uploader.yaml):
  mapping `asset_attachment` → `uri_prefix: /uploads/asset`,
  `upload_destination: %kernel.project_dir%/public/uploads/asset`,
  `namer: SmartUniqueNamer`, `delete_on_update`/`delete_on_remove: true`.
- Entità [`AssetAttachment`](../app/src/Entity/Asset/AssetAttachment.php):
  `#[Vich\Uploadable]` + un campo **non** persistito
  `#[Vich\UploadableField(mapping: 'asset_attachment', fileNameProperty: 'filename', size: 'size', mimeType: 'type')] ?File $imageFile`,
  con `setImageFile()` che aggiorna `updatedAt` (così Vich/Doctrine rilevano la
  modifica anche quando cambia solo il file). I setter `setFilename/setType/setSize`
  accettano `null` perché Vich azzera i metadati su `delete_on_remove`/`delete_on_update`.

> Le **fixtures** non passano da Vich: generano i file e scrivono
> `filename/path/size/type` direttamente (Vich agisce solo quando si setta
> `imageFile`, cioè sugli upload reali dal form).

## Aggiungere un nuovo campo

Esempio: *manutenzione porte e serrande*.

1. Crea il profilo (viene auto-taggato grazie ad `_instanceof`):

   ```php
   // src/DataFixtures/Domain/DoorsShuttersDomainProfile.php
   namespace App\DataFixtures\Domain;

   final class DoorsShuttersDomainProfile implements DomainProfile
   {
       public function key(): string   { return 'porte-serrande'; }
       public function label(): string { return 'Manutenzione porte e serrande'; }

       public function projectActions(): array { return ['Installazione', 'Manutenzione', 'Motorizzazione', /* ... */]; }
       public function projectSubjects(): array { return ['serranda avvolgibile', 'portone sezionale', 'cancello scorrevole', /* ... */]; }
       public function taskActions(): array     { return ['Sostituzione', 'Registrazione', 'Lubrificazione', /* ... */]; }
       public function taskSubjects(): array    { return ['molla di torsione', 'motore tubolare', 'fotocellule', /* ... */]; }
       public function assetTypes(): array      { return ['Automazioni', 'Serrande', 'Portoni', /* ... */]; }
       public function assetBrands(): array     { return ['Came', 'Nice', 'BFT', 'Faac', /* ... */]; }
       public function assetEquipment(): array  { return ['Serranda avvolgibile', 'Motore tubolare', 'Centralina di comando', /* ... */]; }
       public function attachmentSubjects(): array { return ['Foto serranda', 'Schema motorizzazione', 'Targa dati motore', /* ... */]; }
   }
   ```

2. Imposta la variabile d'ambiente per quell'istanza:

   ```dotenv
   FIXTURE_DOMAIN=porte-serrande
   ```

3. Carica le fixtures — **nessuna modifica** alle fixtures è necessaria:

   ```bash
   docker compose exec app php bin/console doctrine:fixtures:load
   ```

> Nota: `doctrine:fixtures:load` **azzera il database**. Le immagini SVG vengono
> (ri)scritte in `public/uploads/asset/`.
