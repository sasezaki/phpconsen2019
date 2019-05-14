<?php
declare(strict_types=1);

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $customer_id
 * @property int $point
 */
class EloquentCustomerPoint extends Model
{
    protected $table = 'customer_points';

    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    private $databaseManager;
    public function __construct(\Illuminate\Database\DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * @param int $customerId
     * @param int $point
     * @return bool
     */
    public function addPoint(int $customerId, int $point): bool
    {
        return $this->databaseManager->update('update customer_points set point=point+:point where customer_id=:customer_id', [
                'point'       => $point,
                'customer_id' => $customerId,
            ]) === 1;
    }

    /**
     * @param int $customerId
     * @return int
     */
    public function findPoint(int $customerId): int
    {
        /** @var self $customerPoint */
        $customerPoint = $this->newQuery()->where('customer_id', $customerId)->firstOrFail();

        return $customerPoint->point;
    }
}
