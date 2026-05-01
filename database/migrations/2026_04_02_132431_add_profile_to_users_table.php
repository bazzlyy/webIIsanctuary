<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable();
            }

            if (!Schema::hasColumn('users', 'nickname')) {
                $table->string('nickname')->nullable();
            }

            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable();
            }

            // 🔥 TAMBAHAN UNTUK PROFILE MODERN
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable();
            }

            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable();
            }

            if (!Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code')->nullable();
            }

        });
    }

    public function down()
{
    Schema::table('users', function (Blueprint $table) {

        if (Schema::hasColumn('users', 'avatar')) {
            $table->dropColumn('avatar');
        }

        if (Schema::hasColumn('users', 'nickname')) {
            $table->dropColumn('nickname');
        }

        if (Schema::hasColumn('users', 'bio')) {
            $table->dropColumn('bio');
        }

        if (Schema::hasColumn('users', 'phone')) {
            $table->dropColumn('phone');
        }

        if (Schema::hasColumn('users', 'country')) {
            $table->dropColumn('country');
        }

        if (Schema::hasColumn('users', 'city')) {
            $table->dropColumn('city');
        }

        if (Schema::hasColumn('users', 'postal_code')) {
            $table->dropColumn('postal_code');
        }

    });
}
};