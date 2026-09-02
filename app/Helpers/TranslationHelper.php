<?php

namespace App\Helpers;

class TranslationHelper
{
    /**
     * Get translated text berdasarkan locale
     */
    public static function get($model, $field, $default = null)
    {
        $locale = session('locale', 'id');
        
        // Jika bahasa Inggris dan ada kolom _en
        if ($locale === 'en') {
            $enField = $field . '_en';
            if (isset($model->$enField) && !empty($model->$enField)) {
                return $model->$enField;
            }
        }
        
        // Fallback ke field default
        return $model->$field ?? $default;
    }
    
    /**
     * Get translated text untuk array data
     */
    public static function getArray($data, $field, $default = null)
    {
        $locale = session('locale', 'id');
        
        if (is_array($data) && isset($data[$field . '_' . $locale])) {
            return $data[$field . '_' . $locale];
        }
        
        return $data[$field] ?? $default;
    }
    
    /**
     * Cek apakah bahasa Inggris
     */
    public static function isEnglish()
    {
        return session('locale', 'id') === 'en';
    }
    
    /**
     * Get current locale
     */
    public static function locale()
    {
        return session('locale', 'id');
    }
}