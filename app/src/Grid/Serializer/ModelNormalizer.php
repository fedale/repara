<?php 

namespace App\Grid\Serializer;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;


class ModelNormalizer implements NormalizerInterface
{
    public function __construct(
        private ObjectNormalizer  $normalizer
    ) { }
    
    public function normalize(mixed $object, ?string $format = null, array $context = [])
    {
        dump($object, $format, $context);        
    }

    public function supportsNormalization(mixed $data, ?string $format = null)
    {
        dump($data, $format);
    }

}