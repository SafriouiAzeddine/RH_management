<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('id_grade')->nullable()->constrained('grades');
            $table->foreignId('id_division')->nullable()->constrained('divisions');
            $table->foreignId('id_service')->nullable()->constrained('services');
            $table->foreignId('id_status')->nullable()->constrained('status_fonctionnaires');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_grade']);
            $table->dropForeign(['id_division']);
            $table->dropForeign(['id_service']);
            $table->dropForeign(['id_status']);
        });
    }
};
