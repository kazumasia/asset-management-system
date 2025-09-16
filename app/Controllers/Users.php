<?php

namespace App\Controllers;

use \Myth\Auth\Entities\User;
use \Myth\Auth\Password;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;
use CodeIgniter\Controller;

class Users extends Controller
{
    protected $auth;
    protected $config;

    public function __construct()
    {
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        $groupModel = new GroupModel();
        foreach ($users as $user) {
            $groups = $groupModel->getGroupsForUser($user->id);
            $user->group_name = !empty($groups) ? $groups[0]['name'] : 'N/A';
        }

        $data['users'] = $users;
        $data['title'] = 'Users';

        return view('admin/user_list', $data);
    }


    public function activate()
    {
        $userModel = new UserModel();

        $id = $this->request->getVar('id');
        $active = $this->request->getVar('active');

        $userModel->activateUser($id, $active == '1');

        return redirect()->to(base_url('users/index'));
    }



    public function changePassword($id = null)
    {
        if ($id == null) {
            return redirect()->to(base_url('/admin/users'));
        } else {
            $data = [
                'id' => $id,
                'title' => 'Update Password',
            ];
            return view('admin/set_password', $data);
        }
    }

    public function setPassword()
    {
        $id = $this->request->getVar('id');
        $rules = [
            'password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $data = [
                'id' => $id,
                'title' => 'Update Password',
                'validation' => $this->validator,
            ];
            return view('users/set_password', $data);
        } else {
            $userModel = new UserModel();
            $data = [
                'password_hash' => Password::hash($this->request->getVar('password')),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $userModel->update($this->request->getVar('id'), $data);

            return redirect()->to(base_url('/admin/users'));
        }
    }
    public function add()
    {
        $data = [
            'title' => 'Add Users',
            'config' => $this->config,
        ];

        return view('admin/add', $data);
    }

    public function save()
    {
        $users = model(UserModel::class);

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rules = [
            'password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            return redirect()->to(base_url('/admin/index'));
        }

        return redirect()->to(base_url('/admin/index'));
    }

    public function searchUsers()
    {
        $search_query = $this->request->getPost('search_query');
        $userModel = new UserModel();
        $groupModel = new GroupModel();

        if ($search_query) {
            $users = $userModel->select('users.*, auth_groups_users.group_id, auth_groups.name AS group_name')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
                ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
                ->groupStart()
                ->like('users.username', $search_query)
                ->orLike('users.email', $search_query)
                ->orLike('auth_groups.name', $search_query)
                ->groupEnd()
                ->findAll();

            $data['users'] = $users;
            $data['search_query'] = $search_query;
        } else {
            $data['users'] = $userModel->select('users.*, auth_groups_users.group_id, auth_groups.name AS group_name')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
                ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
                ->findAll();
            $data['search_query'] = '';
        }

        $data['title'] = 'Users';
        return view('admin/user_list', $data);
    }



}
