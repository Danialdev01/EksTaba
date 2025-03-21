<?php

function uploadFile($file, $type_destination){

    if($file["name"] != NULL || $file["name"] != ""){
    
        //* File is not found
        if($file["error"] === 4){

            alert_message("error", "File not found");
            // header("location:../user/.php");
        }

        else{

            //* Identify file extention
            $fileName = $file["name"];
            $fileSize = $file["size"];
            $TmpName = $file["tmp_name"];
            $validImageExtension = ['jpg', 'png', 'mp3', 'wav'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            //* Wrong file extention
            if(!in_array($imageExtension, $validImageExtension)){

                alert_message("error", "File type not valid");
                // header("location:../user/upload.php");               
            }

            else{
                //* Image is correct
                $newImageName = uniqid();
                $newImageName .= '.' . $imageExtension;
                $destination = __DIR__ . "/../uploads/" . $type_destination . "/" . $newImageName;
                move_uploaded_file($TmpName, $destination);

                $status = encodeObj("200", "Berjaya Tambah Kelas", "success");
                $file = [
                    "FileName" => $newImageName,
                    "destination" => $destination,
                    "extention" => $imageExtension
                ];
                $file = json_encode($file);

                return addJson($status, $file);

            }
        }
    }
    else{

        $status = encodeObj("400", "File tidak sah", "error");

    }

}

?>