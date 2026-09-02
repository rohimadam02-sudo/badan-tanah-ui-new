<?php

namespace App\Helpers;

class LanguageHelper
{
    /**
     * Get translated text based on current locale
     * 
     * @param array|string $data Data with 'id' and 'en' keys, or single text
     * @param string $field Field name (e.g., 'judul', 'isi')
     * @param string $default Default text if translation not found
     * @return string
     */
    public static function getTranslation($data, $field = null, $default = null)
    {
        $locale = session('locale', 'id');
        
        // If data is array with 'id' and 'en' keys
        if (is_array($data) && isset($data['id']) && isset($data['en'])) {
            return $data[$locale] ?? $data['id'] ?? $default ?? '';
        }
        
        // If data is object with properties like 'judul_id' and 'judul_en'
        if (is_object($data) && $field) {
            $fieldId = $field . '_id';
            $fieldEn = $field . '_en';
            
            if ($locale === 'en' && property_exists($data, $fieldEn) && !empty($data->$fieldEn)) {
                return $data->$fieldEn;
            }
            
            if (property_exists($data, $fieldId)) {
                return $data->$fieldId;
            }
            
            if (property_exists($data, $field)) {
                return $data->$field;
            }
        }
        
        // Fallback: return data as is
        return $data ?? $default ?? '';
    }
    
    /**
     * Check if current language is English
     */
    public static function isEnglish()
    {
        return session('locale', 'id') === 'en';
    }
    
    /**
     * Get current language code
     */
    public static function currentLocale()
    {
        return session('locale', 'id');
    }
}