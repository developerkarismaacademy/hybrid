<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"RatingGenerate.csv\"");
$i = 1;
foreach($mapel["data"] as $valueMapel){
    foreach($user["data"] as $valueUser){
        $nomor = rand(1,10);$yesno = ($nomor / 10) > 0.3;
        if($yesno){
            $rate = rand(3,5);
            $ulasan = [
                3=>[
                    "'".$valueMapel["nama_kelas"]." adalah pilihan pertama saya saat mencari kursusonline.org, saya akan coba kursus lain untuk menunjang skill saya...",
                    "Top markotop pokoknya",
                    "Kursus online memiliki potensi, namun dalam kursus '".$valueMapel["nama_kelas"]."' ini masih belum mendapatkan materi yang memuaskan. Semoga kedepannya lebih berkembang. Sukses terus Kursus Online",
                    "Mantap deh",
                    "Dari saya pribadi cukup menyenangkan, hanya saja saya kurang mengambil banyak kursus jadi penjelasannya perlu ditambahkan lagi, terima kasih untuk Kursus Online. Good Luck",
                    "Bintang 3, sukses terus Karisma",
                    "Aku sangat merekomendasikan kursus online, aku sudah pernah mengikuti kelas Online di kursus online lebih dari 5 kelas. Saking bagusnya kelas Online di kursus online, aku saranin kamu juga untuk gabung.",
                    "Sip, bisa minta kursus lain lagi",
                    "Materi yang diajarkan cukup bagus. Dimulai dari dasar sampai yang lebih kompleks. Soal yang diberikan cukup susah sehingga membuat saya harus berpikir. Hal itu meningkatkan kemampuan saya dalam menyelesaikan masalah dalam materi ".$valueMapel["nama_kelas"].". Cara mengajarnya cukup enak. Instruksi di video cukup jelas namun tetap luwes.",
                    "Materi dan cara mengajarnya bagus, sesuai dengan yang diinginkan. Banyak pengalaman baru yang ternyata dapat dilakukan melalui komputer",
                    "Alhamdulillah, dengan kursus yang saya dapatkan ini, saat ini saya sudah mengembangkan ke ranah yang lebih luas.. Padahal materi kursus belum selesai, hehe..",
                    "Perkenalkan nama saya ".$valueUser['nama_user'].", alasan saya kursus online disini karena menurut saya karisma academy adalah tempat yang pas untuk saya belajar ".$valueMapel["nama_kelas"].". Saya mengerti Kursus Online ini dari teman satu kosan. Kesan selama belajar disini adalah instrukturnya tau apa yang kita mau, petugasnya baik dan juga fasilitas yang diberikan sangat istimewa dan harganya juga terjangkau."
                    ],
                4=>[
                    "Ternyata dalam pembelajaran '".$valueMapel["nama_kelas"]."' saya memiliki pengalaman yang tidak saya dapatkan dalam belajar secara otodidak, instrukturnya ramah, mampu memberikan saya banyak tantangan serta kemampuan dalam berpikir kritis. Salut untuk Karisma Academy",
                    "Salut, bagus banget buat pemula",
                    "Aku efektif belajar di Kursus Online saat melamar kerja. Dan bener, terasa bedanya, setelah belajar di sana jadi lebih sering mendapat panggilan kerja. Malahan aku lebih mudah ngertinya dengan adanya video penjelasan, jadi bikin belajar tambah semangat.",
                    "Terima kasih sudah membantu saya belajar",
                    "Sip mantap",
                    "Di Kursus Online saya mengambil kursus '".$valueMapel["nama_kelas"]."' Kursus disini itu programnya enak karena kelasnya fleksibel bisa disesuaikan dengan jadwal perkuliahan saya. Jadi kalo ada bentrok jadwal jamnya bisa diganti sesuai jadwal saya sehingga saya tetap bisa mengikuti kuliah dengan baik.",
                    "Menurut saya program ini sudah sangat baik dan sangat efektif, terlebih bagi saya yang pada saat awal ikut kursus masih bekerja, sehingga tidak memiliki banyak waktu.",
                    "Kesan selama mengikuti kursus ".$valueMapel["nama_kelas"]." adalah pengajar yang sangat kompeten dalam menjelaskan semua materi secara detail dan terstruktur, sehingga mudah dipahami oleh saya. Selain mendapatkan ilmu yang diberikan selama kursus, kami juga mendapatkan fasilitas konsultasi, sehingga pembelajaran bisa lancar dan banyak info tambahan yang saya dapat. Kursus Online merupakan tempat kursus yang sangat recommended bagi siswa seperti saya yang ingin memahami materi ".$valueMapel["nama_kelas"]." secara lebih detail.",
                    "Asik belajar disini..videonya OK..tunggu kedatangan saya untuk tahap selanjutnya yaaa..",
                    "Rujukan terbaik utk belajar ".$valueMapel["nama_kelas"].". Materinya Aplikatif banget. Terimakasih Kursus Online. Sukses Karisma Academy.",
                    "Di Kursus Online, saya diajarkan untuk berani mencoba, jangan takut salah. Yang penting action. Dalam mengajar sangat enjoy tapi serius, step by step. Jadi kita tidak perlu takut/sungkan jika tanya-tanya ke instruktur. Belajar IT di Kursus Online saja, untuk masa depan kita yang cemrlang.",
                    "planner nya bagus materinya tertata sukses terus buat karisma",
                    "Saya memilih kursus Online karena instruktur sudah saya kenal dan saya juga banyak mengenal instruktur di Kursus Online yang bagus. Saya juga ingin mendalami lebih dalam tentang  ".$valueMapel["nama_kelas"].", karena saya berfikir kedepannya  ".$valueMapel["nama_kelas"]." akan menjadi hobi saya yang paling menantang.",
                    "kesan saya untuk belajar di Karisma ini cocok sekali karena saya dapat membuktikan sendiri dengan beberapa pertemuan saja tapi saya bisa dikatakan telah paham permasalahan dan juga kendala yang saya hadapi selama menerapkannya. saya sudah kursus 3x pada materi yang sama di tempat lain tetapi baru cocok dan bisa setelah saya kursus di Kursus Online. terima kasih kepada karisma Academy kemungkinan besar saya akan mengambil program2 yang lain, terima kasih",
                    ],
                5=>[
                    "Memang benar saran dari teman saya, untuk kursus disini khususnya '".$valueMapel["nama_kelas"]."', tepat sekali dengan gaya belajar saya dan bisa saya pelajari sewaktu-waktu. Terima kasih Kursus Online",
                    "Tidak mengecewakan, saya akan belajar materi lainnya juga",
                    "Super sekali, sangat membantu dan memberikan layanan yang baik",
                    "Menurutku kelas ".$valueMapel["nama_kelas"]." ini sangat menarik dan informatif banget. Aku suka sama penyampaian, videonya yang singkat, padat dan jelas. Instruktur yang banyak memberikan referensi juga membantu banyak dalam pelatihan ini. ",
                    "Nama saya adalah ".$valueUser['nama_user']." seorang siswa yang berspesialisasi dalam program 'Kursus Online' dan saya sangat merekomendasikannya! Program pelatihan di sini selama ini sama seperti yang saya harapkan. Saya pasti akan mendaftar lagi.",
                    "Penjelasan di video tutorial Kursus Online sangat jelas, runut dan mudah dimengerti, bahkan oleh saya yang baru masuk ke dunia ".$valueMapel["nama_kelas"].".",
                    "Kalau rating bintangnya 6 pasti saya kasih 6, gurunya sangat pandai menguasai materinya, manajemen waktunya bagus sehingga semua materi bisa disampaikan. Terima kasih Kursus Online telah memenuhi harapan saya",
                    "Sangat direkomendasikan untuk belajar ".$valueMapel["nama_kelas"],
                    "Hallo... nama saya ".$valueUser['nama_user'].". Di Kursus Online ini Saya mengambil kursus ".$valueMapel["nama_kelas"].". Dari Kursus Online saya cukup mendapatkan pengalaman dari materinya. Yang disampaikan to the point yaitu langsung mengarah pada permasalahan yang kita inginkan. Jadi, saya berharap bahwa banyak yang mau kursus di Kursus Online karena materinya tidak bertele-tele.",
                    "Di kursus online ini saya mengambil kursus ".$valueMapel["nama_kelas"].". Untuk video materinya sangat bagus, sangat update sehingga bisa langsung saya aplikasikan ke pekerjaan saya nanti",
                    ]
            ];
            $date=date_create(rand(2019,2020)."-".rand(1,7)."-".rand(1,28)." ".rand(8,22).":".rand(0,59));
            $datenya = date_format($date,"Y-m-d H:i:s");
            $ulasRand = array_rand($ulasan[$rate],1);
            $ulasRand = $ulasan[$rate][$ulasRand];
            ?><?=$valueUser["id_user"]?>,"<?=$valueMapel["id_mapel"]?>","<?=$datenya?>","<?=$rate?>","<?=$ulasRand?>"
            <?php }}} ?>