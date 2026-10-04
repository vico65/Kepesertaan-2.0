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
        Schema::create('staff', function (Blueprint $table) {
            // Kolom npp: integer primary key (auto-increment agar jika tidak dikirimkan di request body, otomatis terisi)
            $table->integer('npp', true);

            // Kolom name: varchar(255) not null
            $table->string('name', 255);

            // Kolom email: varchar(255) not null dan bersifat unik
            $table->string('email', 255)->unique();

            // Kolom passkey: varchar(255) not null untuk menyimpan hash bcrypt
            $table->string('passkey', 255);

            // Kolom status: enum ('active', 'inactive') dengan nilai default 'active'
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Kolom created_at: timestamp dengan nilai default current_timestamp
            $table->timestamp('created_at')->useCurrent();

            // Kolom updated_at: timestamp dengan nilai default current_timestamp on update current_timestamp
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
