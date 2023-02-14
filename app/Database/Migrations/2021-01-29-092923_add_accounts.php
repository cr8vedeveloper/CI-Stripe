<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccounts extends Migration
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
			'amount' => [
				'type'           => 'INT',
			],
			'bonus' => [
				'type'           => 'INT',
			],
			'created_at' => [
				'type'           => 'DATETIME',
			],
			'updated_at' => [
				'type'           => 'DATETIME',
			],
			'deleted_at' => [
				'type'           => 'DATETIME',
				'null'			 => true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('user');

		$this->forge->createTable('accounts');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('accounts');
	}
}
