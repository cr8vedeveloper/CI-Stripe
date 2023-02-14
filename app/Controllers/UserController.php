<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\MethodsModel;
use App\Models\TradesModel;
use App\Models\AccountsModel;

class UserController extends AuthBaseController
{
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
    }

    public function index() {
        $this->beforeRoute();
		
		$data = [];

		$model = new MethodsModel();
		$data['methods'] = $model->select('id, name, order')->where('user', $this->session->get('login')['id'])->findAll();
		$data['formDefault'] = $this->session->get('config');
		$data['affiliateUrl'] = base_url('/regist') . '?ref=' . $this->session->get('login')['affiliate_id'];

		return $this->view('user/index', $data);
    }

    public function updateAccount() {
        $this->beforeApi();

        $id  = $this->session->get("login")['id'];
        $email = $this->request->getPost("email");
        $fullname = $this->request->getPost("fullname");
        $password = $this->request->getPost("password");

        $userModal = new UsersModel();
        $olduser = $userModal->find($id);
        if ($olduser["password"] == $password) {
            $data = [
                "email"=> $email,
                "fullname"=> $fullname,
                "password"=> $password,
            ];
            $updated = $userModal->update($id, $data);
            if ($updated) {
                $updateduser = $userModal->find($id);
                $this->session->set('login', $updateduser);
                return json_encode([
                    'code'=> "200",
                    'result'=> "success",
                ]);
            } else {
                return json_encode([
                    'code'=> "500",
                    'result'=> "fail",
                    'msg'=> "更新に失敗する",
                ]);
            }
        } else {
            return json_encode([
                'code'=> "401",
                'result'=> "fail",
                'msg'=> "パスワードが正しくありません",
            ]);
        }
    }

    public function updatePassword() {
        $this->beforeApi();

        $id  = $this->session->get("login")['id'];
        $old_password = $this->request->getPost("old_password");
        $new_password = $this->request->getPost("new_password");

        $userModal = new UsersModel();
        $olduser = $userModal->find($id);

        if ($olduser["password"] == $old_password) {
            $data = [
                'password'=> $new_password
            ];
            $updated = $userModal->update($id, $data);
            if ($updated) {
                return json_encode([
                    'code'=> "200",
                    'result'=> "success",
                ]);
            } else {
                return json_encode([
                    'code'=> "500",
                    'result'=> "fail",
                    'msg'=> "更新に失敗する",
                ]);
            }
        } else {
            return json_encode([
                'code'=> "401",
                'result'=> "fail",
                'msg'=> "パスワードが正しくありません",
            ]);
        }
    }

    public function uploadCSV()
	{
        $this->beforeApi();
        $tradesModel = new TradesModel();

        $currencies = [];
        $currenciesModel = new CurrenciesModel();
        foreach($currenciesModel->findAll() as $r)
        {
            $currencies[$r['name']] = $r['id'];
        }

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        $i = 0;
        foreach (preg_split('/\n/u', mb_convert_encoding(base64_decode($this->request->getPost('data')), 'UTF-8', 'SJIS-win')) as $l)
        {
            $r = $this->mb_str_getcsv($l);
            if ($i == 0)
            {
                if ($r[0] != '取引番号')
                {
                    echo '{"result":"error"}';
                    return;
                }
                else
                {
                    $i++;
                    continue;
                }
            }
            if ($l == '') continue;

            $bet = intval(preg_replace('/,|￥/', '', $r[6]));
            $profit = $r[7] == '---' ? 0 : intval(preg_replace('/,|￥/', '', $r[7]));

            $mode = 0;
            $trade_sec = strtotime($r[10]) - strtotime($r[9]);
            if (substr($r[9], -2, 2) == '00' && $trade_sec > 59 && $trade_sec < 900)
            {
                if      ($trade_sec >  59 && $trade_sec <= 300) $mode = 7;
                else if ($trade_sec > 300 && $trade_sec <= 600) $mode = 8;
                else if ($trade_sec > 600 && $trade_sec <= 900) $mode = 9;
            }
            else
            {
                if      ($trade_sec ==    30) $mode = 3;
                else if ($trade_sec ==    60) $mode = 4;
                else if ($trade_sec ==   180) $mode = 5;
                else if ($trade_sec ==   300) $mode = 6;
                else if ($trade_sec ==   900) $mode = 9;
                else if ($trade_sec ==  3600) $mode = 1;
                else if ($trade_sec == 86400) $mode = 2;
            }

            $tradesModel->insert([
                'user' => $this->session->get('login')['id'],
                'entered_at' => $r[9],
                'result' => $profit > $bet ? 1 : 2,
                'win' => $profit > $bet ? 1 : 0,
                'lose' => $profit > $bet ? 0 : 1,
                'currency' => $currencies[$r[1]] ?? 0,
                'method' => 0,
                'mode' => $mode,
                'direction' => ['HIGH' => 1, 'LOW' => 2][$r[3]] ?? 0,
                'pips' => abs(intval(preg_replace('/\./', '', $r[4])) - intval(preg_replace('/\./', '', $r[8]))),
                'bet' => $bet,
                'profit' => $profit - $bet,
                'evaluation' => 0,
            ]);
        }

        return json_encode([
            "result"=> "success"
        ]);
    }

    
	public function insertMethod()
	{
        $this->beforeApi();

        $methodsModel = new MethodsModel();
        $methodsModel->insert([
            'user' => $this->session->get('login')['id'],
            'name' => $this->request->getPost('name'),
            'order' => $this->request->getPost('order'),
        ]);
        echo json_encode($methodsModel->select('id, name, order')->find($methodsModel->getInsertID()));
    }

	public function updateMethod()
	{
        $this->beforeApi();
        $methodsModel = new MethodsModel();
        $methodsModel->where('user', $this->session->get('login')['id'])->save($this->request->getPost());

        return json_encode([
            "result"=> "success"
        ]);
    }
    
	public function deleteMethod()
	{
        $this->beforeApi();
        $methodsModel = new MethodsModel();
        $methodsModel->where('user', $this->session->get('login')['id'])->delete(intval($this->request->getPost('id')));

        return json_encode([
            "result"=> "success"
        ]);
    }
    
	public function saveConfig()
	{
        $this->beforeApi();

        $usersModel = new UsersModel();
        $usersModel->save([
            'id' => $this->session->get('login')['id'],
            'config' => json_encode($this->request->getPost()),
        ]);

        $this->session->set('config', $this->request->getPost());
    }

	public function getTotalBalance()
	{
        $this->beforeApi();

        $tradesModel = new TradesModel();
        $accountsModel = new AccountsModel();

        $where = [];
        $where['user'] = $this->session->get('login')['id'];
        if (isset($this->session->get('config')['balance-from']) && $this->session->get('config')['balance-from'] != '') $where['entered_at >='] = date('Y-m-d', strtotime($this->session->get('config')['balance-from']));

        $account = $accountsModel->select('sum(amount) + sum(bonus) as account')->where($where)->first()['account'];
        $balance = intval($this->session->get('config')['balance'] ?? 0);

        $r = $tradesModel->select('sum(win) as win, sum(lose) as lose, sum(profit) as profit')->where($where)->first();
        echo json_encode([
            'balance' => intval($balance + $r['profit'] + $account),
            'profit' => intval($r['profit']),
            'average' => $r['win'] + $r['lose'] == 0 ? '--' : round($r['win'] / ($r['win'] + $r['lose']) * 100, 2),
        ]);
	}
}