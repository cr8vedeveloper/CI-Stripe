<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
	public function up()
	{
        $fields = [
            'register_token' => [
				'type'          => 'VARCHAR',
                'constraint'    => '255',
            ],
            'confirmpassword_token' => [
				'type'          => 'VARCHAR',
                'constraint'    => '255',
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
