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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'full_name');
            $table->string('phone', 20)->nullable()->after('full_name');
            $table->string('google_id')->nullable()->unique()->after('phone');
            $table->string('avatar_url')->nullable()->after('google_id');

            $table->renameColumn('password', 'password_hash');
            $table->boolean('is_active')->default(true)->after('password_hash');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'users',
            function (Blueprint $table) {
                 $table->renameColumn('full_name', 'name');

                 $table->dropColumn([
                    'phone',
                    'google_id',
                    'avatar_url',
                    'is_active',
                    'last_login_at'
                ]);

                 $table->renameColumn('password_hash', 'password');
            }
        );
    }
};