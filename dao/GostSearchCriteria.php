<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * Search criteria for {@link GostDao}.
 * <p>
 * Can be easily extended without changing the {@link GostDao} API.
 */
final class GostSearchCriteria {

    private $sort = null;


    /**
     * @return string
     */
    public function getSort() {
        return $this->sort;
    }

    /**
     * @return GostSearchCriteria
     */
    public function setSort($sort) {
        $this->sort = $sort;
        return $this;
    }

}

?>
