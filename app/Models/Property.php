<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class Property extends Model
{
    use HasFactory;
    private $APIUrl = 'https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_vGiVPZJt5relJC0zKG5a7NTLTInZGpdSKQiLRUFL';
    private $currency_api = 'https://v6.exchangerate-api.com/v6/1d9b0bcb02015904db4c2569/latest/KES';
    protected $fillable = [
        'name','name_tr','featured_image','location_id','price','sale','type','bedrooms','drawing_rooms',
        'bathrooms','net_sqm','gross_sqm','pool','overview','overview_tr','why_buy','why_buy_tr','description','description_tr', 'user_id',
    ];
    // protected $guarded = ['created_at', 'updated_at'];
    // protected $hidden = ['created_at', 'updated_at'];


    //    public function featured() {
    //        $this->belongsTo(Media::class, 'featured_media_id');
    //    }

    public function location() {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function gallery() {
        return $this->hasMany(Media::class, 'property_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dynamic_pricing($KenyanShillings) {
        $current_currency = Cookie::get('currency', 'kes');  //ekhane Cookie::get('key':'currency', default:'tl'); mane default KenyanShillings(tl) raktechi amra currency website e.
        if($current_currency == 'usd') {
            $get = Http::get($this->currency_api);//'https://freecurrencyapi.net/api/v2/latest?apikey=76c89170-6178-11ec-98f1-5f7ce0abde0a&base_currency=KES');
            if($get->successful()) {

                //print($get->json()['conversion_rates']['USD']);
                $vl = floatval($get->json()['conversion_rates']['USD']);
                $usd = floatval(floatval($KenyanShillings) * $vl);
                $usd = number_format($usd, 2);
                return $usd . ' USD';
            }
        }
        elseif($current_currency == 'gbp'){
            $get = Http::get($this->currency_api);//'https://freecurrencyapi.net/api/v2/latest?apikey=76c89170-6178-11ec-98f1-5f7ce0abde0a&base_currency=KES');
            if($get->successful()) {
                $bdt = floatval(floatval($KenyanShillings) * $get->json()['conversion_rates']['GBP']);
                $bdt = number_format($bdt, 2);
                return $bdt . ' GBP';
            }
        }
        elseif($current_currency == 'eur'){
            $get = Http::get($this->currency_api);//'https://freecurrencyapi.net/api/v2/latest?apikey=76c89170-6178-11ec-98f1-5f7ce0abde0a&base_currency=KES');
            if($get->successful()) {
                $bdt = floatval(floatval($KenyanShillings) * $get->json()['conversion_rates']['EUR']);
                $bdt = number_format($bdt, 2);
                return $bdt . ' UER';
            }
        }
        elseif($current_currency == 'tzs'){
            $get = Http::get($this->currency_api);//'https://freecurrencyapi.net/api/v2/latest?apikey=76c89170-6178-11ec-98f1-5f7ce0abde0a&base_currency=KES');
            if($get->successful()) {
                $bdt = floatval(floatval($KenyanShillings) * $get->json()['conversion_rates']['TZS']);
                $bdt = number_format($bdt, 2);
                return $bdt . ' TZS';
            }
        }
        elseif($current_currency == 'ugx'){
            $get = Http::get($this->currency_api);//'https://freecurrencyapi.net/api/v2/latest?apikey=76c89170-6178-11ec-98f1-5f7ce0abde0a&base_currency=KES');
            if($get->successful()) {
                $bdt = floatval(floatval($KenyanShillings) * $get->json()['conversion_rates']['UGX']);
                $bdt = number_format($bdt, 2);
                return $bdt . ' UGX';
            }
        }
        else {
            $KenyanShillings = number_format($KenyanShillings, 2);
            return $KenyanShillings . ' KES';
        }
    }

}
