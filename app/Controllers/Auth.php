<?php namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
	public function login()
	{
		$data = [];

		if ($this->request->getMethod() === 'post')
		{
			$email = $this->request->getPost('email');
			$usersModel = new UsersModel();
			$user = $usersModel->where([
				'email' => $email, 
			])->first();

			$verified = false;
			if ($user) {
				$verified = password_verify($this->request->getPost('password'), $user['password']);	
			}
			
			if ($verified)
			{
				if ($user["active"] == 0) {
					$htmlMessage = view('auth\emails\header');
					$htmlMessage .= view('auth\emails\activation', ['hash' => $user["register_token"]]);
					$htmlMessage .= view('auth\emails\footer');
					$mailData = [
						'from'=> 'istarDev0103@gmail.com',
						'to'=> $email,
						'subject'=> 'Registration',
						'content'=> $htmlMessage,
					];
					$this->sendMail($mailData);
					return redirect()->back()->withInput()->with('message', "メールをチェックして、アカウントを有効にしてください。");
				}
				// Set default free period(15 days)
				if (is_null($user["expire_date"])) {
					$updatedata = [
						'plan' => 'Free',
						'expire_date' => date(
							'Y-m-d H:i:s', 
							strtotime('+15 days')
						)
					];
					$updated = $usersModel->update($user['id'], $updatedata);
					if ($updated) {
						$user = $usersModel->find($user["id"]);
					} 
				}

				$session = session();
				$session->set('login', $user);
				$session->set('expire_time', $user['expire_date']);
				$session->set('config', json_decode($user['config'], true) ?: []);
				if ($user['role'] == 1023) {
					return redirect()->to(base_url().'/admin');
				} else {
					return redirect()->to('/home');
				}
			} else {
				return redirect()->back()->withInput()->with('message', "メールアドレスもしくはパスワードが正しくありません");
			}
		} else {
			return view('auth/login', $data);
		}
    }
    
	public function logout()
	{
		$session = session();
		$session->set('login', false);

		return redirect()->to('/auth/login');
	}
	
	public function regist()
	{
		$data = [];

		$fullname = $this->request->getPost('fullname');
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		if ($this->request->getMethod() === 'post')
		{
			$usersModel = new UsersModel();
			$existing_user = $usersModel->where(['email' => $email])->first();

			// $data['message'] = 'Already registered please check your mailbox';

			if ($existing_user)
			{
				$active = $existing_user['register_token'];
				$token = $existing_user['register_token'];
				if ($active == 0) {
					return redirect()->back()->withInput()->with('message', "これは既存のアカウントです。 ログインしてください。");
				}
			}
			else
			{
				$token = $this->createRandomString(36);
				$usersModel->insert([
					'fullname' => $fullname,
					'email' => $email,
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'affiliate_id' => $this->createRandomString(12),
					'affiliate_from' => $this->request->getGet('ref'),
					'register_token' => $token,
				]);
			}
			$htmlMessage = view('auth\emails\header');
			$htmlMessage .= view('auth\emails\activation', ['hash' => $token]);
			$htmlMessage .= view('auth\emails\footer');
			$mailData = [
				'from'=> 'info@nene-maru.com',
				'to'=> $email,
				'subject'=> 'Registration',
				'content'=> $htmlMessage,
			];
			$this->sendMail($mailData);

			return view('auth/regist', [
				"message"=> "受信トレイを確認してください。"
			]);
			
		} else {
			return view('auth/regist');
		}
	}
	
	public function activeAccount()
	{
		$usersModel = new UsersModel();

		// check token
		$user = $usersModel->where('register_token', $this->request->getGet('token'))
			->where('active', 0)
			->first();

		if (is_null($user)) {
			return redirect()->to('/auth/login')->with('message', "登録されていないアカウント。");
		}

		// update user account to active
		$id = $user['id'];
		$data = [
			'active'=> 1,
			'register_token'=> '',
			'expire_date' => date(
				'Y-m-d H:i:s', 
				strtotime('+15 days')
			)
		];
		$usersModel->update($id, $data);

		return redirect()->to('/auth/login')->with('message', "アカウントが正常にアクティブ化されました。");
	}

	public function forgetPassword()
	{
		if ($this->request->getMethod() === 'post') {
			$email = $this->request->getPost('email');
			$usersModel = new UsersModel();
			$old_user = $usersModel->where('email', $email)->first();

			if ($old_user) {
				$id = $old_user['id'];
				$token = $this->createRandomString(36);
				$data = [
					"confirmpassword_token"=> $token,
				];

				$usersModel->update($id, $data);
				$htmlMessage = view('auth\emails\header');
				$htmlMessage .= view('auth\emails\reset', ['hash' => $token]);
				$htmlMessage .= view('auth\emails\footer');
				$mailData = [
					'from'=> 'istarDev0103@gmail.com',
					'to'=> $email,
					'subject'=> 'Registration',
					'content'=> $htmlMessage,
				];

				$this->sendMail($mailData);
				return redirect()->back()->with('message', "veriyコードを" . $email . "に正常に送信しました");
			}

			return redirect()->back()->with('message', "未登録のアカウント");
		} else {
			return view('auth/forgot');
		}
	}

	public function resetPassword()
	{
		$usersModel = new UsersModel();

		$token = $this->request->getGet('token');		

		// check token
		$user = $usersModel->where('confirmpassword_token', $token)->first();
		

		if ($user && $token != "") {
			if ($this->request->getMethod() == 'post') {
				$password = $this->request->getPost('password');
				$id = $user['id'];
				$data = [
					'password'=> password_hash($password, PASSWORD_DEFAULT),
					'confirmpassword_token'=> "",
				];
				$usersModel->update($id, $data);

				return redirect()->to(base_url()."/auth/login")->with("message", "パスワードが正常に更新されました。");
			} else {
				// return redirect()->to(base_url()."/auth/reset-password?token=".$token);
				return view("auth/reset", ["token"=> $token]);
			}
		} else {
			return redirect()->to(base_url()."/auth/login")->with("message", "パスワードのリセットに失敗しました。");
		}
	}
	
	private function createRandomString($length)
	{
		$chars = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));

		$result = '';
		for ($i = 0; $i < $length; $i++) $result .= $chars[rand(0, count($chars) - 1)];
		return $result;
	} 

}
