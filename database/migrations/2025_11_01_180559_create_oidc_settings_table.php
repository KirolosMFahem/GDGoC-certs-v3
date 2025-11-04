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
        Schema::create('oidc_settings', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->nullable();
            $table->text('client_secret')->nullable();
            $table->string('scope')->nullable();
            $table->string('login_endpoint_url')->nullable();
            $table->string('userinfo_endpoint_url')->nullable();
            $table->string('token_validation_endpoint_url')->nullable();
            $table->string('end_session_endpoint_url')->nullable();
            $table->string('identity_key')->nullable();
            $table->boolean('link_existing_users')->default(false);
            $table->boolean('create_new_users')->default(false);
            $table->boolean('redirect_on_expiry')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oidc_settings');
    }
};
