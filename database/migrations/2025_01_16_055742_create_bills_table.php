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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->references("id")->on("orders")->onDelete("cascade");
            $table->string("name")->nullable();
            $table->string("email")->nullable();
            $table->string("contact")->nullable();
            $table->text("address")->nullable();
            $table->string("country")->nullable();
            $table->string("state")->nullable();
            $table->string("pin_code")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};