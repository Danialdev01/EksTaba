<?php

function createNota($id_kelas, $id_guru, $tajuk_nota, $teks_nota, $connect){

    $kod_kuiz = "K". randomKod(5);

    $id_kelas = validateInput($id_kelas);
    $id_guru = validateInput($id_guru);
    $tajuk_nota = validateInput($tajuk_nota);
    $teks_nota = validateInput($teks_nota);
    $created_date_nota = date("Y-m-d");
    
    $new_nota_sql = $connect->prepare("INSERT INTO nota(id_nota, id_kelas, id_kuiz, id_guru, tajuk_nota, teks_nota, gambar_nota, audio_nota, created_date_nota, status_nota) VALUES (NULL, ? , NULL , ? ,  ?  , ? , NULL , NULL , ? , 1)");

    $new_nota_sql->execute([
        $id_kelas,
        $id_guru,
        $tajuk_nota,
        $teks_nota,
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

function addImageNota($id_nota, $file, $destination, $connect){

    $upload_file = uploadFile($file, $destination);

    if($upload_file['status'] == "success"){

        $file_destination = $upload_file['destination'];
        
        $image_nota_sql = $connect->prepare("UPDATE nota SET gambar_nota = ? WHERE id_nota = ?");

        $image_nota_sql->execute([
            $file_destination,
            $id_nota
        ]);

    }

}

function addAudioNota($id_nota, $file, $destination, $connect){

    $upload_file = uploadFile($file, $destination);

    if($upload_file['status'] == "success"){

        $file_destination = $upload_file['destination'];
        
        $audio_nota_sql = $connect->prepare("UPDATE nota SET audio_nota = ? WHERE id_nota = ?");

        $audio_nota_sql->execute([
            $file_destination,
            $id_nota
        ]);

    }

}


?>