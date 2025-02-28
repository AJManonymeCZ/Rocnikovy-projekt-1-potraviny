<?php

class Session
{
    public static string $LANGUAGES = "LANGUAGES";
    public static function get(string $key): mixed {
        return $_SESSION[$key] ?? null;
    }

    public static function set(string $key, mixed $data): void {
        try {
            if(!isset($_SESSION[$key])) {
                $_SESSION[$key] = $data;
            } else {
                throw new Exception("The key: " . $key . " already exists in session!");
            }
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage();
            die;
        }
    }

    public static function update(string $key, mixed $newValue): void {
        try {
            if(isset($_SESSION[$key])) {
                $_SESSION[$key] = $newValue;
            } else {
                throw new Exception("The key: " . $key . " does not exists in session!");
            }
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage();
            die;
        }
    }

    public static function showSession() {
        dd($_SESSION);
    }
}