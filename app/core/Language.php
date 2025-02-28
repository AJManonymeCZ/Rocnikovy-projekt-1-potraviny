<?php

class Language
{
    private string $languageKey;
    private string $countryCode;
    private string $nameOfCountry;
    /** @var Language[] */
    public static array $languages = [];

    function __construct(string $languageKey, string $countryCode, string $nameOfCountry)
    {
        $this->languageKey = $languageKey;
        $this->countryCode = $countryCode;
        $this->nameOfCountry = $nameOfCountry;
        Language::$languages[] = $this;
    }

    public static function init(): void {
        $lang = new Lang();
        foreach ($lang->findAll() as $language) {
            new Language($language->key, $language->countryCode, $language->country);
        }
    }

    /**
     * @throws Exception
     */
    public static function getDefaultLanguage(): Language {
        if (isset(self::$languages) && count(self::$languages) > 0) {
            if (count(self::$languages) == 1) {
                return self::$languages[0];
            } else {
                foreach (self::$languages as $language) {
                    if ($language->getLanguageKey() == "cs-CZ") {
                        return $language;
                    }
                }
            }
        }
        throw new Exception("Error no language selected - method: getDefaultLanguage" );
    }

    public function getLanguageKey(): string {
        return $this->languageKey;
    }

    public function getCountryCode(): string {
        return $this->countryCode;
    }

    public function getNameOfCountry(): string {
        return $this->nameOfCountry;
    }
}
