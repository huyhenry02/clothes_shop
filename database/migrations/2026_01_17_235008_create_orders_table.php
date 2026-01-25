<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->string('order_code', 20);
            $table->integer('total_amount');
            $table->string('status');
            $table->string('payment_status');
            $table->string('payment_method');
            $table->text('shipping_name');
            $table->text('shipping_phone');
            $table->text('shipping_email')->nullable();
            $table->text('shipping_address');
            $table->date('completed_at')->nullable();
            $table->dateTime('payment_time')->nullable();
            $table->string('payment_transaction_id', 255)->nullable();
            $table->string('payment_bank_code', 255)->nullable();
            $table->string('payment_response_code', 255)->nullable();
            $table->string('payment_secure_hash', 255)->nullable();
            $table->timestamps();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->unique('order_code', 'orders_order_code_unique');
            $table->index('customer_id', 'orders_customer_id_foreign');
            $table->index('updated_by', 'orders_updated_by_foreign');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('updated_by')->references('id')->on('employees');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
