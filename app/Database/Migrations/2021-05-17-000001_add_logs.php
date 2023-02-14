<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLogs extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'action' => [
				'type'           => 'VARCHAR',
                'constraint'     => '255',
			],
			'description' => [
				'type'           => 'TEXT',
			],
			'performer' => [
				'type'           => 'TEXT',
			],
			'created_at' => [
				'type'           => 'DATETIME',
			],
			'updated_at' => [
				'type'           => 'DATETIME',
			],
		]);

		$this->forge->createTable('logs');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('logs');
	}
}
