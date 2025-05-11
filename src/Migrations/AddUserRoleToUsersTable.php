<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserRoleToUsersTable extends Migration
{
    public function up()
    {
        Capsule::schema()->table('users', function (Blueprint $table) {
            $table->string('user_role')->default('user')->after('email');
        });
    }

    public function down()
    {
        Capsule::schema()->table('users', function (Blueprint $table) {
            $table->dropColumn('user_role');
        });
    }
}
