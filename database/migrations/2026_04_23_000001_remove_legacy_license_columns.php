<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('settings_two')) {
            Schema::table('settings_two', function (Blueprint $table) {
                if (Schema::hasColumn('settings_two', 'liquid_license_type')) {
                    $table->dropColumn('liquid_license_type');
                }

                if (Schema::hasColumn('settings_two', 'liquid_license_domain_key')) {
                    $table->dropColumn('liquid_license_domain_key');
                }
            });
        }

        if (Schema::hasTable('extensions') && Schema::hasColumn('extensions', 'licensed')) {
            Schema::table('extensions', function (Blueprint $table) {
                $table->dropColumn('licensed');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('settings_two')) {
            Schema::table('settings_two', function (Blueprint $table) {
                if (! Schema::hasColumn('settings_two', 'liquid_license_type')) {
                    $table->string('liquid_license_type')->nullable();
                }

                if (! Schema::hasColumn('settings_two', 'liquid_license_domain_key')) {
                    $table->string('liquid_license_domain_key')->nullable();
                }
            });
        }

        if (Schema::hasTable('extensions') && ! Schema::hasColumn('extensions', 'licensed')) {
            Schema::table('extensions', function (Blueprint $table) {
                $table->boolean('licensed')->default(false);
            });
        }
    }
};
