<?php

function createKuiz($nama_kuiz, $pengenalan_kuiz, $jenis_kuiz, $id_kelas, $id_guru, $tarikh_tamat_kuiz, $connect){

    $kod_kuiz = "K". randomKod(5);

    $nama_kuiz = validateInput($nama_kuiz);
    $pengenalan_kuiz = validateInput($pengenalan_kuiz);
    $jenis_kuiz = validateInput($jenis_kuiz);
    $id_kelas = validateInput($id_kelas);
    $id_guru = validateInput($id_guru);
    $tarikh_tamat_kuiz = NULL;
    $created_date_kuiz = date("Y-m-d");
    
    $new_kuiz_sql = $connect->prepare("INSERT INTO kuiz(id_kuiz, kod_kuiz, nama_kuiz, pengenalan_kuiz, jenis_kuiz, id_kelas, id_guru, tarikh_tamat_kuiz, created_date_kuiz, status_kuiz) VALUES (NULL, ? , ? , ? , ? , ? , ? , ? , ? ,1)");

    $new_kuiz_sql->execute([
        $kod_kuiz,
        $nama_kuiz,
        $pengenalan_kuiz,
        $jenis_kuiz,
        $id_kelas,
        $id_guru,
        $tarikh_tamat_kuiz,
        $created_date_kuiz
    ]);

    $id_kuiz = $connect->lastInsertId();
    $status = encodeObj("200", "Berjaya Tambah Kelas", "success");
    $kuiz = [
        "id_kuiz" => $id_kuiz,
        "kod_kuiz" => $kod_kuiz,
        "id_guru" => $id_guru,
        "id_kelas" => $id_kelas,
        "jenis_kuiz" => $jenis_kuiz,
        "pengenalan_kuiz" => $pengenalan_kuiz
    ];

    $kuiz = json_encode($kuiz);
    return addJson($status, $kuiz);
}
?>