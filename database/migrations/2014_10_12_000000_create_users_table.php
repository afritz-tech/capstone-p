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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('birthDate')->nullable()->default(null);  // Added default(null)
            $table->string('profilePicture')->nullable()->default(null);  // Added default(null)
            $table->boolean('isSelfPay')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

    class AddProfilePictureToUsersTable extends Migration
    {
        public function up()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profilePicture')->nullable();
            });
        }

        public function down()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('profilePicture');
            });
        }
    }
