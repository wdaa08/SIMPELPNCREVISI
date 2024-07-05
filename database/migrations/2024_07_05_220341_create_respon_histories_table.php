<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respon_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaporan_id')->constrained('pelaporans')->onDelete('cascade');
            $table->text('respon');
            $table->foreignId('respon_dari')->constrained('users');
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
        Schema::dropIfExists('respon_histories');
    }
}
