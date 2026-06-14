<?php

namespace App\Export;

use Fedale\GridviewBundle\Export\ExporterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Example of a host-app custom exporter: implementing ExporterInterface is enough
 * (auto-tagged by the bundle), so it appears in the export menu next to CSV.
 */
class JsonExporter implements ExporterInterface
{
    public function getKey(): string
    {
        return 'json';
    }

    public function getLabel(): string
    {
        return 'JSON';
    }

    public function export(iterable $rows, iterable $columns, array $context = []): Response
    {
        $columns = \is_array($columns) ? $columns : iterator_to_array($columns);

        $data = [];
        $index = 0;
        foreach ($rows as $row) {
            $record = [];
            foreach ($columns as $column) {
                $value = $column->render($row, $index);
                $record[$column->getAttribute()] = \is_scalar($value) ? trim(strip_tags((string) $value)) : $value;
            }
            $data[] = $record;
            ++$index;
        }

        $response = new JsonResponse($data);
        $filename = ($context['filename'] ?? 'export') . '.json';
        $response->headers->set(
            'Content-Disposition',
            $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename)
        );

        return $response;
    }
}
