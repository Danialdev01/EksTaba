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

    // $prompt = "Hasilkan satu ayat bahasa melayu ringkas tak melebihi 10 patah perkataan. Kaitkan ayat tersebut dengan tema \"$tema\" dan pastikan ayat berikut mesti menggunakan '$tanda_baca'. Jangan beri apa-apa pendahuluan dan hanya tulis ayat yang dihasilkan.  Sekiranya ia merupakan sebuah dialog, letak petikan berganda untuk menandakan ia merupakan dialog. Pastikan tatabahasa ayat tersebut tepat menggunakan bahasa melayu.";
    $prompt = 'Act as a Malay language expert. Generate a **single, grammatically correct Malay sentence** that meets these criteria:
                1. Theme: '.$tema.'
                2. Must include the punctuation '. $tanda_baca .' (placed correctly without spaces before it)
                3. Surround the sentence with double quotes "like this"
                4. Use proper capitalization and contextually appropriate punctuation
                5. Prioritize common vocabulary related to the theme
                5. Check the words used in the the sentence
                6. Make sure the sentence is easy to understand

                7. Make sure the sentence is not a question if the punctuation is a . or ! or , 
                8. If the punctuation is a ? then make sure the sentence is a question
                9. If the punctuation is a ! then make sure the sentence is something suprising  
                9. If the punctuation is a , then make sure its not at the end of the sentence. Make sure the sentence with , is used correctly 

                Do no include '.$jawapan_salah_1.' or '. $jawapan_salah_2.' or '. $jawapan_salah_3.'

                Avoid these mistakes:
                - Extra spaces before punctuation (e.g., "ini ?" → wrong, "ini?" → correct)
                - Incorrect title casing (e.g., "hari guru" → wrong, "Hari Guru" → correct)
                - Unnatural/forced punctuation placement

                

                Examples of valid outputs:
                "Kamu sudah membeli kuih raya untuk rumah terbuka nanti?"
                "Kitar semula sisa plastik, kaca, dan kertas demi alam sekitar!"
                "Murid-murid menyanyikan lagu "Tanggal 31 Ogos" sempena Hari Merdeka."
                "Kamu akan beraya di mana tahun ini ?"
                "Siti, aisha dan sara akan pergi ke kedai."
                "Kita akan menang sekali lagi!"

                Lastly only output the sentence. Do not explain or add anything not related. Just output the sentence generate. 
            ';

    $prompt_output = generateAI($prompt, $ai_api_key);
    $content = json_decode($prompt_output, true);
    $ayat = $content['choices'][0]['message']['content'];
    // $ayat = "Ini adalah ayat Contoh";
    $ayat = str_replace($tanda_baca, '_', $ayat);

    $new_soalan_sql = $connect->prepare("INSERT INTO soalan(id_soalan, id_kuiz, teks_soalan, gambar_soalan, jawapan_soalan, jenis_soalan, markah_soalan) VALUES (NULL, ? , ? , ? , ? , ? , 1)");
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