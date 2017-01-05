<?php

namespace Project\App\HTTPProcessors\Admin;

use PHPixie\HTTP\Request;
use PHPixie\HTTP\Responses\Response;
use Project\App\HTTPProcessors\Processor;
use Project\App\ORM\Admin\Admin;
use PHPixie\AuthLogin\Providers\Password as PasswordProvider;
use PHPixie\Template;
use Project\App\ORM\Admin\AdminRepository;

/**
 * Admin authorization processor
 */
class Auth extends Processor
{
    /**
     * Login page
     * @param Request $request
     * @return mixed
     */
    public function defaultAction(Request $request)
    {
        /** @var Admin $admin */
        $admin = $this->loggedAdmin();

        if($admin !== null) {
            return $this->loggedInRedirect();
        }

        if($request->method() === 'GET') {
            return $this->getTemplate();
        }

        return $this->handleLogin($request);
    }

    /**
     * Logout action
     * @param Request $request
     * @return mixed
     */
    public function logoutAction(Request $request)
    {
        $this->builder->auth()->adminDomain()->forgetUser();
        return $this->adminLoginRedirect();
    }

    /**
     * Handles login form processing
     * @param Request $request
     * @return mixed
     */
    protected function handleLogin(Request $request)
    {
        $domain = $this->builder->auth()->adminDomain();

        /** @var PasswordProvider $passwordProvider */
        $passwordProvider = $domain->provider('password');

        $data = $request->data();
        $user = $passwordProvider->login(
            $data->getRequired('username'),
            $data->getRequired('password')
        );

        if($user === null) {
            return $this->getTemplate(array(
                'loginFailed' => true
            ));
        }

        return $this->loggedInRedirect();
    }

    /**
     * Get template for the auth page
     * @param array $data
     * @return Template\Container
     */
    protected function getTemplate($data = array())
    {
        return $this->components->template()->get(
            'app:admin/auth',
            $data
        );
    }

    /**
     * @return AdminRepository
     */
    protected function adminRepository()
    {
        return $this->components->orm()->repository('admin');
    }

    /**
     * Redirect response used after login
     * @return Response
     */
    protected function loggedInRedirect()
    {
        return $this->redirectResponse(
            'app.admin.processor',
            array('adminProcessor' => 'dashboard')
        );
    }
}