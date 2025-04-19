<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only extend existing users table if needed
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('role')->default(2); // 1 = admin, 2 = user
                $table->string('phone_number')->nullable();
            });
        }

        // Schedules
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location');
            $table->timestamps();
        });

        // Court Bookings
        Schema::create('court_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->string('court_name');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('cost', 10, 2);
            $table->timestamps();
        });

        // Attendances
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_present');
            $table->time('arrival_time')->nullable();
            $table->time('leave_time')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // Bill Components (Config)
        Schema::create('bill_components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Bills
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('component_type_id')->constrained('bill_components');
            $table->decimal('amount', 10, 2);
            $table->boolean('is_custom')->default(false);
            $table->decimal('custom_amount', 10, 2)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });

        // Transaction Statuses (Config)
        Schema::create('transaction_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paid_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_paid', 10, 2);
            $table->string('image');
            $table->foreignId('status_id')->constrained('transaction_statuses');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Pivot: Transaction - Bills
        Schema::create('transaction_bill', function (Blueprint $table) {
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bill_id')->constrained()->cascadeOnDelete();
        });

        // Pivot: Transaction - Recipients (Traktiran)
        Schema::create('transaction_recipients', function (Blueprint $table) {
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        });

        // Expense Categories (Config)
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Expenses
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->constrained('expense_categories');
            $table->text('description');
            $table->decimal('amount', 10, 2);
            $table->foreignId('paid_by')->constrained('users');
            $table->timestamps();
        });

        // Subsidies (optional traktiran massal)
        Schema::create('subsidies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('component_type_id')->constrained('bill_components');
            $table->decimal('amount', 10, 2);
            $table->foreignId('paid_by_user_id')->constrained('users');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subsidies');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
        Schema::dropIfExists('transaction_recipients');
        Schema::dropIfExists('transaction_bill');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('transaction_statuses');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('bill_components');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('court_bookings');
        Schema::dropIfExists('schedules');

        // Only remove columns from users, not drop the table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone_number']);
        });
    }
};
