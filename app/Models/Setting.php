<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'type', 'description'];

    protected static $cache = [];

    /**
     * Retrieve a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        $value = $setting->castValue();
        self::$cache[$key] = $value;
        
        return $value;
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return Setting
     */
    public static function set($key, $value, $type = 'string')
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = (string) $value; // Store as string for flexibility
        $setting->type = $type;
        $setting->save();

        unset(self::$cache[$key]);

        return $setting;
    }

    /**
     * Cast value based on type.
     */
    public function castValue()
    {
        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
}
