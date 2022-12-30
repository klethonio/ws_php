<?php

/**
 * Description of Pager
 * Performs the management and pagination of system results.
 * @author Klethônio Ferreira
 */
class Pager
{
    /** RANGE */
    private $page;
    private $limit;
    private $offset;

    /** READ */
    private $table;
    private $condition;
    private $params;
    private $rowCount;

    /** PAGER */
    private $url;
    private $parseUrl;
    private $maxLinks;
    private $numPages;
    private $first;
    private $last;
    private $startRange;
    private $endRange;
    private $range;
    
    /** SELECT */
    private $ippArray;

    /** RENDER */
    private $pagination;

    /**
     * Pager constructor
     * @param string $first
     * @param string $last
     * @param int $maxLinks | Pages displayed
     * @param array $ippArray | Items per array
     */
    public function __construct(string $first = null, string $last = null, int $maxLinks = 5, array $ippArray = [10, 25, 50, 100]) {
        $this->url = (string) filter_input(INPUT_SERVER, 'PHP_SELF');
        $this->maxLinks = $maxLinks;
        $this->first = $first;
        $this->last = $last;
        $this->limit = filter_input(INPUT_GET, 'ipp', FILTER_VALIDATE_INT);
        $this->ippArray = $ippArray;
        if (in_array($this->limit, $this->ippArray)) {
            $this->parseUrl = "?ipp={$this->limit}&page=";
        } else {
            $this->limit = (int) $this->ippArray[0];
            $this->parseUrl = "?page=";
        }
    }

    /**
     * Performs pagination according to the imposed page and results limit per page
     * You must use LIMIT getLimit() and OFFSET getOffset() in the query you want to paginate.
     * @param int|string $page
     * @param int|string $limit
     */
    public function range($page, $limit = null) {
        $this->page = (int) $page ? $page : 1;
        $this->limit = (int) $limit ? $limit : $this->limit;
        $this->offset = ($this->page * $this->limit) - $this->limit;
    }

    /**
     * If you enter a page with a number greater than the results, this method navigates and returns to the last page with results.
     * @return header
     */
    public function returnPage() {
        header("Location: {$this->url}{$this->parseUrl}{$this->numPages}");
    }

    /**
     * Create the navigation menu inside an unordered list with the paginator class.
     * Enter the table name and conditions, if any. The rest is done by method.
     * To print the result use the <b>renderPagination()</b> method;
     * @param string $table
     * @param string $condition
     * @param array $params
     */
    public function exePagination(string $table, string $condition = null, array $params = null) {
        $this->table = $table;
        $this->condition = $condition;
        $this->params = $params;
        $read = new Read();
        $read->exeRead($this->table, $this->condition, $this->params);
        $this->rowCount = $read->count();
        $this->getSyntax();
    }

    /**
     * Returns the current page number. Can be used to validate navigation.
     * @return int
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Returns the limit of results per page. Must be used in the query that gets the results.
     * @return int
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * Returns the beginning of the page results reading. Must be used in the query that gets the results.
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * Returns the links to the pagination.
     * To styling: ul.paginator | li a | li span.current-page
     * @return string
     */
    public function renderPagination() {
        return $this->pagination;
    }

    /**
     * Returns a select with options for items per page.
     * To styling: select.pagination-ipp
     * @return string
     */
    public function renderSelectIpp() {
        $items = '';
        natsort($this->ippArray);
        foreach ($this->ippArray as $ippOpt) {
            $items .=  "<option value=\"$ippOpt\" " . ($ippOpt == $this->limit ? "selected" : "") . ">$ippOpt</option>\n";
        }
        return "<select class=\"pagination-ipp\" onchange=\"window.location='{$this->url}?ipp='+this[this.selectedIndex].value+'&page=1';return false\">$items</select>\n";
    }

    //PRIVATE
    //Generate pagination of results
    private function getSyntax() {
        if ($this->rowCount > $this->limit) {
            $this->numPages = (int) ceil($this->rowCount / $this->limit);
            $this->calcLinksRange();
            $this->parseFirstLast();
            $this->pagination = "<ul class=\"pagination\">";
            if ($this->range[0] > 1) {
                $this->pagination .= "<li><a title=\"{$this->first}\" href=\"{$this->url}{$this->parseUrl}1\">{$this->first}</a></li>";
            }
            if ($this->range[0] > 2) {
                $this->pagination .= "<li class=\"hidden-page\">...</li>";
            }
            $this->getRange();
            if ($this->endRange < $this->numPages - 1) {
                $this->pagination .= "<li class=\"hidden-page\">...</li>";
            }
            if ($this->endRange < $this->numPages) {
                $this->pagination .= "<li><a title=\"{$this->last}\" href=\"{$this->url}{$this->parseUrl}{$this->numPages}\">{$this->last}</a></li>";
            }
            $this->pagination .= "</ul>";
        }
    }

    //Calculates link boundaries around the current page
    private function calcLinksRange() {
        $this->startRange = $this->page - $this->maxLinks;
        $this->endRange = $this->page + $this->maxLinks;
        if ($this->startRange <= 0) {
            $this->endRange += abs($this->startRange) + 1;
        }
        if ($this->endRange > $this->numPages) {
            $this->startRange -= $this->endRange - $this->numPages;
            $this->endRange = $this->numPages;
        }
        if ($this->startRange <= 0) {
            $this->startRange = 1;
        }
        $this->range = range($this->startRange, $this->endRange);
    }

    //Generates the bounds of links around the current page in the list
    private function getRange() {
        $endRand = ($this->endRange < $this->numPages ? $this->endRange : $this->numPages);
        for ($iPag = $this->startRange; $iPag <= $endRand; $iPag++) {
            if (in_array($iPag, $this->range)) {
                $this->pagination .= $iPag == $this->page ? "<li class=\"current-page\">{$this->page}</li>" : "<li><a title=\"Página {$iPag}\" href=\"{$this->url}{$this->parseUrl}{$iPag}\">{$iPag}</a></li>";
            }
        }
    }

    private function parseFirstLast() {
        $this->first = $this->first ? $this->first : '1';
        $this->last = $this->last ? $this->first : (string) $this->numPages;
    }

}
