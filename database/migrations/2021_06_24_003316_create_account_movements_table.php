<?php

use Features\AccountMovement\Data\Models\MovementType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->uuid('destination_account_id')
                ->nullable();
            $table->foreign('destination_account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('set null')
                ->onDelete('set null');
            $table->uuid('category_id')
                ->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->decimal('amount', 10, 3);
            $table->enum('movement_type', MovementType::toValues());
            $table->date('created_date');
            $table->time('created_time');
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
        Schema::dropIfExists('account_movements');
    }
}
