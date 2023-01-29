<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/FileManager/FileManager.php';


class FileForm implements functions_for_model
{
    public function getViewParams($post)
    {
        $output = array("Status" => "OK");
        $output["pageName"] = "FileForm";
        $b = new FileManager();

        $output["files"] = $b->GetList()['list'];
        print_r($post);
        if(!isset($post["fileSend"]))
        {
            return $output;
        }
        if( $post["fileSend"] == "1")
        {
            $status = $b->save($post['userFile'], $post['fileName']);
            $output["saveStatus"] = $status["Status"];
        }

        if( $post["fileSend"] == "2")
        {
            if(in_array($post['fileName'],$output["files"]))
            {
                $status = $b->RemoveFile($post['fileName']);
                $output["removeStatus"] = $status["Status"];
            }
            else
            {
                $output["removeStatus"] = "file don't exist";
            }
        }
        return $output;
    }
}


