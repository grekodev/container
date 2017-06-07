<?php
/**
 * Created by PhpStorm.
 * User: brapastor
 * Date: 6/7/17
 * Time: 4:36 PM
 */

namespace brapastor\Container;



abstract class Facade
{
    protected static $container;


    public static function setContainer(Container $container)
    {
        static::$container = $container;
    }

    public static function getContainer()
    {
        return static::$container;
    }

    public static function getAccessor()
    {
        throw new ContainerException('Please define the getAccessor in your facade');
    }

    public static function getInstance()
    {
        return static::getContainer()->make(static::getAccessor());
    }

    public static function __callStatic($method, $args)
    {
        $object = static::getInstance();
        switch (count($args)) {
            case 0:
                return $object->$method();
            case 1:
                return $object->$method($args[0]);
            case 2:
                return $object->$method($args[0], $args[1]);
            case 3:
                return $object->$method($args[0], $args[1], $args[2]);

            default:
                return call_user_func_array([$object, $method], $args);

        }
    }
}