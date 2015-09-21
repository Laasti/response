<?php

namespace Laasti\Response\Data;

interface DataInterface
{
    /**
     * Get value for property
     * @param string $property
     */
    public function get($property);

    /**
     * Set value for property
     * @param string $property
     * @param mixed $value
     */
    public function set($property, $value);

    /**
     * Unset property
     * @param string $property
     */
    public function remove($property);

    /**
     * Add data in batch
     * @param array $data
     */
    public function add($data);

    /**
     * Push value into property which is an array
     * @param string $property
     * @param mixed $value
     */
    public function push($property, $value);

    /**
     * Export to array all data
     */
    public function export();
}
