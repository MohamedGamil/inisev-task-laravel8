<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsSubscriptionDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_deliveries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subscription_id')->nullable()
                ->constrained('subscriptions')
                ->cascadeOnDelete();

            $table->foreignId('post_id')->nullable()
                ->constrained('posts')
                ->cascadeOnDelete();

            $table->dateTime('delivered_at')->nullable();

            $table->boolean('delivered')
                ->default(0)
                ->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_deliveries');
    }
}
