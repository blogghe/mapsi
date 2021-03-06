<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'contacts', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->unsignedBigInteger('user_id')->index();
            $table->string( 'name' );
            $table->string( 'email' );
            $table->string( 'street' )->nullable();
            $table->integer( 'sNumber' )->nullable();
            $table->string( 'bus' )->nullable();
            $table->string( 'city' )->nullable();
            $table->integer( 'zip' )->nullable();
            $table->integer( 'gender' )->default(0);
            $table->integer( 'phone' )->nullable();
            $table->date( 'birthdate' )->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'contacts' );
    }
}
