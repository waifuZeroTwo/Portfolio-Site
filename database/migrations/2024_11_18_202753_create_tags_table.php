<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('project_tag', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['project_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_tag');
        Schema::dropIfExists('tags');
    }
}
