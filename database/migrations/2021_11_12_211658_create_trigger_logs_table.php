<?php

use App\Models\Trigger;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_logs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignIdFor(Trigger::class, 'trigger_id');
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
        Schema::dropIfExists('trigger_logs');
    }
}
