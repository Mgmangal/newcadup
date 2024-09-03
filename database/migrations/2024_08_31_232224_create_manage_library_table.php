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
        Schema::create('manage_library', function (Blueprint $table) {
            $table->id(); // id (primary key, auto-incrementing)
            $table->unsignedBigInteger('parent_id')->nullable(); // parent_id (nullable, assuming it relates to another entry in the same table)
            $table->string('type'); // type (assuming it's a string)
            $table->string('title'); // title (string, max 255 characters)
            $table->text('description')->nullable(); // description (text, nullable)
            $table->string('file')->nullable(); // file (string, for storing file path, nullable)
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('is_delete', ['0', '1'])->default('0');
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_library');
    }
};
