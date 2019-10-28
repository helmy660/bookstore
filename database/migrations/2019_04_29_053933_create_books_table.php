<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('book_name', 100)->nullable();
            $table->string('book_image', 100)->nullable();
            $table->string('author', 100)->nullable();
            $table->string('description') ; 
            $table->unsignedBigInteger('rate') ;
            $table->unsignedBigInteger('copies_num') ; 
            $table->bigInteger('price')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE books ALTER COLUMN book_image TYPE bytea USING book_image::bytea");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
