<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order', function (Blueprint $table) {
            $table->id();
            $table->string('wo_number')->unique();
            $table->enum('department', [
                'FB Kitchen',
                'Housekeeping',
                'Front Office',
                'DT',
                'FB Service',
                'P&C',
                'Security',
                'Sales',
                'Acct',
                'A&G',
            ]);
            $table->enum('issue_type', [
                'ELECTRICAL',
                'MECHANICAL',
                'PLUMBING',
                'HVAC',
                'BUILDING',
                'FURNITURE',
                'AV',
                'SAFETY',
                'OTHER',
            ]);
            $table->text('description')->nullable();
            $table->enum('status', ['Pending', 'On Progress', 'Completed'])->default('Pending');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order');
    }
};
