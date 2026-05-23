<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('kitchen_received_at')->nullable()->after('notes');
            $table->timestamp('cooking_started_at')->nullable()->after('kitchen_received_at');
            $table->timestamp('ready_at')->nullable()->after('cooking_started_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'kitchen_received_at',
                'cooking_started_at',
                'ready_at'
            ]);
        });
    }
};