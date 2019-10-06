<?php
require ('DB.class.php');

class File {

    public static function getRandomFileName($path, $extension='')
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';

        do {
            $name = sha1(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));

        return $name;
    }

    public function checkFileName ( ) {

        if (($fileSize = $files[ 'file' ][ 'size' ]) > $this->maxFileSize) {
            return 'SIZE_MAX_LIMIT';
        }


        if (false === $fileExt = array_search(
                ($fileMime = mime_content_type( $files[ 'file' ][ 'tmp_name' ] )),
                $this->availableMimeTypes,
                true
            )
        ) {
            return 'INVALID_FILE_FORMAT';
        }

        public function checkFilename(array $user, string $filename, int $max_summary_length = 1000, int $max_extension_length = 1000): int
        {
            if (($length = mb_strlen($filename, 'UTF-8')) > $max_summary_length) {
                return File::FILE_NAME_TOO_LONG;
            }

            if ($length == 0) {
                return File::FILE_NAME_AND_EXTENSION_EMPTY;
            }

            if (($length - mb_strrpos($filename, '.', 0, 'UTF-8')) > $max_extension_length) {
                return File::FILE_EXTENSION_TOO_LONG;
            }

            $mysql = MySQL::getInstance();
            $r = $mysql->executeQuery("SELECT * FROM `stored_file` WHERE `sf_user`=:user_id AND `sf_source_name`=:source_name",
                array(array(':user_id', $user['u_id'], 'integer'), array(':source_name', $filename, 'string')));
            if ($r['rows'] > 0) {
                return File::FILE_ALREADY_EXISTS;
            }

            return File::FILE_NAME_AND_EXTENSION_OK;
        }
// Deletes the file.
        public function deleteFile(array $user, string $file_id, string $root_folder): int
        {
            $mysql = DB::getInstance();
            $r = $mysql->executeQuery("SELECT * FROM `stored_file` WHERE `sf_user`=:user_id AND `sf_id`=:file_id", array(array(':user_id', $user['u_id'], 'integer'), array(':file_id', $file_id, 'integer')));
            if ($r['rows'] !== 1) {
                return File::FILE_RESULT_NOT_DELETED;
            }

            $row = $r['stmt']->fetch(PDO::FETCH_ASSOC);

            // Try always use full file names for security and reliability reasons.
            $ffn = $root_folder . '/' . $user['u_homedir'] . '/' . $row['sf_store_name'];

            // We can not delete nonexisting files.
            if (is_file($ffn)) {
                $mysql->executeQuery("DELETE FROM `stored_file` WHERE `sf_user`=:user_id AND `sf_id`=:file_id",
                    array(array(':user_id', $user['u_id'], 'integer'), array(':file_id', $file_id, 'integer')));
                unlink($ffn);
                return File::FILE_RESULT_DELETED;
            } else {
                return File::FILE_RESULT_NOT_DELETED;
            }
        }

    }

    public function deleteFiles($files)
    {
        foreach ($files as $file => $value) {
            if (file_exists($value)) {
                unlink($value);

                $files= array();
                $dir = dir('files');
                while (($file = $dir->read()) !== false) { // You must supply a condition to avoid infinite looping
                    if ($file != '.' && $file != '..') {
                        $files[] = $file; // In this array you push the valid files in the provided directory, which are not (. , ..)
                    }
                    unlink('files/'.$file); // This must remove the file in the queue
                }
            }
        }


        $pdo_statement = $pdo->prepare("delete from posts where id=" . $_GET['id']);
        $pdo_statement->execute();
        header('location:index.php');

    }


    function uploadWithCURl () {
        $this->ch;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// if https
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
// or set this option
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);

        $error = curl_error($ch);
        $file = $data = curl_exec($ch);
        curl_close($ch);
        if (file_exists($file)) {
            header("Content-Type: audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3");
            header('Content-Disposition: attachment; filename="sometrack.mp3"');
            header("Content-Transfer-Encoding: binary");
            header('Content-length: ' . filesize($file));
            header('X-Pad: avoid browser bug');
            header('Cache-Control: no-cache');
            readfile($file);
        } else {
            echo "no file";
        }
        return $this;

    }

}