<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Models\LogsModel;

class AuthBaseController extends BaseController
{
	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
        $this->session = session();
	}

    public function beforeRoute()
    {
        if (!$this->session->get('login')) {
            redirect()->to(base_url().'/auth/login')->send(); 
            exit();
		} else if ($this->session->get('login')['active'] == 0) {
            redirect()->to(base_url().'/auth/login')->send(); 
            exit();
        } else if (new \DateTime() > new \DateTime($this->session->get('expire_time'))) {
            redirect()->to(base_url().'/payment/pricing-table')->send(); 
            exit();
        }
        $usersModel = new UsersModel();
        $user = $usersModel->find($this->session->get('login')['id']);
        if ($this->session->get('expire_time') != $user['expire_date']) {
            $this->session->set('expire_time', $user['expire_date']);
        }
    }

    public function beforeApi()
    {
        if (!$this->session->get('login')) {
            echo '{"result":"FAIL"}';
            exit();
		} else if ($this->session->get('login')['active'] == 0) {
            echo '{"result":"FAIL"}';
            exit();
        }
    }

    public function beforePaidApi() 
    {
        $this->beforeApi();
    }

    public function view($view, $extradata = [])
    {
        $data = [];
        $data["email"] = $this->session->get('login')['email'];
        $data["fullname"] = $this->session->get('login')['fullname'];
        $data["role"] = $this->session->get('login')['role'];
        $data["created_at"] = $this->session->get('login')['created_at'];
        $data["updated_at"] = $this->session->get('login')['updated_at'];
        $data["plan"] = $this->session->get('login')['plan'];
        $data["expire_date"] = $this->session->get('login')['expire_date'];

        return view($view, array_merge($data, $extradata));
    }

    public function addlog($action = "", $performer = "-1", $description = "")
    {
        $logsModel = new LogsModel();
        $logsModel->insert([
            'action'=> $action,
            'performer'=> $performer,
            'description'=> $description,
        ]);
    }
}