<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('employee_no')->unique();

            $table->foreignId('department_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();

            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('birthdate')->nullable();

            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

            $table->enum('employment_type', ['Plantilla', 'COS', 'Contractual']);
            $table->string('position');

            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->date('hired_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
