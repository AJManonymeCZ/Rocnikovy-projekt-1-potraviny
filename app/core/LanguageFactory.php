<?php

class LanguageFactory
{
    private static Language $language;
    private static array $translations = [];

    public static function setLanguage(?Language $language): void {
        try {
            self::$language = $language ?? Language::getDefaultLanguage();
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage();
            die;
        }
    }

    public static function getLocalized($key): string {
        $languageKey = self::$language->getLanguageKey();
        if (!isset(self::$translations[$key]) || !isset(self::$translations[$key]->$languageKey)) {
            self::loadTranslation($key);
        }

        if (!isset(self::$translations[$key]->$languageKey)) {
            self::saveTranslation($key, '', self::getLanguage());
            self::loadTranslation($key);
        }

        return self::getTranslation($key);
    }

    private static function getTranslation(string $key): string {
        $languageKey = self::$language->getLanguageKey();
        $translation = self::$translations[$key]->$languageKey ?? null;
        return !empty($translation) ? $translation : $key . " language: " . self::$language->getNameOfCountry();
    }

    public static function loadTranslation(string $key): void {
        $translation = new Translation();
        $translationRow = $translation->first(["key" => $key]);

        if ($translationRow) {
            $translationRowVars = get_object_vars($translationRow);
            $languageKey = self::$language->getLanguageKey();
            if (isset($translationRowVars[$languageKey])) {
                self::$translations[$key] = $translationRow;
            }
        }
    }

    public static function getLanguage(): Language {
        return self::$language;
    }

    public static function saveTranslation(string $key, string $translation, Language $language): void {
        $translationClass = new Translation();

        // 1 check in translation table has the column with language key - if not create
        $colums = $translationClass->query("desc " . $translationClass->table);
        $found = false;
        if (!empty($colums)) {
            foreach ($colums as $colum) {
                if ($colum->Field == $language->getLanguageKey()) {
                    $found = true;
                }
            }
        }

        if (!$found) {
            $translationClass->query("alter table  " . $translationClass->table . " add `" . $language->getLanguageKey() . "` text");
        }

        // 2 find the row by key - if the key does not exists create the row
        $translationRow = $translationClass->first(["key" => $key]);
        if (!$translationRow) {
            $translationRow = $translationClass->first(["key" => $translationClass->insert(["key" => $key], true)]);
        }

        if ($translationRow) {
            // 3 update the translation
            $languageKeyForQuery = str_replace("-", "_", $language->getLanguageKey());
            $query = "update " . $translationClass->table .  " set `" . $language->getLanguageKey() . "`=:" . $languageKeyForQuery . " where id =:id";

            $translationClass->query($query, [$languageKeyForQuery => $translation, "id" => $translationRow->id]);
        }

    }
}
