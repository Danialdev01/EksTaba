<?php

function createKelas($id_guru, $tajuk_kelas, $info_kelas, $connect){

    $tajuk_kelas = validateInput($tajuk_kelas);
    $info_kelas = validateInput($info_kelas);

    $kod_kelas = randomKod(5);
    $created_date_kelas = date("Y-m-d");

    $create_kelas_sql = $connect->prepare("INSERT INTO kelas(id_kelas, kod_kelas, id_guru, tajuk_kelas, info_kelas, created_date_kelas, status_kelas) VALUES (NULL, ? , ? , ? , ? , ? , 1)");

    $create_kelas_sql->execute([
        $kod_kelas,
        $id_guru,
        $tajuk_kelas,
        $info_kelas,
        $created_date_kelas
    ]);

    $id_kelas = $connect->lastInsertId();

    $status = encodeObj("200", "Berjaya Tambah Kelas", "success");
    $kelas = [

        "id_kelas" => $id_kelas,
        "kod_kelas" => $kod_kelas,
        "id_guru" => $id_guru,
        "tajuk_kelas" => $tajuk_kelas
    ];

    $kelas = json_encode($kelas);
    return addJson($status, $kelas);
}
?>