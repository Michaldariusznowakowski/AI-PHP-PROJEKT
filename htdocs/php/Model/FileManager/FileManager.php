<?php
class FileManager{
    // SETTINGS
    private $TARGET_PATH = 'resources/img/';
    private $allowedExtensions = ["png","jpg","jpeg","svg"];
    public function getTargetPath()
    {
        return $this->TARGET_PATH;
    }
    public function setTargetPath($path)
    {
        $this->TARGET_PATH = $path;
    }

    public function getFileExtension($file)
    {
        $info = pathinfo($file['name']);
        $extension = $info['extension'];
        return $extension;
    }
    // save file
    public function save($file, $name)
    {
        // userFile = nazwa pliku w formularzu
        $info = pathinfo($file['name']);
        $extension = $info['extension'];

        $output = array("Status" => "Working");
        // jak rozszerzenie dozwolone
        if(in_array(strtolower($extension), $this->allowedExtensions))
        {
            // ustaw nowa nazwe
            $newname = $name .'.'.$extension;

            // ustaw cel do zapisania
            $target = $this->TARGET_PATH . $newname;

            // zapisz plik
            $status = move_uploaded_file($file['tmp_name'], $target);

            // jak false to nie zapisane
            if(!$status)
            {
                $output["Status"] = "Failed";
            }
            else
            {
                $output["Status"] = "Saved";
            }
        }
        return $output;
    }

    public function GetList()
    {
        // return files
        $files = scandir($this->TARGET_PATH);
        // if(count($files) > 2)
        // {
        //     // we remove first to directories (. and ..)
        //     unset($files[0]);
        //     unset($files[1]);
        // }
        $output = array("Status" => "OK");
        $output["list"] = array();
    
        for($i = 0; $i < count($files); ++$i)
        {
            $output["list"][] = $files[$i];
        }
        return $output;
    }

    public function RemoveFile($name)
    {
        $status = unlink($this->TARGET_PATH . $name);
        $output = array("Status" => "");
        if($status)
        {
            $output["Status"] = "Removed";
        }
        else
        {
            $output["Status"] = "Couldn't Remove The file";
        }
        return $output;

    }
}

// przykład formularza:
    // <form action='' method="POST" enctype="multipart/form-data">
    // <input type='file' name='userFile'><br />
    // <input type='submit' name="upload_btn" value='save'>
    // </form>

// // delete
// if($operation == 2)
// {
//     $name = $_POST['fileName'];
//     $status = unlink($TARGET_PATH . $name);
//     $output = array("Status" => "");
//     if($status)
//     {
//         $output["Status"] = "OK";
//     }
//     else
//     {
//         $output["Status"] = "NOT_OK";
//     }
//     return $output;
// }

// // return files
// if($operation == 3)
// {
//     $files = scandir($TARGET_PATH);
//     if(count($files) > 2)
//     {
//         // we remove first to directories (. and ..)
//         $unset($files[0]);
//         $unset($files[1]);
//     }

//     $output = array("Status" => "");
//     $output["list"] = array();
 
//     for($i = 0; $i < count($files); ++$i)
//     {
//         $output["list"][] = $files[$i];
//     }
//     return $output;
// }




