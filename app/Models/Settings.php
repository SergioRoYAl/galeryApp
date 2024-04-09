<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = ['valor'];

    public function updateCloudPassword($encryptedValue)
    {
        $this->where('name', 'cloud_password')->update(['valor' => $encryptedValue]);
    }

    public function getCloudPassword()
    {
        return $this->where('name', 'cloud_password')->value('valor');
    }

    /**
    * cloud_token
    */
    public function updateToken($token)
    {
        $this->where('name', 'cloud_token')->update(['valor' => $token]);
    }

    public function getToken()
    {
        return $this->where('name', 'cloud_token')->value('valor');
    }

    /**
    * cloud_agencyId
    */
    public function updateCloudMerchantId($cloud_merchantId)
    {
        $this->where('name', 'cloud_merchantId')->update(['valor' => $cloud_merchantId]);
    }

    public function getCloudMerchantId()
    {
        $value = $this->where('name', 'cloud_merchantId')->value('valor');
        return (int)$value;
    }

    /**
    * cloud_agencyId
    */
    public function updateCloudAgencyId($cloud_merchantId)
    {
        $this->where('name', 'cloud_agencyId')->update(['valor' => $cloud_merchantId]);
    }

    public function getCloudAgencyId()
    {
        $value = $this->where('name', 'cloud_agencyId')->value('valor');
        return (int)$value;
    }

}
