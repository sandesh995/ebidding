<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('base_price');
            $table->timestamp('expiry_date');
            $table->string('description')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('media_id')->nullable()->constrained();
            $table->foreignId('category_id')->constrained();
            $table->boolean('all_complete')->default(false);
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
        Schema::dropIfExists('listings');
    }
}
