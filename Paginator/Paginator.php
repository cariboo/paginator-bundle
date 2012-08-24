<?php

namespace Cariboo\PaginatorBundle\Paginator;

use Symfony\Component\HttpFoundation\Request as Request;
use Doctrine\ORM\Query as Query;
use DoctrineExtensions\Paginate\Paginate;

class Paginator
{
//    const DEFAULT_ORDER = "p";            // Préfixe du n° de page dans l'URL
    const DEFAULT_ITEMS_PER_PAGE = 10;      // Nombre d'articles par page
    const DEFAULT_MAX_PAGER_ITEMS = 10;     // Nombre de n° de pages visibles

    /**
     * @var int $currentPage
     */
    protected $currentPage;
    /**
     * @var Object[] currentPageResults
     */
    protected $currentPageResults;
    /**
     * @var int $defaultItemsPerPage
     */
//    protected $defaultItemsPerPage;
    /**
     * @var int $itemsPerPage
     */
    protected $itemsPerPage;
    /**
     * @var int $maxPagerItems
     */
    protected $maxPagerItems;
    /**
     * @var int $nbResults
     */
    protected $nbResults;
    /**
     * @var string $orderby
     */
//    protected $orderBy;


    /**
     * @param Symfony\Component\HttpFoundation\Request $request
     */
    public function __construct($itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE, $maxPagerItems = self::DEFAULT_MAX_PAGER_ITEMS)
    {
        $this->setItemsPerPage((int)$itemsPerPage);
        $this->setMaxPagerItems((int)$maxPagerItems);
        
        $this->nbResults = 0;
        $this->currentPage = 1;
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $itemsPerPage
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = (int)$itemsPerPage;
    }

    /**
     * @return int
     */
    public function getMaxPagerItems()
    {
        return $this->maxPagerItems;
    }

    /**
     * @param int $maxPagerItems
     */
    public function setMaxPagerItems($maxPagerItems)
    {
        $this->maxPagerItems = (int)$maxPagerItems;
    }

    /**
     * Transforms the given Doctrine DQL into a paginated query
     * If you need to paginate various queries in the same controller, you need to specify an $id
     *
     * @param Doctrine\ORM\Query $query
     */
    public function paginate(Query $query)
    {
        $this->nbResults = (int)Paginate::getTotalQueryResults($query);
        $offset = ($this->getCurrentPage() - 1) * $this->getItemsPerPage();
        $this->currentPageResults = $query
            ->setFirstResult($offset)
            ->setMaxResults($this->getItemsPerPage())
            ->getResult();
    }

    /**
     * Get the current page number
     * 
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set the current page number
     * 
     * @param int page
     */
    public function setCurrentPage($page)
    {
        $this->currentPage = $page;
    }

    /**
     * Get the current page results
     * 
     * @return Object[]
     */
    public function getCurrentPageResults()
    {
        return $this->currentPageResults;
    }

    /**
     * Get the current page URL part
     * 
     * @return string
     */
/*    public function getCurrent()
    {
        $url = $this->getOrderBy() . $this->currentPage;
        if ($this->getItemsPerPage() != self::DEFAULT_ITEMS_PER_PAGE) $url .= '-' . $this->getItemsPerPage();
        
        return $url;
    }
*/
    /**
     * Get the sort order
     * 
     * @return string
     */
/*    public function getOrderBy()
    {
        return $this->orderBy;
    }
*/
    /**
     * Set the sort order
     * 
     * @param string order
     */
/*    public function setOrderBy($order)
    {
        $this->orderBy = $order;
    }
*/
    /**
     * Is the next page available ?
     *
     * @return boolean
     */
    public function hasNextPage()
    {
        return ($this->getCurrentPage() + 1 <= $this->getLastPage());
    }

    /**
     * Get the next page number
     *
     * @return int
     */
    public function getNextPage()
    {
        return $this->getCurrentPage() + 1;
    }

    /**
     * Get the next page URL part
     *
     * @return string
     */
/*    public function getNext()
    {
        $url = $this->getOrderBy() . $this->getNextPage();
        if ($this->getItemsPerPage() != self::DEFAULT_ITEMS_PER_PAGE) $url .= '-' . $this->getItemsPerPage();
        
        return $url;
    }
*/
    /**
     * Is the previous page available ?
     *
     * @return boolean
     */
    public function hasPreviousPage()
    {
        return ($this->getCurrentPage() - 1 >= $this->getFirstPage());
    }

    /**
     * Get the previous page number
     *
     * @return int
     */
    public function getPreviousPage()
    {
        return $this->getCurrentPage() - 1;
    }

    /**
     * Get the previous page URL part
     *
     * @return string
     */
/*    public function getPrevious()
    {
        $url = $this->getOrderBy() . $this->getPreviousPage();
        if ($this->getItemsPerPage() != self::DEFAULT_ITEMS_PER_PAGE) $url .= '-' . $this->getItemsPerPage();
        
        return $url;
    }
*/
    /**
     * @return int
     */
    public function getMaxPageInRange()
    {
        $range = (int)floor($this->getMaxPagerItems()/2);
        if (($this->getCurrentPage() + $range) > $this->getLastPage()) {
            return $this->getLastPage();
        } else {
            return $this->getCurrentPage() + $range;
        }
    }

    /**
     * @return int
     */
    public function getMinPageInRange()
    {
        $range = (int)floor($this->getMaxPagerItems()/2);
        if (($this->getCurrentPage() - $range) < $this->getFirstPage()) {
            return $this->getFirstPage();
        } else {
            return $this->getCurrentPage() - $range;
        }
    }

    /**
     * Get the number or results in the non-paginated version of the query
     *
     * @return int
     */
    public function getNbResults()
    {
        return $this->nbResults;
    }

    /**
     * Gets the last page number
     *
     * @return int
     */
    public function getLastPage()
    {
        if ($this->getNbResults() > 0) {
            return (int)ceil($this->getNbResults() / $this->getItemsPerPage());
        } else {
            return 1;
        }
    }

    /**
     * Get the last page URL part
     *
     * @return string
     */
/*    public function getLast()
    {
        $url = $this->getOrderBy() . $this->getLastPage();
        if ($this->getItemsPerPage() != self::DEFAULT_ITEMS_PER_PAGE) $url .= '-' . $this->getItemsPerPage();
        
        return $url;
    }
*/
    /**
     * Get page n URL part
     * 
     * @return string
     */
/*    public function getPage($page)
    {
        $url = $this->getOrderBy() . $page;
        if ($this->getItemsPerPage() != self::DEFAULT_ITEMS_PER_PAGE) $url .= '-' . $this->getItemsPerPage();

        return $url;
    }
*/
    /**
     * Get the first page number
     * 
     * @return int
     */
    public function getFirstPage()
    {
        return 1;
    }

    /**
     * Get the first page URL part
     * Change the sort order and return de first page URL part if a new order is provided
     *
     * @param string order
     * @return string
     */
/*    public function getFirst($order = '')
    {
        $url = ($order != '' ? $order : $this->getOrderBy()) . $this->getFirstPage();
        if ($this->getItemsPerPage() != self::DEFAULT_ITEMS_PER_PAGE) $url .= '-' . $this->getItemsPerPage();
        
        return $url;
    }*/
}
