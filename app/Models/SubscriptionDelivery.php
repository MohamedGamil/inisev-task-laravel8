<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionDelivery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'subscription_id',
        'post_id',
        'delivered_at',
        'delivered',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'delivered_at' => 'datetime',
        'delivered' => 'boolean',
    ];

    /**
     * Related post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * Related subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    /**
     * Set a post as delivered for a given subscription.
     *
     * @param int $postId
     * @param int $subscriptionId
     * @return bool
     */
    public static function setDelivered($postId, $subscriptionId)
    {
        $attrs = [
            'post_id' => $postId,
            'subscription_id' => $subscriptionId,
            'delivered_at' => now(),
            'delivered' => true,
        ];

        $instance = new static($attrs);

        return $instance->save();
    }

    /**
     * Check if given subscription has already received an email for a given post ID.
     *
     * @param int $postId
     * @param int $subscriptionId
     * @return bool
     */
    public static function checkDelivery($postId, $subscriptionId)
    {
        $first = static::query()
            ->where('post_id', $postId)
            ->where('subscription_id', $subscriptionId)
            ->where('delivered', 1)
            ->get()
            ->first();

        return false === empty($first);
    }
}
