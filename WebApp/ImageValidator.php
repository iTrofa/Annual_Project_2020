<?php
require_once 'DbManager.php';

class ImageValidator
{
    private array $data;
    private array $exts = ['png', 'jpeg', 'jpg'];
    private array  $mimetype = ['image/png','image/jpeg'];
    private int $maxsize = 4194304;
    private string $basePath;
    private string $fullpath;
    private DbManager $db;
    private string $ext;

    public function __construct(array $file, string $basePath)
    {
        $this->db = new DbManager();
        $this->data = $file;
        $this->ext =  pathinfo ($_FILES['image']['name'],PATHINFO_EXTENSION);
        $this->basePath = $basePath;
    }

    public function checkError():string
    {
        if (isset($_FILES) && $this->data['image']['error'] === 0)
        {
            return 'ok';
        }
        return $this->codeToMessage($this->data['image']['error']);
    }

    public function checkExt(): string
    {
        if (!in_array($this->ext, $this->exts, true))
        {
            return 'the extension is not png or jpeg';
        }
        return 'ok';
    }

    public function checkmimeType(): string
    {
        $mimetype = mime_content_type($this->data['image']['tmp_name']);
        if (!in_array($mimetype, $this->mimetype, true))
        {
            return "the mimetype doesn\'t correspond to png or jpeg: {$mimetype}";
        }
        return 'ok';
    }

    public function checkCorresopdingmimtypeExt():string
    {
        if (strpos(mime_content_type($this->data['image']['tmp_name']),$this->ext) === false) {
                return 'the type content doesn\'t correspond with the extensions';
        }
        return 'ok';

    }

    public function checkSize(): string
    {
        if ($_FILES['image']['size'] > $this->maxsize)
        {
            return 'fichier trop volumineux';
        }
        return 'ok';
    }

    public function generateUniqueName(): void
    {
        $id = sha1(uniqid('ok', true));
        $name = $id . '.' . strtolower($this->ext);
        $this->fullpath = $this->basePath . $name;
    }

    /**
     * @param string|null $deleteQuery query for delete old image like 'select profilePic from person where id = ?'
     * @param string $updateQuery query for add new image 'UPDATE person SET profilePic=? where idPerson=?
     */
    public function updateImage(string $deleteQuery  = null, string $updateQuery = null): void
    {
        if ($deleteQuery!==null)
        {
            $q = $this->db->getDb()->prepare($deleteQuery);
            $q->execute([$_SESSION['id']]);
            $oldPath = $q->fetch();
            unlink($oldPath['profilePic']);
        }
        if ($deleteQuery!==null)
        {
            $q = $this->db->getDb()->prepare($updateQuery);
            $q->execute([$this->fullpath, $_SESSION['id']]);
        }
    }

    public function uploadImage():string {

        if (move_uploaded_file($this->data['image']['tmp_name'],  $this->fullpath )) {
            http_response_code(201);
            return 'ok';
        }
        http_response_code(503);
        return 'can\'t upload image technical error ';

    }

    private function codeToMessage($code): string
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = 'The uploaded file exceeds the upload_max_filesize';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'The uploaded file was only partially uploaded';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = 'No file was uploaded';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Missing a temporary folder';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Failed to write file to disk';
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = 'File upload stopped by extension';
                break;

            default:
                $message = 'Unknown upload error';
                break;
        }
        return $message;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @return string fullPath of the image for example '/images/services/id.ext'
     */
    public function getFullpath(): string
    {
        return $this->fullpath;
    }
}