<?php namespace Jiro\Support\Database;

/**
 * Namespaced Entity Trait
 *
 * Gives returning namespace abilities, used for cartalyst attribute extension.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

trait NamespacedEntityTrait
{
    /**
     * Returns the entity namespace.
     *
     * @return string
     */
    public static function getEntityNamespace()
    {
        return isset(static::$entityNamespace) ? static::$entityNamespace : get_called_class();
    }

    /**
     * Sets the entity namespace.
     *
     * @param  string  $namespace
     * @return void
     */
    public static function setEntityNamespace($namespace)
    {
        static::$entityNamespace = $namespace;
    }
}
