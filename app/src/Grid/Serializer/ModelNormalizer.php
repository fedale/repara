<?php 

namespace App\Grid\Serializer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ModelNormalizer implements  NormalizerInterface
{
    public function __construct(private ObjectNormalizer $normalizer)
    {
        
    }
    
    public function normalize(mixed $object, ?string $format = null, array $context = [])
    {
        dump($object, $format, $context);        
    }

    public function supportsNormalization(mixed $data, ?string $format = null): bool
    {
        dd($data, $format);
        return true;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

}