<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmulatorPerformanceIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emulator_performance_indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at');
            $table->string('emulator');
            $table->unsignedInteger('latency');
            $table->unsignedInteger('online');
            $table->unsignedInteger('accounts');
            $table->unsignedInteger('newcomers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('emulator_performance_indicators');
    }
}
