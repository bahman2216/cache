<?php

namespace Mgh\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;

class Order extends Model
{
    use Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'product_id', 'quantity', 'color'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
        ];

    protected static function boot()
    {
        parent::boot();

        // also for updating.
        static::saved(
            function ($orders) {
                Cache::forget('orders');

                Cache::rememberForever('orders', function () {
                    return \Mgh\Order\Order::with('product')->paginate(15);
                });

            });
        static::updated(
            function ($orders) {
                Cache::forget('orders');

                Cache::rememberForever('orders', function () {
                    return \Mgh\Order\Order::with('product')->paginate(15);
                });
            });
        static::deleted(
            function ($orders) {
                Cache::forget('orders');

                Cache::rememberForever('orders', function () {
                    return \Mgh\Order\Order::with('product')->paginate(15);
                });
            });
    }


    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        /*$record = $this->toArray();

        $record['_tags'] = explode(';', $array['tags']);

        $record['added_month'] = substr($record['created_at'], 0, 7);

        unset($record['tags'], $record['created_at'], $record['updated_at']);

        return $record;*/
        /**
         * Load the products relation so that it's available
         *  in the laravel toArray method
         */
        $this->product;

        return $this->toArray();

        /*$array = $this->toArray();

        $array['categories'] = $this->categories->map(function ($data) {
            return $data['name'];
        })->toArray();

        return $array;*/
    }

    public function User()
    {
        return $this->blongsTo('App\User');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
