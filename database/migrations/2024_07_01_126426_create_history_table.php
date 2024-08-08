<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('count');
            $table->string('contact_number');
            $table->timestamp('imports_updated_at');

            $table->foreign('import_id')->references('id')->on('imports')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('history');
    }
}
