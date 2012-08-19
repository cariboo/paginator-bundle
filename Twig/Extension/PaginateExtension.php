<?php

/*
 *
 */

namespace Cariboo\SimplePaginatorBundle\Twig\Extension;

use Cariboo\SimplePaginatorBundle\Paginator\Paginator as Paginator;


class PaginatorExtension extends Twig_Extension
{

    public function getName()
    {
        return 'paginate';
    }

    public function getFilters()
    {
        return array(
            'paginator' => new Twig_Filter_Method($this, 'simple_paginate')
        );
    }

    public function simple_paginate(Paginator $paginator)
    {
        return $paginator->render();
    }
}

