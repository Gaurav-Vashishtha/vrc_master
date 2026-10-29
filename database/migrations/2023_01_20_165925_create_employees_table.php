<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_master', function (Blueprint $table) {
            $table->id();

            $table->string('password');
            $table->integer('usertype')->default('0');
            $table->string('status')->default('0');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('position')->nullable();
            $table->string('emp_code')->unique();
            $table->string('father_name')->nullable();
            $table->date('DOB')->nullable();
            $table->string('gender')->nullable();
            $table->string('profile_photo')->nullable();

            $table->string('personal_email')->unique();
            $table->string('company_email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('personal_mobile')->unique();
            $table->string('company_mobile')->unique();

            $table->string('current_add')->nullable();
            $table->string('permanent_add')->nullable();
            $table->string('pincode')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();

            $table->bigInteger('sallary')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('acc_no')->nullable();
            $table->string('ifsc')->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('employee_master');
    }
}
