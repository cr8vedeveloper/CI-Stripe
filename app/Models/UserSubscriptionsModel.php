<?php namespace App\Models;

use CodeIgniter\Model;

class UserSubscriptionsModel extends Model
{
    protected $table      = 'user_subscriptions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 
        'plan', 
        'stripe_subscription_id', 
        'stripe_customer_id', 
        'stripe_plan_id', 
        'plan_amount', 
        'plan_amount_currency',
        'plan_interval',
        'plan_interval_count',
        'plan_period_start',
        'plan_period_end',
        'payer_email',
        'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
