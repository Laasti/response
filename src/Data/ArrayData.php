<?php

namespace Laasti\Response\Data;

/**
 * ArrayData Class
 *
 */
class ArrayData implements DataInterface
{

    protected $data;

    public function __construct($initialData = [])
    {
        $this->data = $initialData;
    }

    /**
     * {@inheritdoc}
     */
    public function get($property, $default = null)
    {
        $keyPath = explode('.', $property);
        $data = $this->data;
        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey = $keyPath[$i];
            if (is_array($data) && isset($data[$currentKey])) {
                $data = $data[$currentKey];
            } else {
                return $default;
            }
        }
        
        return is_null($data) ? $default : $data;
    }

    /**
     * {@inheritdoc}
     */
    public function set($property, $value)
    {
        $keyPath = explode('.', $property);
        $data =& $this->data;

        $end = array_pop($keyPath);
        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey = $keyPath[$i];
            if (is_array($data) || $data instanceof \ArrayAccess) {
                if (!isset($data[$currentKey])) {
                    $data[$currentKey] = array();
                }
                $data =& $data[$currentKey];
            } else {
                throw new \RuntimeException("Invalid property key (not an array): ".$property);
            }
        }
        $data[$end] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($property)
    {

        $data =& $this->data;
        $keyPath = explode('.', $property);

        if (1 === count($keyPath)) {
            unset($data[$property]);
            return $this;
        }

        $end = array_pop($keyPath);
        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey =& $keyPath[$i];
            if (!isset($data[$currentKey])) {
                return $this;
            }
            $currentValue =& $currentValue[$currentKey];
        }
        unset($currentValue[$end]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function add($data)
    {
        foreach ($data as $property => $value) {
            $this->set($property, $value);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function push($property, $value)
    {
        if (isset($this->data[$property]) && (is_array($this->data[$property]) || $this->data[$property] instanceof \ArrayAccess)) {
            $this->data[$property][] = $value;
            return $this;
        }

        throw new \RuntimeException('Trying to push data into an undefined or a non-array property: "'.$property.'".');
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        return $this->data;
    }
}
