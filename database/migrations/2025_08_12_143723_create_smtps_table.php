<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smtps', function (Blueprint $table) {
            $table->id();
            $table->string('mailer')->default('smtp'); // MAIL_MAILER
            $table->string('host'); // MAIL_HOST
            $table->integer('port'); // MAIL_PORT
            $table->string('username'); // MAIL_USERNAME
            $table->string('password'); // MAIL_PASSWORD
            $table->string('encryption')->nullable(); // MAIL_ENCRYPTION
            $table->string('from_address'); // MAIL_FROM_ADDRESS
            $table->string('from_name'); // MAIL_FROM_NAME
            $table->integer('limit')->default(1); // LIMIT
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('smtps');
    }
}
