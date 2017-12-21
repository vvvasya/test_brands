<?php

namespace Test\Brands\Api\Data;

/**
 * @api
 */
interface BrandInterface
{

    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';
    const COLUMN_CREATED = 'created';
    const COLUMN_COUNTRY = 'country';
    const COLUMN_DESCRIPTION = 'description';

    /**
     * @return string
     */
    function getId();

    /**
     * @param $id
     * @return $this
     */
    function setId($id);

    /**
     * @return string
     */
    function getName();

    /**
     * @param $name
     * @return $this
     */
    function setName($name);

    /**
     * @return string
     */
    function getCreated();

    /**
     * @param $created
     * @return $this
     */
    function setCreated($created);

    /**
     * @return string
     */
    function getCountry();

    /**
     * @param $country
     * @return $this
     */
    function setCountry($country);

    /**
     * @return string
     */
    function getDescription();

    /**
     * @param $description
     * @return $this
     */
    function setDescription($description);



}