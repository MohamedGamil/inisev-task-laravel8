<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('slug')->index()->nullable();
            $table->text('description')->nullable();
            $table->dateTime('published_at')->nullable();

            $table->boolean('published')
                ->default(1)
                ->index();

            $table->foreignId('author_id')->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('website_id')->nullable()
                ->constrained('websites')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('posts');
    }
}
