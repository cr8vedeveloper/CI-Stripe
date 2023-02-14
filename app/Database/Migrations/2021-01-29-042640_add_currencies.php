<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCurrencies extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
			'name' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'order' => [
				'type'           => 'TINYINT',
				'unsigned'       => true,
			],
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('currencies');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('currencies');
	}
}
