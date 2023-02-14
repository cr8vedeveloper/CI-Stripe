<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMethods extends Migration
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
			'name' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'order' => [
				'type'           => 'INT',
				'unsigned'       => true,
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

		$this->forge->createTable('methods');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('methods');
	}
}
