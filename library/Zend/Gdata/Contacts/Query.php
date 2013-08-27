<?php

require_once('Zend/Gdata/Query.php');

/**
 * Assists in constructing queries for Google Document List documents
 *
 * @link http://code.google.com/apis/gdata/spreadsheets/
 */
class Zend_Gdata_Contacts_Query extends Zend_Gdata_Query
{

    const ORDER_LASTMODIFIED = "lastmodified";

    /**
     * Sets the ordering for results. Some supported ordering schemes may be
     * found using the self::ORDER_* constants.
     *
     * @param string $type Ordering scheme label
     * @return boolean True if successfully set, false otherwise
     */
    public function setOrdering($type);

    /**
     * Retrieves the ordering used when making queries.
     *
     * @return string
     */
    public function getOrdering();

    /**
     * Sets sort order. True for ascending, false for descending.
     *
     * @param boolean $asc
     */
    public function setAscending($asc);

    /**
     * Retrieves sort order. True for ascending, false for descending.
     *
     * @return boolean
     */
    public function isAscending();

    /**
     * Sets whether "deleted" contacts are returned in results or not.
     *
     * @param boolean $show
     */
    public function setShowingDeleted($show);

    /**
     * Retrives whether or not "deleted" contacts will appear in results.
     *
     * @return boolean
     */
    public function isShowingDeleted();

    /**
     * Sets the group ID that a contact must exist within in order to be in the
     * query result. This group ID will typically be an URI.
     *
     * Any setting other than a positive-length string will disable this
     * result restriction.
     *
     * @link http://code.google.com/apis/contacts/reference.html#GroupElements
     * @param string $uri
     */
    public function setGroup($uri);

    /**
     * Sets the projection for this query. Valid values for Contacts are "full",
     * "thin", and "property-KEY" where KEY is an extended property name.
     *
     * Projections mainly influence the visibility of extended properties.
     *
     * @param string $value
     */
    public function setProjection($value);


    /**
     * Gets the projection for this query.
     *
     * @return string projection
     */
    public function getProjection();


    /**
     * Gets the full query URL for this query.
     *
     * @return string url
     */
    public function getQueryUrl();

}