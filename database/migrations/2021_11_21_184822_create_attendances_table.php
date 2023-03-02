<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['present', 'absent', 'late', 'late_with_excuse', 'early_dismissal']);
            $table->string('in_time', 255)->nullable();
            $table->string('out_time', 255)->nullable();
            $table->string('attNot', 255)->nullable();
            $table->date('date');
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
        Schema::dropIfExists('attendances');
    }
}
