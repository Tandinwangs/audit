<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('engagements', function (Blueprint $table) {
            $table->id();
            $table->string('created_by');
            $table->string('dispatch_number');
            $table->string('address');
            $table->string('unit');
            $table->string('vertical');
            $table->string('letter')->nullable();
            // $table->string('memo')->nullable();
            $table->date('coverage_start_date');
            $table->date('coverage_end_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engagements');
    }
};
