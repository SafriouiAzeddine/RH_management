
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
            $table->unsignedBigInteger('age_id')->nullable();
            $table->unsignedBigInteger('category_fonctionnaire_id')->nullable();
            
            $table->foreign('age_id')->references('id')->on('ages')->onDelete('set null');
            $table->foreign('category_fonctionnaire_id')->references('id')->on('category_fonctionnaires')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['age_id']);
            $table->dropForeign(['category_fonctionnaire_id']);
            $table->dropColumn(['age_id', 'category_fonctionnaire_id']);
        });
    }
};