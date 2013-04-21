<?php
namespace Rocker\Object;


/**
 * This class serves as a container from where you
 * can fetch and store data of any kind
 *
 * @package PHP-Rocker
 * @author Victor Jonsson (http://victorjonsson.se)
 * @license MIT license (http://opensource.org/licenses/MIT)
 */
class MetaData extends \stdClass {

    /**
     * @var array
     */
    private $meta;

    /**
     * @var array
     */
    private $deleted = array();

    /**
     * @var array
     */
    private $updated = array();

    /**
     * @param array $meta_data
     */
    function __construct(array $meta_data)
    {
        $this->meta = $meta_data;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function get($name, $default=null)
    {
        return isset($this->meta[$name]) ? $this->meta[$name] : $default;
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name)
    {
        return isset($this->meta[$name]);
    }

    /**
     * @param string $name
     * @param mixed $val
     */
    function set($name, $val)
    {
        if( $this->get($name) !== $val ) {
            if( $val === null ) {
                unset($this->meta[$name]);
                $this->deleted[] = $name;
            }
            else {
                $this->meta[$name] = is_numeric($val) ? (int)$val:$val;
                $this->updated[$name] = $this->meta[$name];
            }
        }
    }

    /**
     * @param string $name
     */
    function delete($name)
    {
        $this->set($name, null);
    }

    /**
     * @return array
     */
    function getUpdatedValues()
    {
        return $this->updated;
    }

    /**
     * @param array $values
     */
    function setUpdatedValues(array $values)
    {
        $this->updated = $values;
    }

    /**
     * @return array
     */
    function getDeletedValues()
    {
        return $this->deleted;
    }

    /**
     * @param array $values
     */
    function setDeletedValues(array $values)
    {
        $this->deleted = $values;
    }

    /**
     * Get an array copy of the meta values
     * @return array
     */
    function toArray()
    {
        return $this->meta;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param string $key
     * @param mixed $val
     */
    public function __set($key, $val)
    {
        $this->set($key, $val);
    }

    /**
     * @throws \Exception
     */
    function __sleep()
    {
        throw new \Exception('Can not be serialized');
    }
}