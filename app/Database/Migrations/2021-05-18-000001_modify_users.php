<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
	public function up()
	{
        $fields = [
            'active' => [
				'type'          => 'INT',
                'default'       => '0',
            ],
        ];
        $this->forge->addColumn('users', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
