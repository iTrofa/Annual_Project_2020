<?php
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';


abstract class Form
{
    protected array $error;
    protected array $valid;
    protected array $data;
    protected DbManager $dbManager;
    protected ?ImageValidator $validateImage;


    public function __construct(array $post, ?array $file = null, ?string $basePath = null)
    {
        $this->data = $post;
        if ($file !== null && $basePath !== null)
        {
            $this->validateImage = new ImageValidator($file, $basePath);
        } else
        {
            $this->validateImage = null;
        }
        $this->valid = [];
        $this->error = [];
        $this->dbManager = App::getDb();
    }

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

    protected function checkImages(): bool
    {
        $error = $this->validateImage->checkError();
        if ($error !== 'ok')
        {
            $this->addError($error, 'image');
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return false;
        }
        $error = $this->validateImage->checkExt();
        if ($error !== 'ok')
        {
            $this->addError($error, 'image');
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return false;
        }
        $error = $this->validateImage->checkMimeType();
        if ($error !== 'ok')
        {
            $this->addError($error, 'image');
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return false;
        }
        $error = $this->validateImage->checkSize();
        if ($error !== 'ok')
        {
            $this->addError($error, 'image');
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return false;
        }
        $this->validateImage->generateUniqueName();

        $error = $this->validateImage->checkCorrespondingMimetypeExt();
        if ($error !== 'ok')
        {
            $this->addError($error, 'image');
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return false;
        }

        $_SESSION['profilePic'] = $this->validateImage->getFullpath();
        return true;
    }
}