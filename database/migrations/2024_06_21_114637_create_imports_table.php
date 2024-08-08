<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->string('import_file');
            $table->timestamps();
            $table->string('unique_code');
            $table->string('name');
            $table->string('contact_number');
            $table->string('location_1');
            $table->string('location_2');
            $table->string('location_3');
            $table->string('pin_code');
            $table->string('status');
            $table->string('changed_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
