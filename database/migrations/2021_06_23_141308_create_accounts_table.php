<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->uuid('user_currency_id');
            $table->foreign('user_currency_id')
                ->references('id')
                ->on('user_currencies');
            $table->string('name');
            $table->decimal('amount', 10, 3)
                ->default(0.0);
            $table->text('notes')
                ->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
