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
            $table->string('CNOPS')->nullable();
            $table->string('numeroPPR')->nullable();
            $table->date('date_service')->nullable();
            $table->date('date_grade')->nullable();
            $table->date('date_echellon')->nullable();
            $table->string('mission_respo')->nullable();
            $table->string('local')->nullable();
            $table->string('mutuelle')->nullable();
            //$table->string('solde_conger')->nullable();
            
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
            $table->dropColumn('CNOPS');
            $table->dropColumn('numeroPPR');
            $table->dropColumn('date_service');
            $table->dropColumn('date_grade');
            $table->dropColumn('date_echellon');
            $table->dropColumn('mission_respo');
            $table->dropColumn('local');
            $table->dropColumn('mutuelle');
            
        });
    }
};
