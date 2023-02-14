<?php namespace App\Controllers;

use App\Models\UsersModel;

class Admin extends AuthBaseController
{
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
    }

	public function beforeRoute() {
		parent::beforeRoute();
		if ($this->session->get('login')['role'] != 1023) {
            redirect()->to(base_url().'/auth/login')->send(); 
            exit();
		}
	}

	public function beforeApi() {
		parent::beforeApi();
		if ($this->session->get('login')['role'] != 1023) {
            echo '{"result":"FAIL"}';
            exit();
		}
	}

	public function home()
	{
		$this->beforeRoute();

        $data = [];

		$usersModel = new UsersModel();
		$data['users'] = $usersModel
						// ->withDeleted()
						->findAll();

		return $this->view('admin/home', $data);
	}

	public function deleteUser()
	{
		$this->beforeApi();

        $usersModel = new UsersModel();
        $deleted = $usersModel->delete(intval($this->request->getPost('id')));

		if ($deleted) {
			return json_encode([
				"code"=> "200",
				"result"=> "success"
			]);
		} else {
			return json_encode([
				"code"=> "500",
				"result"=> "fail",
				"msg"=> "fail to delete",
			]);
		}
    }

	public function updateUser()
	{
		$this->beforeApi();

        $usersModel = new UsersModel();
		$id = $this->request->getPost('id');
		$role = $this->request->getPost('role');
		$expire_date = $this->request->getPost('expire_date');

		$data = [
			'role'=> $role,
			"expire_date"=> $expire_date,
		];

        $usersModel = new UsersModel();
        $updated = $usersModel->update($id, $data);

		if ($updated) {
			return json_encode([
				"code"=> "200",
				"result"=> "success"
			]);
		} else {
			return json_encode([
				"code"=> "500",
				"result"=> "fail",
				"msg"=> "fail to update"
			]);
		}

    }
}

