<?php

namespace Mgh\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Notifiable,Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name', 'category_id',
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
        static::saving(
            function ($products) {
                Cache::forget('products');

                $products = \Mgh\Order\Product::pluck('name', 'id');
                Cache::forever('products', $products);
            });
    }

    public function Order()
    {
        return $this->hasOne(Order::class);
    }

    public function searchableAs()
    {
        return 'name';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }
}
