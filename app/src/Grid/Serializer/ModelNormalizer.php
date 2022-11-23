<?php 

namespace App\Grid\Serializer;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ModelNormalizer implements  NormalizerInterface, CacheableSupportsMethodInterface
{
    public function __construct(
        #[Autowire(service: ObjectNormalizer::class)]
        private NormalizerInterface $normalizer
    ) {
    }
    
    public function normalize(mixed $object, ?string $format = null, array $context = [])
    {
        dump($object, $format, $context);        
    }

    public function supportsNormalization(mixed $data, ?string $format = null): bool
    {
        dump($data, $format);
        return true;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

}