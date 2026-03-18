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
        Schema::create("orders", function (Blueprint $table) {
            $table->id();
            $table->string("g_number", 127);
            $table->dateTimeTz("date");
            $table->date("last_change_date");
            $table->string("supplier_article", 127);
            $table->string("tech_size", 127);
            $table->bigInteger("barcode");
            $table->string("total_price", 127);
            $table->unsignedTinyInteger("discount_percent");
            $table->string("warehouse_name", 255);
            $table->string("oblast", 255);
            $table->bigInteger("income_id");
            $table->string("odid", 127);
            $table->bigInteger("nm_id");
            $table->string("subject", 127);
            $table->string("category", 127);
            $table->string("brand", 127);
            $table->boolean("is_cancel")->default(false);
            $table->dateTimeTz("cancel_dt")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orders");
    }
};
