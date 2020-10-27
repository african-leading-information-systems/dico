<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->json('description');
            if (config('dico.databases.sluggable')) {
                $table->json('slug')->nullable();
            }
            $table->bigInteger('type_dictionary_id')->unsigned()->index();
            $table->foreign('type_dictionary_id')->references('id')->on('type_dictionaries')
                ->onDelete('cascade');
            if (config('dico.databases.soft_delete')) {
                $table->softDeletes();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries');
    }
}
