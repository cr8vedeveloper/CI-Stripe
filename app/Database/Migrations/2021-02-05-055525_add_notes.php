<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNotes extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'user' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'note' => [
				'type'           => 'TEXT',
			],
			'image' => [
				'type'           => 'MEDIUMTEXT',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('user');

		$this->forge->createTable('notes');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('notes');
	}
}
