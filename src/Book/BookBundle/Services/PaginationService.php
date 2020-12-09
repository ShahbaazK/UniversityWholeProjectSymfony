<?php
/**
 * Created by PhpStorm.
 * User: arslaan
 * Date: 04/01/19
 * Time: 17:58
 */

namespace Book\BookBundle\Services;


use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PaginationService
{
    private $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    public function createPaginator($query, $numberOfItems, Request $request)
    {
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $numberOfItems
        );

        return $pagination;
    }
}