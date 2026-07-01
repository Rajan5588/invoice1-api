<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('owner_id');
            $table->string('company_code');
            $table->unsignedBigInteger('role_id');

            // business_profiles
            $table->boolean('business_profiles_add')->default(0);
            $table->boolean('business_profiles_edit')->default(0);
            $table->boolean('business_profiles_delete')->default(0);
            $table->enum('business_profiles_view', ['own','company','all'])->default('own');

            // coupons
            $table->boolean('coupons_add')->default(0);
            $table->boolean('coupons_edit')->default(0);
            $table->boolean('coupons_delete')->default(0);
            $table->enum('coupons_view', ['own','company','all'])->default('own');

            // customers
            $table->boolean('customers_add')->default(0);
            $table->boolean('customers_edit')->default(0);
            $table->boolean('customers_delete')->default(0);
            $table->enum('customers_view', ['own','company','all'])->default('own');

            // invoices
            $table->boolean('invoices_add')->default(0);
            $table->boolean('invoices_edit')->default(0);
            $table->boolean('invoices_delete')->default(0);
            $table->enum('invoices_view', ['own','company','all'])->default('own');

            // items
            $table->boolean('items_add')->default(0);
            $table->boolean('items_edit')->default(0);
            $table->boolean('items_delete')->default(0);
            $table->enum('items_view', ['own','company','all'])->default('own');

            // item_categories
            $table->boolean('item_categories_add')->default(0);
            $table->boolean('item_categories_edit')->default(0);
            $table->boolean('item_categories_delete')->default(0);
            $table->enum('item_categories_view', ['own','company','all'])->default('own');

            // subscriptions
            $table->boolean('subscriptions_add')->default(0);
            $table->boolean('subscriptions_edit')->default(0);
            $table->boolean('subscriptions_delete')->default(0);
            $table->enum('subscriptions_view', ['own','company','all'])->default('own');

            // transactions
            $table->boolean('transactions_add')->default(0);
            $table->boolean('transactions_edit')->default(0);
            $table->boolean('transactions_delete')->default(0);
            $table->enum('transactions_view', ['own','company','all'])->default('own');

            // users
            $table->boolean('users_add')->default(0);
            $table->boolean('users_edit')->default(0);
            $table->boolean('users_delete')->default(0);
            $table->enum('users_view', ['own','company','all'])->default('own');

            // company
            $table->boolean('company_add')->default(0);
            $table->boolean('company_edit')->default(0);
            $table->boolean('company_delete')->default(0);
            $table->enum('company_view', ['own','company','all'])->default('own');

            // roles_permissions
            $table->boolean('roles_permissions_add')->default(0);
            $table->boolean('roles_permissions_edit')->default(0);
            $table->boolean('roles_permissions_delete')->default(0);
            $table->enum('roles_permissions_view', ['own','company','all'])->default('own');

            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
    }
};
