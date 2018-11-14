<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use PHPixie\Template;

class Login extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function defaultAction(Request $request)
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            unset($_SESSION['email']);
            unset($_SESSION['role']);
        }
        $template = $this->builder->components()->template();
        $container = $template->get('app:login/index');
        
        $Email = $request->data()->get('Email');
        $Password = $request->data()->get('Password');

        $container->Email = $Email;
        $container->Password = $Password;

        if ( $Email && $Password ){
            $orm = $this->builder->components()->orm();
            $user = $orm->query('user')->where('Email', $Email)->where('Password', md5($Password))->findOne();
            if ($user) {
                $_SESSION['user'] = $user->name;
                $_SESSION['email'] = $user->email;
                $_SESSION['role'] = $user->role;
                header('Location: .');
                exit;
            }
        }

        return $container;
    }

}