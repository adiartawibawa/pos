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
        // Tabel untuk menyimpan peran pengguna (admin, kasir, dll.)
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('slug')->unique(); // Slug untuk identifikasi internal
            $table->timestamps();
        });

        // Tabel pivot untuk menghubungkan pengguna dengan peran mereka (many-to-many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignUuid('role_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->primary(['role_id', 'user_id']);
        });

        // Tabel untuk menyimpan informasi kategori produk
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Tabel untuk menyimpan informasi produk
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained()->onDelete('restrict');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('sku')->unique()->nullable(); // Stock Keeping Unit
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable(); // Path ke gambar produk
            $table->timestamps();
        });

        // Tabel untuk menyimpan informasi pelanggan
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // Tabel untuk menyimpan informasi diskon
        Schema::create('discounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->decimal('percentage', 5, 2)->nullable(); // Contoh: 10.00 untuk diskon 10%
            $table->decimal('amount', 10, 2)->nullable(); // Diskon dalam jumlah uang
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk menyimpan informasi transaksi penjualan
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('restrict'); // Kasir yang melakukan penjualan
            $table->foreignUuid('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('invoice_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'credit_card', 'transfer'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'partial'])->default('paid');
            $table->timestamps();
        });

        // Tabel pivot untuk menyimpan detail item dalam setiap transaksi penjualan (many-to-many dengan informasi tambahan)
        Schema::create('sale_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sale_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('product_id')->constrained()->onDelete('restrict');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        // Tabel untuk menyimpan informasi supplier
        Schema::create('suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // Tabel untuk menyimpan informasi pembelian
        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('restrict'); // User yang melakukan pembelian
            $table->foreignUuid('supplier_id')->constrained()->onDelete('restrict');
            $table->string('purchase_order_number')->unique()->nullable();
            $table->date('purchase_date');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });

        // Tabel pivot untuk menyimpan detail item dalam setiap pembelian (many-to-many dengan informasi tambahan)
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('purchase_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('product_id')->constrained()->onDelete('restrict');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        // Tabel untuk menyimpan informasi inventaris/stok (opsional, bisa juga dikelola di tabel products)
        Schema::create('inventories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained()->onDelete('cascade');
            $table->integer('stock_in')->default(0);
            $table->integer('stock_out')->default(0);
            $table->integer('current_stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};
