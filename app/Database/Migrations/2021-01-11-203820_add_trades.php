<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTrades extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'user' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'entered_at' => [
				'type'           => 'DATETIME',
			],
			'result' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
			'win' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
			'lose' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
			'currency' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
			'method' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'mode' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
			'direction' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
			'pips' => [
				'type'           => 'INT',
			],
			'bet' => [
				'type'           => 'INT',
			],
			'profit' => [
				'type'           => 'INT',
			],
			'evaluation' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('user');

		$this->forge->createTable('trades');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('trades');
	}
}
