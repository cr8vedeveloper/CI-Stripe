<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'email' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'unique'         => true,
			],
			'password' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'config' => [
				'type'           => 'TEXT',
			],
			'affiliate_id' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'affiliate_from' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'			 => true,
			],
			'plan' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'contract_period' => [
				'type'           => 'DATE',
				'null'			 => true,
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

		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
