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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nomFr')->nullable();
            $table->string('nomAr')->nullable();
            $table->string('prenomFr')->nullable();
            $table->string('prenomAr')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->bigInteger('role')->default('0');
            $table->boolean('is_congé')->default('false');
            $table->rememberToken();
            $table->timestamps();
            // Additional fields from fonctionnaire

            $table->string('nomPereFr')->nullable();
            $table->string('nomPereAr')->nullable();
            $table->string('nomMereFr')->nullable();
            $table->string('nomMereAr')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('CINE')->nullable();
            $table->string('filiere')->nullable();



        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
