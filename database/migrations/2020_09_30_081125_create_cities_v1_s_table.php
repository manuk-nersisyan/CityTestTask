<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesV1STable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities_v1_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('geo_name_id')->nullable();
            $table->string('name',200)->nullable();
            $table->string('ascii_name',200)->nullable();
            $table->string('alternate_names',10000)->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->char('feature_class',1)->nullable();
            $table->string('feature_code',10)->nullable();
            $table->char('country_code',2)->nullable();
            $table->string('cc2',200)->nullable();
            $table->string('admin1',20)->nullable();
            $table->string('admin2',80)->nullable();
            $table->string('admin3',20)->nullable();
            $table->string('admin4',20)->nullable();
            $table->bigInteger('population')->nullable();
            $table->string('elevation')->nullable();
            $table->integer('dem')->nullable();
            $table->string('timezone',40)->nullable();
            $table->date('modification_date')->nullable();
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
        Schema::dropIfExists('cities_v1_s');
    }
}
