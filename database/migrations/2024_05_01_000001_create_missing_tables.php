<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Extra columns on customers
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'mobile')) $table->string('mobile')->nullable();
            if (!Schema::hasColumn('customers', 'address')) $table->string('address')->nullable();
            if (!Schema::hasColumn('customers', 'bio')) $table->text('bio')->nullable();
            if (!Schema::hasColumn('customers', 'skills')) $table->string('skills')->nullable();
            if (!Schema::hasColumn('customers', 'about')) $table->text('about')->nullable();
            if (!Schema::hasColumn('customers', 'language')) $table->string('language')->nullable();
            if (!Schema::hasColumn('customers', 'tailor')) $table->string('tailor')->default('no');
            if (!Schema::hasColumn('customers', 'image')) $table->string('image')->nullable();
            if (!Schema::hasColumn('customers', 'status')) $table->tinyInteger('status')->default(1);
        });

        // Product attributes
        Schema::create('products_attr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('products_id');
            $table->string('sku')->nullable();
            $table->decimal('mrp', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('qty')->default(0);
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->string('attr_image')->nullable();
            $table->timestamps();
        });

        // Cart
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type')->default('Not Reg');
            $table->string('product_name');
            $table->decimal('product_price', 10, 2)->default(0);
            $table->integer('product_qty')->default(1);
            $table->string('product_image')->nullable();
            $table->unsignedBigInteger('product_attr_id')->nullable();
            $table->string('added_on')->nullable();
            $table->timestamps();
        });

        // Order details
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->decimal('product_price', 10, 2)->default(0);
            $table->integer('product_qty')->default(1);
            $table->unsignedBigInteger('product_attr_id')->nullable();
            $table->string('is_stitch')->default('no');
            $table->string('is_given_tailor')->default('no');
            $table->string('added_on')->nullable();
            $table->timestamps();
        });

        // Tailor services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('tags')->nullable();
            $table->decimal('max_price', 10, 2)->nullable();
            $table->decimal('min_price', 10, 2)->nullable();
            $table->integer('max_delivery_time')->nullable();
            $table->integer('min_delivery_time')->nullable();
            $table->string('image')->nullable();
            $table->text('desc')->nullable();
            $table->text('requirement')->nullable();
            $table->timestamps();
        });

        // User order requests (pending tailor acceptance)
        Schema::create('user_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_product_id');
            $table->unsignedBigInteger('service_user_id');
            $table->unsignedBigInteger('service_id');
            $table->decimal('price', 10, 2)->default(0);
            $table->string('delivery_time')->nullable();
            $table->string('action')->default('waiting');
            $table->string('added_on')->nullable();
            $table->timestamps();
        });

        // Confirmed tailor orders
        Schema::create('confirm_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_product_id')->nullable();
            $table->unsignedBigInteger('service_user_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('delivery_time')->nullable();
            $table->string('is_paid')->default('no');
            $table->string('paid_tailor')->default('no');
            $table->string('status')->default('processing');
            $table->string('added_on')->nullable();
            $table->timestamps();
        });

        // Product ratings
        Schema::create('rating', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->text('rating_desc')->nullable();
            $table->decimal('rating_stars', 3, 1)->default(0);
            $table->string('added_on')->nullable();
            $table->timestamps();
        });

        // Tailor reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_user_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->text('review_desc')->nullable();
            $table->decimal('review_star', 3, 1)->default(0);
            $table->string('added_on')->nullable();
            $table->timestamps();
        });

        // Contact messages
        Schema::create('contact', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('added_on')->nullable();
            $table->timestamps();
        });

        // Tailor bank account numbers
        Schema::create('account_no', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('account_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['mobile','address','bio','skills','about','language','tailor','image','status']);
        });
        Schema::dropIfExists('products_attr');
        Schema::dropIfExists('cart');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('services');
        Schema::dropIfExists('user_orders');
        Schema::dropIfExists('confirm_orders');
        Schema::dropIfExists('rating');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('contact');
        Schema::dropIfExists('account_no');
    }
};
