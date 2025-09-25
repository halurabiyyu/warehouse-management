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
        $this->down();
        Schema::create('outbounds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
            $table->unsignedBigInteger('quantity')->default(0);
            $table->string('destination');
            $table->date('shipping_date');

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbounds');
    }
};
