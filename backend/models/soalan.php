<?php 

function SoalanObjectiveAI($id_kuiz, $ai_api_key, $tema, $connect){

    // pilih random punctuation
    $pilihan = rand(1, 4);

    if($pilihan == 1){
        $tanda_baca = ".";
        $jawapan_salah_1 = ",";
        $jawapan_salah_2 = "?";
        $jawapan_salah_3 = "!";
    }
    else if($pilihan == 2){
        $tanda_baca = ",";
        $jawapan_salah_1 = ".";
        $jawapan_salah_2 = "?";
        $jawapan_salah_3 = "!";
    }
    else if($pilihan == 3){
        $tanda_baca = "?";
        $jawapan_salah_1 = ".";
        $jawapan_salah_2 = ",";
        $jawapan_salah_3 = "!";
    }
    else {
        $tanda_baca = "!";
        $jawapan_salah_1 = ".";
        $jawapan_salah_2 = ",";
        $jawapan_salah_3 = "?";
    }

    $prompt = "Hasilkan satu ayat bahasa melayu ringkas tak melebihi 10 patah perkataan. Kaitkan ayat tersebut dengan tema \"$tema\" dan pastikan ayat berikut mesti menggunakan '$tanda_baca'. Jangan beri apa-apa pendahuluan dan hanya tulis ayat yang dihasilkan.  Sekiranya ia merupakan sebuah dialog, letak petikan berganda untuk menandakan ia merupakan dialog. Pastikan tatabahasa ayat tersebut tepat menggunakan bahasa melayu.";

    $prompt_output = generateAI($prompt, $ai_api_key);
    $content = json_decode($prompt_output, true);
    $ayat = $content['choices'][0]['message']['content'];
    // $ayat = "Ini adalah ayat Contoh";

    $new_soalan_sql = $connect->prepare("INSERT INTO soalan(id_soalan, id_kuiz, teks_soalan, gambar_soalan, audio_soalan, jenis_soalan, markah_soalan) VALUES (NULL, ? , ? , ? , ? , ? , 1)");
    $new_soalan_sql->execute([
        $id_kuiz,
        $ayat,
        NULL,
        NULL,
        1
    ]);
    
    $id_soalan = $connect->lastInsertId();
    
    // buat obj untuk skema jawapan nak simpan jawapan betul dan salah 
    $jawapan = [
        "id_soalan" => $id_soalan,
        "jawapan_betul" => $tanda_baca,
        "jawapan_salah_1" => $jawapan_salah_1,
        "jawapan_salah_2" => $jawapan_salah_2,
        "jawapan_salah_3" => $jawapan_salah_3
    ];
    $teks_jawapan = json_encode($jawapan);
    
    // tambah skema jawapan 
    $jawapan_soalan_kuiz_sql = $connect->prepare("INSERT INTO skema_jawapan(id_jawapan, id_soalan, teks_jawapan, gambar_jawapan, audio_jawapan, penentu_jawapan) VALUES (NULL , ? , ? , ? , ? , 1)");
    $jawapan_soalan_kuiz_sql->execute([
        $id_soalan,
        $teks_jawapan,
        NULL,
        NULL
    ]);

    $status = encodeObj("200", "Berjaya log masuk murid", "success");
    
    $soalan = [
        "id_soalan" => $id_soalan,
        "id_kuiz" => $id_kuiz,
        "teks_soalan" => $ayat,
    ];
    
    $soalan = json_encode($soalan);
    return addJson($status, $soalan);

}



?>