<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;


class TwigNumberByTypeExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [
            new TwigFilter('manyBook', [$this, 'searchPlural'], ['is_safe' => ['html', 'twig']]),
            new TwigFilter('zeroOrOneBook', [$this, 'searchSingular'], ['is_safe' => ['html', 'twig']])
        ];
    }

    public function searchSingular(string $search): string
    {
        return 'livre trouvé pour la recherche : ' . $search;
    }

    public function searchPlural(string $search): string
    {
        return 'livres trouvés pour la recherche : ' . $search;
    }


}