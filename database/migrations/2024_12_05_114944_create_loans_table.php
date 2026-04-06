<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateLoansTable extends Migration
{
    public function up()
    {
        // Ubah kolom status dari enum menjadi string dengan nilai default 'waiting'
        Schema::table('loans', function (Blueprint $table) {
            // Hapus enum constraint dulu
            DB::statement("ALTER TABLE loans MODIFY status VARCHAR(50) DEFAULT 'waiting'");
            
            // Tambah kolom baru
            if (!Schema::hasColumn('loans', 'confirmed_by')) {
                $table->unsignedBigInteger('confirmed_by')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('loans', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable()->after('confirmed_by');
            }
            
            // Foreign key untuk confirmed_by
            if (!Schema::hasColumn('loans', 'confirmed_by')) {
                $table->foreign('confirmed_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn(['confirmed_by', 'confirmed_at']);
            
            // Kembalikan ke enum
            DB::statement("ALTER TABLE loans MODIFY status ENUM('borrowed', 'returned') DEFAULT 'borrowed'");
        });
    }
}