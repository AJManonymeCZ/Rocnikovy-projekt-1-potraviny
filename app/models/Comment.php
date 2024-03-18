<?php

class Comment extends Model
{
    public $errors = [];
    protected $table = "comment";

    protected $allowedColumns = [
        'id',
        'content',
        'likes',
        'date_created',
        'product_id',
        'user_id',
        'parent_id',
    ];

    public function validate($data)
    {
        $this->errors = [];
        if (!empty($data)) {
            if (empty($data['content'])) {
                $this->errors['content'] = "A comment is required";
            } else if (!preg_match("/^[a-zA-Z0-9?áéíóúýčďěřšťžů\. ]+$/", trim($data['content']))) {
                $this->errors['content'] = "Comment can only have letters, spases, . and ?";
            }

            if (!empty($data['likes'])) {
                if(!preg_match("/^[0-9]+$/"))
                $this->errors['likes'] = "Not valid number (likes)";
            }

            if (empty($this->errors)) {
                return true;
            }
        }
        return false;
    }

    public function calc_date($comment) {
        try {
            $curr_date = new DateTime(date("Y-m-d H:i:s"));
            $comment_date = new DateTime($comment->date_created);
            $difference =  $curr_date->diff($comment_date);

            $date_string = "";
            if($difference->y > 0) {
                if($difference->y == 1)
                    $date_string = "Před " . $difference->y . " rokem";
                else
                    $date_string = "Před " . $difference->y . " lety";
            } else if ($difference->m > 0) {
                if($difference->m == 1)
                    $date_string = "Před " . $difference->m . " měsícem";
                else
                    $date_string = "Před " . $difference->m . " měsici";
            } else if ($difference->d > 0) {
                if($difference->d == 1)
                    $date_string = "Před " . $difference->d . " dnem";
                else
                    $date_string = "Před " . $difference->d . " dny";
            } else if ($difference->h > 0) {
                if($difference->h == 1)
                    $date_string = "Před " . $difference->h . " hodinou";
                else
                    $date_string = "Před " . $difference->h . " hodinami";
            } else if ($difference->i > 0) {
                if($difference->i == 1)
                    $date_string = "Před " . $difference->i . " minutou";
                else
                    $date_string = "Před " . $difference->i . " minuty";
            } else if ($difference->s > 0) {
                if($difference->s == 1)
                    $date_string = "Před " . $difference->s . " vteřinou";
                else
                    $date_string = "Před " . $difference->s . " vteřinami";
            }

            $comment->diff_date = $date_string;
        } catch (Exception $e) {
            $comment->diff_date = '';
        }

        return $comment;
    }
}
