<?php 
    // Membuat page datamahasiswa.php ditunda atau dijeda 1 detik
    // sleep(1);
    
    // Jika ingin menggunakan jeda kurang dari 1 detik bisa menggunakan usleep 
    // tetapi usleep menggunakan parameter milisecond, 1 second = 1000000 (1 juta) milisecond
    usleep(500000); // dijeda 0,5 detik karena parameternya 500 ribu

    require "../functions.php";

    $datacari = $_GET["keyword"];
    $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$datacari%' OR nim LIKE '%$datacari%' OR email LIKE '%$datacari%' ORDER BY id DESC";
    $datamhs = querysql($query);
?>
<?php if($datamhs) : ?>
    <table style="text-align:center;" border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Nomer</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <th>Gambar</th>
            <th></th>
            <th></th>
        </tr>
        <?php $i = 1; ?>   
        <?php foreach ($datamhs as $mhs) : ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $mhs["nama"] ?></td>
                <td><?= $mhs["nim"] ?></td>
                <td><?= $mhs["email"] ?></td>
                <td><img src="img/<?= $mhs["gambar"] ?>" alt=" <?= $mhs["gambar"] ?>" width="200" height="200"></td>
                <td><a href="ubah.php?id=<?= $mhs["id"] ?>">edit</a></td>
                <td><a href="hapus.php?id=<?= $mhs["id"] ?>" onclick="return confirm('Konfirmasi Hapus')">delete</a></td>
                <?php $i++; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <h1>Data <?= $datacari ?> Tidak Ditemukan!!</h1>
<?php endif; ?>