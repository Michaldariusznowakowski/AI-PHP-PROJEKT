<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/FileManager/FileManager.php';
require_once 'php/Model/Database/Floors.php';


class FileForm implements functions_for_model
{
    public function getViewParams($post)
    {
        $output = array("Status" => "OK");
        $output["pageName"] = "FileForm";
        $floorList = Floors::findAll();
        $b = new FileManager();

        $output["files"] = $b->GetList()['list'];
        $floorListArray = [];
        for ($i = 0; $i < count($floorList); ++$i)
        {
            // get floor info for select box
            $tmp = [$floorList[$i]->getFloorNumber(),Buildings::find($floorList[$i]->getBuildingID())->getBuildingNumber(),$floorList[$i]->getFloorID()];
            $floorListArray[] = $tmp;
        }
        $output["floors"] = $floorListArray;

        // print_r($post);
        if(!isset($post["fileSend"]))
        {
            return $output;
        }
        if( $post["fileSend"] == "1" && isset($post['userFile']))
        {

            // save file
            $newFileName = "FloorId_".$post['fileName'];
            $status = $b->save($post['userFile'], $newFileName);

            // add to database
            Floors::find($post['fileName'])->setPhotoUrl($b->getTargetPath().$newFileName.'.'.$b->getFileExtension($post['userFile']))->save();

            $output["saveStatus"] = $status["Status"];
        }
        $output["files"] = $b->GetList()['list'];
        if( $post["fileSend"] == "2" && isset($post['fileName']))
        {
            if(in_array($post['fileName'],$output["files"]))
            {
                $status = $b->RemoveFile($post['fileName']);
                $output["removeStatus"] = $status["Status"];

                for ($i = 0; $i < count($floorList); ++$i)
                {
                    if($output["removeStatus"] == "Removed")
                    {
                        if($floorList[$i]->getPhotoUrl() == $b->getTargetPath().$post['fileName']) 
                        {
                            $floorList[$i]->setPhotoUrl("empty")->save();
                        }
                    } 
                }
            }
            else
            {
                $output["removeStatus"] = "file don't exist";
            }
        }


        return $output;
    }
}


