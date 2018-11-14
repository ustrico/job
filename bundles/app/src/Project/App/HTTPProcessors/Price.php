<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use PHPixie\Template;

class Price extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function defaultAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $price = $orm->query('price')->find();

        $template = $this->builder->components()->template();
        $container = $template->get('app:price/index');
        $container->price = $price->asArray(true);

        return $container;
    }

    public function addCSVAction(Request $request)
    {
        if (isset($_SESSION['role']) && $_SESSION['role']==2) {

        $database = $this->builder->components()->database();
        $connection = $database->get('default');

        $parentId = 0;
        $parentId1 = 0;

        $handle = fopen('price.csv', 'r');
        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            $insert = array();
            if (!empty($data[0])){
                $parentId = 0;
                $insert['name'] = $data[0];
                $insert['parentId'] = $parentId;
            } else if (!empty($data[1])){
                $insert['name'] = $data[1];
                $insert['parentId'] = $parentId;
            } else if (!empty($data[2])){
                $insert['name'] = $data[2];
                $insert['parentId'] = $parentId1;
            }
            if (!empty($data[3])){
                $insert['price'] = $data[3];
            }
            if (!empty($data[4])){
                $insert['description'] = $data[4];
            }
            $insertQuery = $connection->insertQuery();
            $insertQuery->table('prices');
            $insertQuery->data($insert)->execute();
            if (!empty($data[0])){
                $parentId = $connection->insertId();
            } else if (!empty($data[1])){
                $parentId1 = $connection->insertId();
            }
        }
        fclose($handle);

        }
        $template = $this->builder->components()->template();
        $container = $template->get('app:price/addcsv');

        $container->message = 'ok';

        return $container;
    }
}