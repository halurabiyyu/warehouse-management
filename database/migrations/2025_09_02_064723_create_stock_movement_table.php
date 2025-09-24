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
        Schema::create('stock_movement', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
            $table->enum('type', ['masuk', 'keluar']);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->foreignUuid('inbound_id')
                ->nullable()
                ->references('id')
                ->on('inbounds')
                ->onDelete('cascade');

            $table->foreignUuid('outbound_id')
                ->nullable()
                ->references('id')
                ->on('outbounds')
                ->onDelete('cascade');
            $table->date('movement_date');

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
        Schema::dropIfExists('stock_movement');
    }
};
