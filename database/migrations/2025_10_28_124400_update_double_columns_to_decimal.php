<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDoubleColumnsToDecimal extends Migration
{
    public function up()
    {
        /*
         * 1️⃣ Truncate existing data to 2 decimals
         * This ensures values like 9.99998 → 9.99
         */
        DB::statement("UPDATE stock_old SET quantity = FLOOR(quantity * 100) / 100");
        DB::statement("UPDATE sale_logs SET is_shipment_charge_applied = FLOOR(is_shipment_charge_applied * 100) / 100");
        DB::statement("UPDATE sales_new_logs SET paid_amount = FLOOR(paid_amount * 100) / 100");
        DB::statement("UPDATE purchase_details SET sales_price = FLOOR(sales_price * 100) / 100");
        DB::statement("UPDATE orders SET is_shipment_charge_applied = FLOOR(is_shipment_charge_applied * 100) / 100");
        DB::statement("UPDATE purchase_detail_logs SET sales_price = FLOOR(sales_price * 100) / 100");
        DB::statement("UPDATE sales_new_logs SET payment_due = FLOOR(payment_due * 100) / 100");
        DB::statement("UPDATE sales_new_logs SET total_price = FLOOR(total_price * 100) / 100");
        DB::statement("UPDATE sale_detail_logs SET quantity = FLOOR(quantity * 100) / 100");
        DB::statement("UPDATE sales SET is_shipment_charge_applied = FLOOR(is_shipment_charge_applied * 100) / 100");
        DB::statement("UPDATE sales_details SET price = FLOOR(price * 100) / 100");
        DB::statement("UPDATE sales_details SET quantity = FLOOR(quantity * 100) / 100");
        DB::statement("UPDATE item SET sales_price = FLOOR(sales_price * 100) / 100");
        DB::statement("UPDATE sale_logs SET payment_due = FLOOR(payment_due * 100) / 100");
        DB::statement("UPDATE booking_details SET quantity = FLOOR(quantity * 100) / 100");
        DB::statement("UPDATE orders SET payment_due = FLOOR(payment_due * 100) / 100");
        DB::statement("UPDATE order_details SET quantity = FLOOR(quantity * 100) / 100");

        /*
         * 2️⃣ Alter columns to decimal(12,2)
         */
        Schema::table('stock_old', function (Blueprint $table) {
            $table->decimal('quantity', 12, 2)->change();
        });

        Schema::table('sale_logs', function (Blueprint $table) {
            $table->decimal('is_shipment_charge_applied', 12, 2)->change();
            $table->decimal('payment_due', 12, 2)->change();
        });

        Schema::table('sales_new_logs', function (Blueprint $table) {
            $table->decimal('paid_amount', 12, 2)->change();
            $table->decimal('payment_due', 12, 2)->change();
            $table->decimal('total_price', 12, 2)->change();
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->decimal('sales_price', 12, 2)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('is_shipment_charge_applied', 12, 2)->change();
            $table->decimal('payment_due', 12, 2)->change();
        });

        Schema::table('purchase_detail_logs', function (Blueprint $table) {
            $table->decimal('sales_price', 12, 2)->change();
        });

        Schema::table('sale_detail_logs', function (Blueprint $table) {
            $table->decimal('quantity', 12, 2)->change();
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('is_shipment_charge_applied', 12, 2)->change();
        });

        Schema::table('sales_details', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
            $table->decimal('quantity', 12, 2)->change();
        });

        Schema::table('item', function (Blueprint $table) {
            $table->decimal('sales_price', 12, 2)->change();
        });

        Schema::table('booking_details', function (Blueprint $table) {
            $table->decimal('quantity', 12, 2)->change();
        });

        Schema::table('order_details', function (Blueprint $table) {
            $table->decimal('quantity', 12, 2)->change();
        });
    }

    public function down()
    {
        /*
         * Revert all decimal(12,2) columns back to double
         */
        Schema::table('stock_old', function (Blueprint $table) {
            $table->double('quantity', 22)->change();
        });

        Schema::table('sale_logs', function (Blueprint $table) {
            $table->double('is_shipment_charge_applied', 22)->change();
            $table->double('payment_due', 22)->change();
        });

        Schema::table('sales_new_logs', function (Blueprint $table) {
            $table->double('paid_amount', 22)->change();
            $table->double('payment_due', 22)->change();
            $table->double('total_price', 22)->change();
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->double('sales_price', 22)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->double('is_shipment_charge_applied', 22)->change();
            $table->double('payment_due', 22)->change();
        });

        Schema::table('purchase_detail_logs', function (Blueprint $table) {
            $table->double('sales_price', 22)->change();
        });

        Schema::table('sale_detail_logs', function (Blueprint $table) {
            $table->double('quantity', 22)->change();
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->double('is_shipment_charge_applied', 22)->change();
        });

        Schema::table('sales_details', function (Blueprint $table) {
            $table->double('price', 22)->change();
            $table->double('quantity', 22)->change();
        });

        Schema::table('item', function (Blueprint $table) {
            $table->double('sales_price', 22)->change();
        });

        Schema::table('booking_details', function (Blueprint $table) {
            $table->double('quantity', 22)->change();
        });

        Schema::table('order_details', function (Blueprint $table) {
            $table->double('quantity', 22)->change();
        });
    }
};