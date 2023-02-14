<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\TradesModel;
use App\Models\NotesModel;
use App\Models\AccountsModel;
use App\Models\CurrenciesModel;
use App\Models\MethodsModel;

class Api extends AuthBaseController
{
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

    }

	public function insertTrade()
	{
        $this->beforePaidApi();
        if (strtotime($this->request->getPost('entered_at')) == 0)
        {
            echo '{"result":"error"}';
            return;
        }

        $tradesModel = new TradesModel();
        $tradesModel->insert([
            'user' => $this->session->get('login')['id'],
            'entered_at' => preg_replace('/T/', ' ', preg_replace('/-/', '/', $this->request->getPost('entered_at'))),
            'result' => intval($this->request->getPost('result')),
            'win' => $this->request->getPost('result') == 1 ? 1 : 0,
            'lose' => $this->request->getPost('result') == 2 ? 1 : 0,
            'currency' => intval($this->request->getPost('currency')),
            'method' => intval($this->request->getPost('method')),
            'mode' => intval($this->request->getPost('mode')),
            'direction' => intval($this->request->getPost('direction')),
            'pips' => $this->request->getPost('pips'),
            'bet' => $this->request->getPost('bet'),
            'profit' => $this->request->getPost('profit'),
            'evaluation' => intval($this->request->getPost('evaluation')),
        ]);
        echo json_encode($tradesModel->select('id, entered_at, WEEKDAY(entered_at) as weekday, result, currency, method, mode, direction, pips, bet, profit, evaluation')->find($tradesModel->getInsertID()));
    }

	public function updateTrade()
	{
        $this->beforePaidApi();
        if (strtotime($this->request->getPost('entered_at')) == 0)
        {
            echo '{"result":"error"}';
            return;
        }

        $tradesModel = new TradesModel();
        $tradesModel->where('user', $this->session->get('login')['id'])->save([
            'id' => intval($this->request->getPost('id')),
            'entered_at' => preg_replace('/T/', ' ', preg_replace('/-/', '/', $this->request->getPost('entered_at'))),
            'result' => intval($this->request->getPost('result')),
            'win' => $this->request->getPost('result') == 1 ? 1 : 0,
            'lose' => $this->request->getPost('result') == 2 ? 1 : 0,
            'currency' => intval($this->request->getPost('currency')),
            'method' => intval($this->request->getPost('method')),
            'mode' => intval($this->request->getPost('mode')),
            'direction' => intval($this->request->getPost('direction')),
            'pips' => $this->request->getPost('pips'),
            'bet' => $this->request->getPost('bet'),
            'profit' => $this->request->getPost('profit'),
            'evaluation' => intval($this->request->getPost('evaluation')),
        ]);

        echo '{"result":"success"}';
    }

	public function deleteTrade()
	{
        $this->beforePaidApi();
        $tradesModel = new TradesModel();
        $tradesModel->where('user', $this->session->get('login')['id'])->delete(intval($this->request->getPost('id')));

        echo '{"result":"success"}';
    }

	public function loadNote()
	{
        $this->beforePaidApi();
        $notesModel = new NotesModel();
        $note = $notesModel->where('user', $this->session->get('login')['id'])->find(intval($this->request->getPost('id')));
        if ($note)
        {
            echo json_encode([
                'note' => $note['note'],
                'image' => $note['image'] ?? '',
            ]);
        }
        else
        {
            echo json_encode([
                'note' => '',
                'image' => '',
            ]);
        }
    }

	public function saveNote()
	{
        $this->beforePaidApi();
        $tradesModel = new TradesModel();
        if ($tradesModel->where('user', $this->session->get('login')['id'])->find(intval($this->request->getPost('id'))))
        {
           $notesModel = new NotesModel();
            if ($notesModel->find(intval($this->request->getPost('id'))))
            {
                $data = [
                    'id' => intval($this->request->getPost('id')),
                    'user' => $this->session->get('login')['id'],
                    'note' => $this->request->getPost('note'),
                ];
                if ($this->request->getPost('image') != 'noUpdate')
                {
                    $data['image'] = $this->request->getPost('image');
                }

                $notesModel->save($data);
            }
            else
            {
                $data = [
                    'id' => intval($this->request->getPost('id')),
                    'user' => $this->session->get('login')['id'],
                    'note' => $this->request->getPost('note'),
                    'image' => $this->request->getPost('image') != 'noUpdate' ? $this->request->getPost('image') : '',
                ];

                $notesModel->insert($data);
            }
    
            echo '{"result":"success"}';
        }
        else
        {
            echo '{"result":"error"}';
        }
    }

	public function insertAccount()
	{
        $this->beforePaidApi();
        if (strtotime($this->request->getPost('entered_at')) == 0)
        {
            echo '{"result":"error"}';
            return;
        }

        $accountsModel = new AccountsModel();
        $accountsModel->insert([
            'user' => $this->session->get('login')['id'],
            'entered_at' => preg_replace('/T/', ' ', preg_replace('/-/', '/', $this->request->getPost('entered_at'))),
            'amount' => intval($this->request->getPost('amount')) * ($this->request->getPost('type') == 1 ? 1 : -1) * ($this->request->getPost('type') == 3 ? 0 : 1),
            'bonus' => intval($this->request->getPost('amount')) * ($this->request->getPost('type') == 3 ? 1 : 0),
        ]);

        $r = $accountsModel->select('id, entered_at, amount, bonus')->find($accountsModel->getInsertID());
        echo json_encode([
            'id' => $r['id'],
            'entered_at' => $r['entered_at'],
            'in' => $r['amount'] > 0 ? $r['amount'] : '',
            'out' => $r['amount'] < 0 ? $r['amount'] * -1 : '',
            'bonus' => $r['bonus'] > 0 ? $r['bonus'] : '',
        ]);
    }

	public function updateAccount()
	{
        $this->beforePaidApi();
        if (strtotime($this->request->getPost('entered_at')) == 0)
        {
            echo '{"result":"error"}';
            return;
        }

        $accountsModel = new AccountsModel();
        $accountsModel->where('user', $this->session->get('login')['id'])->save([
            'id' => intval($this->request->getPost('id')),
            'entered_at' => preg_replace('/T/', ' ', preg_replace('/-/', '/', $this->request->getPost('entered_at'))),
            'amount' => intval($this->request->getPost('in')) - intval($this->request->getPost('out')),
            'bonus' => intval($this->request->getPost('bonus')),
        ]);

        echo '{"result":"success"}';
    }
    
	public function deleteAccount()
	{
        $this->beforePaidApi();
        $accountsModel = new AccountsModel();
        $accountsModel->where('user', $this->session->get('login')['id'])->delete(intval($this->request->getPost('id')));

        echo '{"result":"success"}';
    }

	public function insertMethod()
	{
        $this->beforePaidApi();
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
        $this->beforePaidApi();
        $methodsModel = new MethodsModel();
        $methodsModel->where('user', $this->session->get('login')['id'])->save($this->request->getPost());

        echo '{"result":"success"}';
    }
    
	public function deleteMethod()
	{
        $this->beforePaidApi();
        $methodsModel = new MethodsModel();
        $methodsModel->where('user', $this->session->get('login')['id'])->delete(intval($this->request->getPost('id')));

        echo '{"result":"success"}';
    }
    
	public function saveConfig()
	{
        $this->beforePaidApi();
        $usersModel = new UsersModel();
        $usersModel->save([
            'id' => $this->session->get('login')['id'],
            'config' => json_encode($this->request->getPost()),
        ]);

        $this->session->set('config', $this->request->getPost());
    }

	public function getTotalBalance()
	{
        $this->beforePaidApi();
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
    
	public function getWinningAverage()
	{
        $this->beforePaidApi();
        $tradesModel = new TradesModel();
        
        $where = [];
        $where['user'] = $this->session->get('login')['id'];
        if (isset($this->session->get('config')['balance-from']) && $this->session->get('config')['average-from'] != '') $where['entered_at >='] = date('Y-m-d', strtotime($this->session->get('config')['average-from']));
        if (isset($this->session->get('config')['balance-to']) && $this->session->get('config')['average-to'] != '') $where['entered_at <'] = date('Y-m-d', strtotime($this->session->get('config')['average-to']) + 86400);
        $where['TIME_FORMAT(entered_at, "%k")'] = $this->request->getPost('hour');
        if ($this->request->getPost('currency') != '') $where['currency'] = $this->request->getPost('currency');
        if ($this->request->getPost('method') != '') $where['method'] = $this->request->getPost('method');

        $r = $tradesModel->select('sum(win) as win, sum(lose) as lose')->where($where)->first();
        echo json_encode([
            'average' => $r['win'] + $r['lose'] == 0 ? '--' : round($r['win'] / ($r['win'] + $r['lose']) * 100, 2),
        ]);
    }
    
	public function getTodayResult()
	{
        $this->beforePaidApi();
        $tradesModel = new TradesModel();

        $where = [];
        $where['user'] = $this->session->get('login')['id'];
        $where['entered_at >='] = date('Y-m-d');
        $where['entered_at <'] = date('Y-m-d', time() + 86400);
        $where['TIME_FORMAT(entered_at, "%k")'] = $this->request->getPost('hour');

        $r = $tradesModel->select('count(id) as count, sum(win) as win, sum(lose) as lose, sum(profit) as profit')->where($where)->first();
        echo json_encode([
            'count' => intval($r['count']),
            'profit' => intval($r['profit']),
            'average' => $r['win'] + $r['lose'] == 0 ? '--' : round($r['win'] / ($r['win'] + $r['lose']) * 100, 2),
        ]);
    }

	public function getChartData()
	{
        $this->beforePaidApi();
        $targetMonth = strtotime($this->request->getPost('month').'-01');

        $tradesModel = new TradesModel();


		$builder = $tradesModel->select('result, pips, profit')->where('user', $this->session->get('login')['id']);
        $builder = $builder->where('entered_at >=', date('Y-m-d 00:00:00', $targetMonth));
        $builder = $builder->where('entered_at <=', date('Y-m-t 23:59:59', $targetMonth));
		$total = $profitTotal = $profitPlus = $profitMinus = $winTotal = $loseTotal = $winPips = $losePips = 0;
        foreach ($builder->findAll() as $r)
        {
			if ($r['result'] == 1)
			{
				$winTotal++;
				$winPips += $r['pips'];
			}
			elseif ($r['result'] == 2)
			{
				$loseTotal++;
				$losePips += $r['pips'];
			}

			$total++;
			$profitTotal += $r['profit'];

			if ($r['profit'] > 0) {
				$profitPlus += $r['profit'];
			}
			else {
				$profitMinus += $r['profit'];
			}
		}

        $data = [];
        $data['total'] = number_format($total);
		$data['profitTotal'] = number_format($profitTotal);
		$data['winTotal'] = number_format($winTotal);
		$data['loseTotal'] = number_format($loseTotal);
		$data['average'] = $winTotal + $loseTotal == 0 ? '--' : round($winTotal / ($winTotal + $loseTotal) * 100, 2).'%';
		$data['pf'] = $profitMinus == 0 ? '--' : round($profitPlus / abs($profitMinus), 3);
		$data['averageWinPips'] = $winTotal == 0 ? '--' : round($winPips / $winTotal, 2);
		$data['averageLosePips'] = $loseTotal == 0 ? '--' : round($losePips / $loseTotal, 2);


        $builder = $tradesModel->select('DATE_FORMAT(entered_at, "%Y-%m-%d") as date, sum(win) as win, sum(lose) as lose, sum(profit) as profit')->where('user', $this->session->get('login')['id'])->orderBy('entered_at', 'asc')->groupBy('DATE_FORMAT(entered_at, "%Y%m%d")');
        $builder = $builder->where('entered_at >=', date('Y-m-d 00:00:00', $targetMonth));
        $builder = $builder->where('entered_at <=', date('Y-m-t 23:59:59', $targetMonth));

        $profits = []; $total = 0;
		foreach ($builder->findAll() as $r)
		{
			$total += $r['profit'];
            $date = strtotime($r['date']);
			$profits[] = '["Date('.date('Y', $date).','.(date('n', $date) - 1).','.date('j', $date).')",'.$total.','.
            json_encode(date('Y年n月j日', $date)."\n".'収支：'.number_format($r['profit'])."\n".'勝率：'.($r['win'] + $r['lose'] == 0 ? '--' : round($r['win'] / ($r['win'] + $r['lose']) * 100, 2).'%'))
            .',null]';
		}

        if (count($profits) == 0 || !preg_match('/,1\)"/', $profits[0]))
        {
            array_unshift($profits, '["Date('.date('Y', $targetMonth).','.(date('n', $targetMonth) - 1).','.date('j', $targetMonth).')",null,null,0]');
        }
        else
        {
            $profits[0] = preg_replace('/,null]$/', ',0]', $profits[0]);
        }

        if (count($profits) == 0 || !preg_match('/,'.date('t', $targetMonth).'\)"/', $profits[count($profits) - 1]))
        {
            $profits[] = '["Date('.date('Y', $targetMonth).','.(date('n', $targetMonth) - 1).','.date('t', $targetMonth).')",null,null,'.intval($this->session->get('config')['goal'] ?? 0).']';
        }
        else
        {
            $profits[count($profits) - 1] = preg_replace('/,null]$/', ','.intval($this->session->get('config')['goal'] ?? 0).']', $profits[count($profits) - 1]);
        }
		
        echo '{"data":'.json_encode($data).',"chart":['.implode(',', $profits).']}';
	}

    public function uploadCSV()
	{
        $this->beforePaidApi();
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

        echo '{"result":"success"}';
    }

    private function mb_str_getcsv($line, $delim = ',', $quote = '"') {
        
        $this->beforePaidApi();
        // based on http://www.php.net/manual/ja/function.fgetcsv.php#26886
        #$line: the csv line to be split
        #$delim: the delimiter to split by
        #$removeQuotes: if this is false, the quotation marks won't be removed from the fields
        $removeQuotes = true;
        $fields = array();
        $fldCount = 0;
        $inQuotes = false;
        for ($i = 0; $i < mb_strlen($line); $i++) {
            if (!isset($fields[$fldCount])) $fields[$fldCount] = "";
            $tmp = mb_substr($line, $i, mb_strlen($delim));
            if ($tmp === $delim && !$inQuotes) {
                $fldCount++;
                $i += mb_strlen($delim) - 1;
            } else if ($fields[$fldCount] == "" && mb_substr($line, $i, 1) == $quote && !$inQuotes) {
                if (!$removeQuotes) $fields[$fldCount] .= mb_substr($line, $i, 1);
                $inQuotes = true;
            } else if (mb_substr($line, $i, 1) == $quote) {
                if (mb_substr($line, $i+1, 1) == $quote) {
                    $i++;
                    $fields[$fldCount] .= mb_substr($line, $i, 1);
                } else {
                    if (!$removeQuotes) $fields[$fldCount] .= mb_substr($line, $i, 1);
                    $inQuotes = false;
                }
            } else {
                $fields[$fldCount] .= mb_substr($line, $i, 1);
            }
        }
        return $fields;
    }

}
