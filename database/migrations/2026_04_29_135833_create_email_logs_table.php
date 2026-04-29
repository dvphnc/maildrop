<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
{
    Schema::create('email_logs', function (Blueprint $table) {
        $table->id();
        $table->string('sender_name');
        $table->string('recipient_email');
        $table->text('message');
        $table->string('attachment')->nullable();
        $table->decimal('amount', 8, 2);
        $table->string('status')->default('sent');
        $table->timestamps();
    });
}
    
};
