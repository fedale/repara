<?php

namespace Fedale\GridviewBundle\Twig;

use Exception;
use Fedale\GridviewBundle\Component\PaginationInterface;
use Fedale\GridviewBundle\Component\PaginationView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PaginationExtension extends AbstractExtension
{
    /**
     * @var PaginationView
     */
    private PaginationView $paginationView;

    /**
     * PaginationExtension constructor.
     *
     * @param PaginationView $paginationView
     */
    public function __construct(PaginationView $paginationView)
    {
        $this->paginationView = $paginationView;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('gridPagination', [$this, 'init'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Render pagination block.
     *
     * @param Pagination $pagination instance of Pagination class
     * @param array $paginationOptions list of PaginationView class options
     *
     * @return string
     * @throws Exception
     */
    public function init(PaginationInterface $pagination, array $paginationOptions = []): string
    {
        $this->paginationView->setPagination($pagination);

        foreach ($paginationOptions as $optionName => $value) {

            $paginationView = new \ReflectionObject($this->paginationView);

            try {
                if ($paginationView->getProperty($optionName)->isPublic()) {
                    $this->paginationView->$optionName = $value;

                    continue;
                }
            } catch (Exception $a) {
                // throw new GridTwigException(
                throw new \Exception(
                    $a->getMessage() . ' in ' . PaginationView::class
                );
            }

            $setterMethodName = 'set' . ucfirst($optionName);

            if ($paginationView->hasMethod($setterMethodName)) {
                $this->paginationView->$setterMethodName($value);
            }
        }

        return $this->paginationView->renderPageButtons();
    }

    public function getName(): string
    {
        return get_class($this);
    }
}