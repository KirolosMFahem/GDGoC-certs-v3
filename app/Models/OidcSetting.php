<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OidcSetting extends Model
{
    protected $fillable = [
        'client_id',
        'client_secret',
        'scope',
        'login_endpoint_url',
        'userinfo_endpoint_url',
        'token_validation_endpoint_url',
        'end_session_endpoint_url',
        'identity_key',
        'link_existing_users',
        'create_new_users',
        'redirect_on_expiry',
    ];

    protected $casts = [
        'link_existing_users' => 'boolean',
        'create_new_users' => 'boolean',
        'redirect_on_expiry' => 'boolean',
    ];

    /**
     * Get the client_secret attribute, decrypting it.
     */
    public function getClientSecretAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    /**
     * Set the client_secret attribute, encrypting it.
     */
    public function setClientSecretAttribute($value)
    {
        $this->attributes['client_secret'] = $value ? encrypt($value) : null;
    }
}
