<?php


class Form
{
    protected array $error;
    protected array $valid;
    protected array $data;
    /**
     * @param string $errorString
     * @param string $field
     */
    protected function addError(string $errorString, string $field): void
    {
        $this->error[$field] = $errorString;
    }

    protected function addValid(string $field): void
    {
        $this->valid[$field] = $this->data[$field];
    }
    /**
     * @param $field
     */
    protected function validateName($field): void
    {
        $this->data[$field] = ucfirst($this->data[$field]);

        if (!ctype_alpha( $this->data[$field] ))
        {
            $your = _('your');
            $letters = _('can only contain letters');
            $this->addError("$your {$field} $letters", $field);
            $this->valid[$field] = '';
        } else
        {
            $this->addValid($field);
        }

    }
}