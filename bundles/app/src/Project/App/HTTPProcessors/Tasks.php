<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use PHPixie\Template;

class Tasks extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
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
        $container = $template->get('app:tasks/index');
        $container->price = $price->asArray(true);

        $id = $request->attributes()->get('id');
        if (!empty($id)){
            $container->edit = $orm->query('task')->where('id', $id)->findOne();
        }
        $container->fyear = date('Y');
        $container->fmonth = date('m');
        if (isset($_SESSION['role']) && $_SESSION['role']==2) {
            $container->admin = true;
        }
        return $container;
    }

    public function listAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $tasks = $orm->query('task');
        $month = $request->data()->get('month');
        if ($month){
            $tasks->where('date', '>=', $month . '-01')
                ->where('date', '<=', $month . '-31');
        }
        $template = $this->builder->components()->template();
        $container = $template->get('app:tasks/list');
        $container->tasks = $tasks->orderAscendingBy('state')->orderDescendingBy('id')->find()->asArray(true);
        if (isset($_SESSION['role']) && $_SESSION['role']==2) {
            $container->admin = true;
        }
        return $container;
    }

    public function excelAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $tasks = $orm->query('task');
        $month = $request->data()->get('month');
        if (!$month){
            if (isset($_COOKIE['periodform'])) {
                $month = json_decode($_COOKIE['periodform']);
                $month = $month->year . '-' . $month->month;
            } else {
                $month = date('Y') . '-' . date('m');
            }
        }
        $tasks->where('date', '>=', $month . '-01')
            ->where('date', '<=', $month . '-31');

        $template = $this->builder->components()->template();
        $view = $request->attributes()->get('view');
        if (!empty($view) && ($view=='price')){
            $container = $template->get('app:tasks/excel_price');
            header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
            header ( "Cache-Control: no-cache, must-revalidate" );
            header ( "Pragma: no-cache" );
            header ( "Content-type: application/vnd.ms-excel" );
            header ( "Content-Disposition: attachment; filename=" . $month . "_price.xls" );
            //header('Content-Type: text/html; charset=utf-8');
            $price = $orm->query('price')->find();
            $container->price = $price->asArray(true);
        } else if (!empty($view) && ($view=='v1')){
            $container = $template->get('app:tasks/excel');
        }
        else {
            $container = $template->get('app:tasks/excel');
            header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
            header ( "Cache-Control: no-cache, must-revalidate" );
            header ( "Pragma: no-cache" );
            header ( "Content-type: application/vnd.ms-excel" );
            header ( "Content-Disposition: attachment; filename=" . $month . ".xls" );
        }
        $container->tasks = $tasks->orderDescendingBy('id')->find()->asArray(true);
        $container->month = $month;
        return $container;
    }

    public function viewAction(Request $request)
    {
        $id = $request->attributes()->get('id');
        $template = $this->builder->components()->template();
        $container = $template->get('app:tasks/view');
        if (isset($_SESSION['role']) && $_SESSION['role']==2) {
            $container->admin = true;
        }
        if (!empty($id)){
            $orm = $this->builder->components()->orm();
            $container->task = $orm->query('task')->where('id', $id)->findOne();
        }
        $view = $request->query()->get('view');
        if ($view == 'ajax') {
            $container->ajax = true;
        }
        if ($container->task) {
            return $container;
        } else {
            $http = $this->builder->components()->http();
            return $http->responses()->redirect('/');
        }

    }

    public function saveAction(Request $request)
    {
        if (isset($_SESSION['role']) && $_SESSION['role']==2) {

        $ret = '';
        $database = $this->builder->components()->database();
        $connection = $database->get('default');

        $id = $request->data()->get('id');
        $name = $request->data()->get('name');
        $description = $request->data()->get('description');
        $state = $request->data()->get('state');
        $date = $request->data()->get('date');
        $end = $request->data()->get('end');
        $brand = $request->data()->get('brand');
        $items = $request->data()->get('items');

        $task = array();
        if (!empty($name))          $task['name'] = $name;
        if (!empty($description))   $task['description'] = $description;
        if (!empty($state))         $task['state'] = $state;
        if (!empty($date))          $task['date'] = $date;
        if (!empty($end))           $task['end'] = $end;
        if (!empty($brand))         $task['brand'] = $brand;
        if (!empty($items))         $task['items'] = serialize($items);

        if (empty($id)) {
            $query = $connection->insertQuery();
            $query->table('tasks')
                ->data($task)
                ->execute();
            $ret = $connection->insertId();
        } else {
            $query = $connection->updateQuery();
            $query->table('tasks')
                ->where('id', $id);
            foreach ($task as $k => $tas){
                $query->set($k, $tas);
            }
            $query->execute();
            $ret = $id;
        }
        return $ret;

        }
    }

}