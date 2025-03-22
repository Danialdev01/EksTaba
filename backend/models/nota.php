<?php

function createNota($id_kelas, $id_guru, $tajuk_nota, $teks_nota, $image, $audio, $connect){

    $kod_kuiz = "K". randomKod(5);

    $id_kelas = validateInput($id_kelas);
    $id_guru = validateInput($id_guru);
    $tajuk_nota = validateInput($tajuk_nota);
    $teks_nota = validateInput($teks_nota);
    $created_date_nota = date("Y-m-d");
    
    $new_nota_sql = $connect->prepare("INSERT INTO nota(id_nota, id_kelas, id_kuiz, id_guru, tajuk_nota, teks_nota, gambar_nota, audio_nota, created_date_nota, status_nota) VALUES (NULL, ? , NULL , ? ,  ?  , ? , ? , ? , ? , 1)");

    $new_nota_sql->execute([
        $id_kelas,
        $id_guru,
        $tajuk_nota,
        $teks_nota,
        $image,
        $audio,
        $created_date_nota
    ]);

    $id_nota = $connect->lastInsertId();
    $status = encodeObj("200", "Berjaya Tambah Nota", "success");
    $nota = [
        "id_nota" => $id_nota,
        "id_kelas" => $id_kelas,
        "id_guru" => $id_guru,
        "tajuk_nota" => $tajuk_nota,
        "teks_nota" => $teks_nota
    ];

    $nota = json_encode($nota);
    return addJson($status, $nota);
}

function addImageNota($file, $destination, $connect){

    try{
        $upload_file = uploadFile($file, $destination);
        $file = json_decode($upload_file, true);
        return $file['FileName'];

    }
    catch(Exception $e){
        var_dump($e);
    }


}

function addAudioNota($file, $destination, $connect){

    try{
        $upload_file = uploadFile($file, $destination);
        $file = json_decode($upload_file, true);
        return $file['FileName'];

    }
    catch(Exception $e){
        var_dump($e);
    }

}


?>