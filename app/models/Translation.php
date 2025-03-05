<?php

class Translation extends Model
{
    public string $table = "translation";
    public array $errors = [];

    protected array $allowedColumns = [
        "id",
        "key",
        "translation",
    ];

    public function validateLanguage($data): bool {
        $this->errors = [];

        if (empty($data['key'])) {
            $this->errors['key'] = LanguageFactory::getLocalized("dashboard.translations.add.error.key");
        } else if (!preg_match("/^[a-z]{2}-[A-Z]{2}$/", $data['key'])) {
            $this->errors['key'] = LanguageFactory::getLocalized("dashboard.translations.add.error.keyPattern");
        }

        if (empty($data['countryCode'])) {
            $this->errors['countryCode'] = LanguageFactory::getLocalized("dashboard.translations.add.error.countryCode");
        } else if (!preg_match("/^[A-Z]{2}$/", $data['countryCode'])) {
            $this->errors['countryCode'] = LanguageFactory::getLocalized("dashboard.translations.add.error.countryCodePattern");
        }

        if (empty($data['country'])) {
            $this->errors['country'] = LanguageFactory::getLocalized("dashboard.translations.add.error.country");
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}