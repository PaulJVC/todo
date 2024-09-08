<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->boolean('completed');
            $table->date('due_date')->nullable();
            $table->foreignId('priority_id')->constrained()->nullable();
            $table->boolean('archived');
            $table->text('attachment')->nullable();
            $table->text('attachment_name')->nullable();
            $table->text('tags')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
