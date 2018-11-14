<?php

namespace Project\App;

/**
 * Here you can define wrappers for the ORM to use.
 */
class ORMWrappers extends \PHPixie\ORM\Wrappers\Implementation
{
    /**
     * Array of model names that have custom Entity wrappers
     * @var array
     

    protected $databaseEntities = array('user');
    protected $databaseRepositories = array('user');

    public function userEntity($entity)
    {
        return new ORMWrappers\User\Entity($entity);
    }

    public function userRepisitory($repository)
    {
        return new ORMWrappers\User\Repository($repository);
    }
	*/
}