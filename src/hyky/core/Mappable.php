<?php
namespace HYKY\Core;

/**
 * Services : HYKY\Core\Mappable
 * ----------------------------------------------------------------------
 * Implements `\JsonSerializable`, which allows some lazy object-to-array
 * conversion and, to a certain extent, JSON serialization of the object.
 *
 * Properties must be `public` or `protected` to be serialized.
 *
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class Mappable implements \JsonSerializable
{
    /**
     * Returns all the object's public and protected properties in an array.
     *
     * Excludes properties defined by Doctrine, for cleanliness' sake.
     *
     * @return array
     */
    public function toArray(): array
    {
        $list = get_object_vars($this);
        // Removes Doctrine's generated properties
        foreach ($list as $k => $v) {
            if (preg_match("/^\_\_/", $k)) unset($list[$k]);
        }
        return $list;
    }
    
    /**
     * Specifies which of the object's parameters should be serialized to
     * JSON when using `json_encode` in an instance.
     *
     * The default behavior is to return whatever `toArray()` returns, but
     * can (and should) be overridden when necessary.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
