<?php

namespace App\Controller\Gridview;

use App\Entity\Asset\Asset;
use App\Entity\Asset\AssetAttachment;
use Fedale\GridviewBundle\Controller\AbstractCrudGridController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gridview/asset-attachment', name: 'gridview_asset_attachment_')]
class AssetAttachmentController extends AbstractCrudGridController
{
    protected function getDataClass(): string
    {
        return AssetAttachment::class;
    }

    protected function configure(): array
    {
        return [
            'id'       => 'asset_attachment',
            'title'    => 'Allegato asset',
            'addLabel' => 'Nuovo allegato',
            'exportFilename' => 'allegati-asset',
        ];
    }

    protected function getDataProviderConfig(): array
    {
        return [
            'models' => AssetAttachment::class,
            'pagination' => ['defaultPageSize' => 20],
            'sort' => [
                'id'   => ['asc' => ['a.id'],   'desc' => ['a.id'],   'default' => 'desc'],
                'name' => ['asc' => ['a.name'], 'desc' => ['a.name'], 'default' => 'asc'],
            ],
        ];
    }

    /** @return array<int, mixed> */
    protected function buildColumns(): array
    {
        $assetChoices = [];
        foreach ($this->em()->getRepository(Asset::class)->findAll() as $asset) {
            $assetChoices[$asset->getName()] = $asset->getId();
        }

        return [
            'id',
            [
                'attribute' => 'name',
                'label' => 'Nome',
                'filter' => ['type' => 'text'],
                'editable' => true,
                'control' => [
                    'type' => 'text',
                    'required' => true,
                    'requiredMessage' => 'Il nome è obbligatorio.',
                ],
            ],
            [
                'attribute' => 'asset',
                'label' => 'Asset',
                'type' => 'relation',
                'value' => fn(array $data) => $data['asset']['name'] ?? '—',
                'filter' => [
                    'type' => 'relation',
                    'options' => ['choices' => $assetChoices, 'multiple' => true, 'searchable' => true],
                ],
                'control' => ['options' => ['class' => Asset::class, 'choice_label' => 'name']],
            ],
            [
                'attribute' => 'type',
                'label' => 'Tipo',
                'filter' => ['type' => 'text'],
                'editable' => true,
                'control' => ['type' => 'text', 'required' => true],
            ],
            ['attribute' => 'filename', 'label' => 'File', 'control' => ['type' => 'text', 'required' => true]],
            ['attribute' => 'path', 'label' => 'Percorso', 'visible' => false, 'control' => ['type' => 'text', 'required' => true]],
            ['attribute' => 'size', 'label' => 'Dimensione', 'type' => 'number', 'control' => ['type' => 'number', 'required' => true]],
            [
                'attribute' => 'active',
                'label' => 'Attivo',
                'type' => 'boolean',
                'filter' => ['type' => 'boolean'],
                'batchUpdate' => true,
                'editable' => true,
                'control' => ['type' => 'boolean', 'required' => false],
            ],
            ['type' => 'action', 'label' => 'Azioni'],
        ];
    }
}
