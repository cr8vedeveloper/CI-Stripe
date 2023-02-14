<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
	public function up()
	{
        $fields = [
            'expire_date' => [
				'type'      => 'DATETIME',
				'null'		=> true,
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
