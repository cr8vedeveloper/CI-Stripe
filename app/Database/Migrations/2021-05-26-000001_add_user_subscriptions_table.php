<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserSubscription extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'user_id' => [
				'type'           => 'INT',
			],
			'plan' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'stripe_subscription_id' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'stripe_customer_id' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'stripe_plan_id' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'plan_amount' => [
				'type'           => 'FLOAT',
                'default'        => 0,
				'null'			 => false,
			],
			'plan_amount_currency' => [
				'type'           => 'VARCHAR',
				'constraint'     => '10',
			],
			'plan_interval' => [
				'type'           => 'VARCHAR',
				'constraint'     => '10',
			],
			'plan_interval_count' => [
				'type'           => 'TINYINT',
				'constraint'     => '2',
			],
			'plan_period_start' => [
				'type'           => 'DATETIME',
			],
			'plan_period_end' => [
				'type'           => 'DATETIME',
			],
			'payer_email' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'status' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
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

		$this->forge->createTable('user_subscriptions');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user_subscriptions');
	}
}
