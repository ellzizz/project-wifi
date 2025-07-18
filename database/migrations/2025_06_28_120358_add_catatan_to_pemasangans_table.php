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
        Schema::table('pemasangans', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('status');
        });
    }
    
    public function down(): void
    {
        Schema::table('pemasangans', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
    
};
