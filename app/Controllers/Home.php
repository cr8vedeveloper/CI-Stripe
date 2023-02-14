<?php namespace App\Controllers;

use App\Models\TradesModel;
use App\Models\AccountsModel;
use App\Models\CurrenciesModel;
use App\Models\MethodsModel;

use App\Middleware\AuthMiddleware;

class Home extends AuthBaseController
{
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
    }

	public function home()
	{
		$this->beforeRoute();

		$data = [];
		$data['email'] = $this->session->get('login')['email'];

		$tradesModel = new TradesModel();
		$data['trades'] = $tradesModel->select('id, entered_at, WEEKDAY(entered_at) as weekday, result, currency, method, mode, direction, pips, bet, profit, evaluation')->where('user', $this->session->get('login')['id'])->orderBy('id', 'desc')->findAll(5);

		$currenciesModel = new CurrenciesModel();
		$data['currencies'] = $currenciesModel->findAll();

		$methodsModel = new MethodsModel();
		$data['methods'] = $methodsModel->select('id, name, order')->where('user', $this->session->get('login')['id'])->orderBy('order', 'asc')->findAll();

		return $this->view('home', $data);
	}

	public function analysis()
	{
		$this->beforeRoute();

		$data = [];
		$data['email'] = $this->session->get('login')['email'];
		
		$currenciesModel = new CurrenciesModel();
		$data['currencies'] = $currenciesModel->findAll();

		$methodsModel = new MethodsModel();
		$data['methods'] = $methodsModel->select('id, name, order')->where('user', $this->session->get('login')['id'])->orderBy('order', 'asc')->findAll();
		
		// 配列初期化
		$profit = $count = $win = $lose = [];
		foreach (range(0, 23) as $i)
		{
			$profit['h'.$i] = $count['h'.$i] = $win['h'.$i] = $lose['h'.$i] = 0;
		}

		foreach (range(0, 6) as $i)
		{
			$profit['w'.$i] = $count['w'.$i] = $win['w'.$i] = $lose['w'.$i] = 0;
		}
		
		$profit['c0'] = $count['c0'] = $win['c0'] = $lose['c0'] = 0;
		foreach ($currenciesModel->findAll() as $r)
		{
			$profit['c'.$r['id']] = $count['c'.$r['id']] = $win['c'.$r['id']] = $lose['c'.$r['id']] = 0;
		}

		$profit['m0'] = $count['m0'] = $win['m0'] = $lose['m0'] = 0;
		foreach ($methodsModel->where('user', $this->session->get('login')['id'])->withDeleted()->findAll() as $r)
		{
			$profit['m'.$r['id']] = $count['m'.$r['id']] = $win['m'.$r['id']] = $lose['m'.$r['id']] = 0;
		}

		foreach (range(0, 2) as $i)
		{
			$profit['d'.$i] = $count['d'.$i] = $win['d'.$i] = $lose['d'.$i] = 0;
		}

		// クエリ作成
		$tradesModel = new TradesModel();
		$builder = $tradesModel->select('TIME_FORMAT(entered_at, "%k") as hour, WEEKDAY(entered_at) as week, result, currency, method, direction, pips, profit')->where('user', $this->session->get('login')['id']);

		if ($this->request->getPost('date-from') != '') {
			$builder = $builder->where('entered_at >=', $this->request->getPost('date-from'));
		}
		if ($this->request->getPost('date-to') != '') {
			$builder = $builder->where('entered_at <=', $this->request->getPost('date-to'). ' 23:59:59');
		}
		if ($this->request->getPost('time-from') != '' && $this->request->getPost('time-to') != '' && $this->request->getPost('time-from') > $this->request->getPost('time-to'))
		{
			$builder = $builder->groupStart()
				->orWhere('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) >=', $this->request->getPost('time-from'))
				->orWhere('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) <=', $this->request->getPost('time-to'))
				->groupEnd();
		}
		else
		{
			if ($this->request->getPost('time-from') != '') {
				$builder = $builder->where('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) >=', $this->request->getPost('time-from'));
			}
			if ($this->request->getPost('time-to') != '') {
				$builder = $builder->where('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) <=', $this->request->getPost('time-to'));
			}
		}
		if ($this->request->getPost('weekday') != '') {
			$builder = $builder->whereIn('WEEKDAY(entered_at)', $this->request->getPost('weekday'));
		}
		if ($this->request->getPost('result') != '') {
			$builder = $builder->whereIn('result', $this->request->getPost('result'));
		}
		if ($this->request->getPost('currency') != '') {
			$builder = $builder->whereIn('currency', $this->request->getPost('currency'));
		}
		if ($this->request->getPost('method') != '') {
			$builder = $builder->whereIn('method', $this->request->getPost('method'));
		}
		if ($this->request->getPost('mode') != '') {
			$builder = $builder->whereIn('mode', $this->request->getPost('mode'));
		}
		if ($this->request->getPost('direction') != '') {
			$builder = $builder->whereIn('direction', $this->request->getPost('direction'));
		}
		if ($this->request->getPost('evaluation') != '') {
			$builder = $builder->whereIn('evaluation', $this->request->getPost('evaluation'));
		}

		$total = $profitTotal = $profitPlus = $profitMinus = $winTotal = $loseTotal = $winPips = $losePips = 0;
        foreach ($builder->findAll() as $r)
        {
			$profit['h'.$r['hour']] += $r['profit'];
			$profit['w'.$r['week']] += $r['profit'];
			$profit['c'.$r['currency']] += $r['profit'];
			$profit['m'.$r['method']] += $r['profit'];
			$profit['d'.$r['direction']] += $r['profit'];

			$count['h'.$r['hour']]++;
			$count['w'.$r['week']]++;
			$count['c'.$r['currency']]++;
			$count['m'.$r['method']]++;
			$count['d'.$r['direction']]++;

			if ($r['result'] == 1)
			{
				$win['h'.$r['hour']]++;
				$win['w'.$r['week']]++;
				$win['c'.$r['currency']]++;
				$win['m'.$r['method']]++;
				$win['d'.$r['direction']]++;

				$winTotal++;
				$winPips += $r['pips'];
			}
			elseif ($r['result'] == 2)
			{
				$lose['h'.$r['hour']]++;
				$lose['w'.$r['week']]++;
				$lose['c'.$r['currency']]++;
				$lose['m'.$r['method']]++;
				$lose['d'.$r['direction']]++;

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

		$data['hoursData'] = [];
		$data['hoursMaxCount'] = $data['hoursMaxAverage'] = $data['hoursMaxProfit'] = -INF;
		$data['hoursMinCount'] = $data['hoursMinAverage'] = $data['hoursMinProfit'] = INF;
		foreach (range(0, 23) as $i)
		{
			$average = $win['h'.$i] + $lose['h'.$i] == 0 ? -1 : round($win['h'.$i] / ($win['h'.$i] + $lose['h'.$i]) * 100, 2);

			$data['hoursData'][] = [
				'hour' => $i,
				'count' => intval($count['h'.$i]),
				'average' => $average,
				'profit' => $profit['h'.$i],
			];

			$data['hoursMaxCount'] = max($data['hoursMaxCount'], intval($count['h'.$i]));
			$data['hoursMinCount'] = min($data['hoursMinCount'], intval($count['h'.$i]));
			$data['hoursMaxProfit'] = max($data['hoursMaxProfit'], $profit['h'.$i]);
			$data['hoursMinProfit'] = min($data['hoursMinProfit'], $profit['h'.$i]);

			if ($average != -1) {
				$data['hoursMaxAverage'] = max($data['hoursMaxAverage'], $average);
				$data['hoursMinAverage'] = min($data['hoursMinAverage'], $average);
			}
		}

		$data['weeksData'] = [];
		$data['weeksMaxCount'] = $data['weeksMaxAverage'] = $data['weeksMaxProfit'] = -INF;
		$data['weeksMinCount'] = $data['weeksMinAverage'] = $data['weeksMinProfit'] = INF;
		foreach (range(0, 6) as $i)
		{
			$average = $win['w'.$i] + $lose['w'.$i] == 0 ? -1 : round($win['w'.$i] / ($win['w'.$i] + $lose['w'.$i]) * 100, 2);

			$data['weeksData'][] = [
				'week' => $i,
				'count' => intval($count['w'.$i]),
				'average' => $average,
				'profit' => $profit['w'.$i],
			];

			$data['weeksMaxCount'] = max($data['weeksMaxCount'], intval($count['w'.$i]));
			$data['weeksMinCount'] = min($data['weeksMinCount'], intval($count['w'.$i]));
			$data['weeksMaxProfit'] = max($data['weeksMaxProfit'], $profit['w'.$i]);
			$data['weeksMinProfit'] = min($data['weeksMinProfit'], $profit['w'.$i]);

			if ($average != -1) {
				$data['weeksMaxAverage'] = max($data['weeksMaxAverage'], $average);
				$data['weeksMinAverage'] = min($data['weeksMinAverage'], $average);
			}
		}

		$data['currenciesData'] = [];
		$data['currenciesMaxCount'] = $data['currenciesMaxAverage'] = $data['currenciesMaxProfit'] = -INF;
		$data['currenciesMinCount'] = $data['currenciesMinAverage'] = $data['currenciesMinProfit'] = INF;
		foreach ($currenciesModel->findAll() as $r)
		{
			$average = $win['c'.$r['id']] + $lose['c'.$r['id']] == 0 ? -1 : round($win['c'.$r['id']] / ($win['c'.$r['id']] + $lose['c'.$r['id']]) * 100, 2);

			$data['currenciesData'][] = [
				'currency' => $r['name'],
				'count' => intval($count['c'.$r['id']]),
				'average' => $average,
				'profit' => $profit['c'.$r['id']],
			];

			$data['currenciesMaxCount'] = max($data['currenciesMaxCount'], intval($count['c'.$r['id']]));
			$data['currenciesMinCount'] = min($data['currenciesMinCount'], intval($count['c'.$r['id']]));
			$data['currenciesMaxProfit'] = max($data['currenciesMaxProfit'], $profit['c'.$r['id']]);
			$data['currenciesMinProfit'] = min($data['currenciesMinProfit'], $profit['c'.$r['id']]);

			if ($average != -1) {
				$data['currenciesMaxAverage'] = max($data['currenciesMaxAverage'], $average);
				$data['currenciesMinAverage'] = min($data['currenciesMinAverage'], $average);
			}
		}

		$data['methodsData'] = [];
		$data['methodsMaxCount'] = $data['methodsMaxAverage'] = $data['methodsMaxProfit'] = -INF;
		$data['methodsMinCount'] = $data['methodsMinAverage'] = $data['methodsMinProfit'] = INF;
		foreach ($methodsModel->where('user', $this->session->get('login')['id'])->orderBy('order', 'asc')->findAll() as $r)
		{
			$average = $win['m'.$r['id']] + $lose['m'.$r['id']] == 0 ? -1 : round($win['m'.$r['id']] / ($win['m'.$r['id']] + $lose['m'.$r['id']]) * 100, 2);

			$data['methodsData'][] = [
				'method' => $r['name'],
				'count' => intval($count['m'.$r['id']]),
				'average' => $average,
				'profit' => $profit['m'.$r['id']],
			];

			$data['methodsMaxCount'] = max($data['methodsMaxCount'], intval($count['m'.$r['id']]));
			$data['methodsMinCount'] = min($data['methodsMinCount'], intval($count['m'.$r['id']]));
			$data['methodsMaxProfit'] = max($data['methodsMaxProfit'], $profit['m'.$r['id']]);
			$data['methodsMinProfit'] = min($data['methodsMinProfit'], $profit['m'.$r['id']]);

			if ($average != -1) {
				$data['methodsMaxAverage'] = max($data['methodsMaxAverage'], $average);
				$data['methodsMinAverage'] = min($data['methodsMinAverage'], $average);
			}
		}

		$data['directionsData'] = [];
		foreach (range(1, 2) as $i)
		{
			$average = $win['d'.$i] + $lose['d'.$i] == 0 ? -1 : round($win['d'.$i] / ($win['d'.$i] + $lose['d'.$i]) * 100, 2);

			$data['directionsData'][] = [
				'direction' => ['','HIGH','LOW'][$i],
				'count' => intval($count['d'.$i]),
				'average' => $average,
				'profit' => $profit['d'.$i],
			];
		}

		// 総計用
		$data['total'] = number_format($total);
		$data['profitTotal'] = number_format($profitTotal);
		$data['winTotal'] = number_format($winTotal);
		$data['loseTotal'] = number_format($loseTotal);
		$data['average'] = $winTotal + $loseTotal == 0 ? '--' : round($winTotal / ($winTotal + $loseTotal) * 100, 2).'%';
		$data['pf'] = $profitMinus == 0 ? '--' : round($profitPlus / abs($profitMinus), 3);
		$data['averageWinPips'] = $winTotal == 0 ? '--' : round($winPips / $winTotal, 2);
		$data['averageLosePips'] = $loseTotal == 0 ? '--' : round($losePips / $loseTotal, 2);

		$builder = $tradesModel->select('DATE_FORMAT(entered_at, "%Y/%m/%d") as date, sum(win) as win, sum(lose) as lose, sum(profit) as profit')->where('user', $this->session->get('login')['id'])->groupBy('DATE_FORMAT(entered_at, "%Y%m%d")');
		
		if ($this->request->getPost('date-from') != '') {
			$builder = $builder->where('entered_at >=', $this->request->getPost('date-from'));
		}
		if ($this->request->getPost('date-to') != '') {
			$builder = $builder->where('entered_at <=', $this->request->getPost('date-to'). ' 23:59:59');
		}
		if ($this->request->getPost('time-from') != '' && $this->request->getPost('time-to') != '' && $this->request->getPost('time-from') > $this->request->getPost('time-to'))
		{
			$builder = $builder->groupStart()
				->orWhere('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) >=', $this->request->getPost('time-from'))
				->orWhere('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) <=', $this->request->getPost('time-to'))
				->groupEnd();
		}
		else
		{
			if ($this->request->getPost('time-from') != '') {
				$builder = $builder->where('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) >=', $this->request->getPost('time-from'));
			}
			if ($this->request->getPost('time-to') != '') {
				$builder = $builder->where('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) <=', $this->request->getPost('time-to'));
			}
		}
		if ($this->request->getPost('weekday') != '') {
			$builder = $builder->whereIn('WEEKDAY(entered_at)', $this->request->getPost('weekday'));
		}
		if ($this->request->getPost('result') != '') {
			$builder = $builder->whereIn('result', $this->request->getPost('result'));
		}
		if ($this->request->getPost('currency') != '') {
			$builder = $builder->whereIn('currency', $this->request->getPost('currency'));
		}
		if ($this->request->getPost('method') != '') {
			$builder = $builder->whereIn('method', $this->request->getPost('method'));
		}
		if ($this->request->getPost('mode') != '') {
			$builder = $builder->whereIn('mode', $this->request->getPost('mode'));
		}
		if ($this->request->getPost('direction') != '') {
			$builder = $builder->whereIn('direction', $this->request->getPost('direction'));
		}
		if ($this->request->getPost('evaluation') != '') {
			$builder = $builder->whereIn('evaluation', $this->request->getPost('evaluation'));
		}

		$profits = []; $total = 0;
		foreach ($builder->findAll() as $r)
		{
			$total += $r['profit'];
			$date = strtotime($r['date']);
			$profits[] = '["Date('.date('Y', $date).','.(date('n', $date) - 1).','.date('j', $date).')",'.$total.','.
            	json_encode(date('Y年n月j日', strtotime($r['date']))."\n".'収支：'.number_format($r['profit'])."\n".'勝率：'.($r['win'] + $r['lose'] == 0 ? '--' : round($r['win'] / ($r['win'] + $r['lose']) * 100, 2).'%'))
            	.']';
		}
		$data['jsonProfits'] = '['.implode(',', $profits).']';

		$data['formDefault'] = $this->request->getPost();

		return $this->view('analysis', $data);
	}

	public function history()
	{
		$this->beforeRoute();

		$data = [];
		$data['email'] = $this->session->get('login')['email'];

		$currenciesModel = new CurrenciesModel();
		$data['currencies'] = $currenciesModel->findAll();

		$methodsModel = new MethodsModel();
		$data['methods'] = $methodsModel->select('id, name, order')->where('user', $this->session->get('login')['id'])->orderBy('order', 'asc')->findAll();

		// クエリ作成
		$tradesModel = new TradesModel();
		$builder = $tradesModel->select('id, entered_at, WEEKDAY(entered_at) as weekday, result, currency, method, mode, direction, pips, bet, profit, evaluation')->where('user', $this->session->get('login')['id'])->orderBy('entered_at', 'desc');

		if ($this->request->getPost())
		{
			if ($this->request->getPost('date-from') != '') {
				$builder = $builder->where('entered_at >=', $this->request->getPost('date-from'));
			}
			if ($this->request->getPost('date-to') != '') {
				$builder = $builder->where('entered_at <=', $this->request->getPost('date-to'). ' 23:59:59');
			}
			if ($this->request->getPost('time-from') != '' && $this->request->getPost('time-to') != '' && $this->request->getPost('time-from') > $this->request->getPost('time-to'))
			{
				$builder = $builder->groupStart()
					->orWhere('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) >=', $this->request->getPost('time-from'))
					->orWhere('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) <=', $this->request->getPost('time-to'))
					->groupEnd();
			}
			else
			{
				if ($this->request->getPost('time-from') != '') {
					$builder = $builder->where('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) >=', $this->request->getPost('time-from'));
				}
				if ($this->request->getPost('time-to') != '') {
					$builder = $builder->where('CAST(TIME_FORMAT(entered_at, "%k") AS DECIMAL) <=', $this->request->getPost('time-to'));
				}
			}
			if ($this->request->getPost('weekday') != '') {
				$builder = $builder->whereIn('WEEKDAY(entered_at)', $this->request->getPost('weekday'));
			}
			if ($this->request->getPost('result') != '') {
				$builder = $builder->whereIn('result', $this->request->getPost('result'));
			}
			if ($this->request->getPost('currency') != '') {
				$builder = $builder->whereIn('currency', $this->request->getPost('currency'));
			}
			if ($this->request->getPost('method') != '') {
				$builder = $builder->whereIn('method', $this->request->getPost('method'));
			}
			if ($this->request->getPost('mode') != '') {
				$builder = $builder->whereIn('mode', $this->request->getPost('mode'));
			}
			if ($this->request->getPost('direction') != '') {
				$builder = $builder->whereIn('direction', $this->request->getPost('direction'));
			}
			if ($this->request->getPost('evaluation') != '') {
				$builder = $builder->whereIn('evaluation', $this->request->getPost('evaluation'));
			}

			$data['formDefault'] = $this->request->getPost();
		}
		else
		{
			$builder = $builder->where('entered_at >=', date('Y-m-01'));

			$data['formDefault'] =  [
				'date-from' => date('Y-m-01'),
			];
		}

        $data['trades'] = $builder->findAll();

		return $this->view('history', $data);
	}

	public function account()
	{
		$this->beforeRoute();

		$data = [];
		$data['email'] = $this->session->get('login')['email'];

		$model = new AccountsModel();
		$data['accounts'] = [];
		foreach ($model->select('id, entered_at, amount, bonus')->where('user', $this->session->get('login')['id'])->orderBy('entered_at', 'desc')->findAll() as $r)
		{
			$data['accounts'][] = [
				'id' => $r['id'],
				'entered_at' => $r['entered_at'],
				'in' => $r['amount'] > 0 ? $r['amount'] : '',
				'out' => $r['amount'] < 0 ? $r['amount'] * -1 : '',
				'bonus' => $r['bonus'] > 0 ? $r['bonus'] : '',
			];
		}

		return $this->view('account', $data);
	}

	public function config()
	{
		$this->beforeRoute();
		
		$data = [];
		$data['email'] = $this->session->get('login')['email'];

		$model = new MethodsModel();
		$data['methods'] = $model->select('id, name, order')->where('user', $this->session->get('login')['id'])->findAll();
		$data['formDefault'] = $this->session->get('config');
		$data['affiliateUrl'] = base_url('/regist') . '?ref=' . $this->session->get('login')['affiliate_id'];

		return $this->view('config', $data);
	}
}

