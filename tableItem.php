<div class="container">
    <div style="text-align: center;">
        <h2>Daftar Item</h2>
    </div>
    <div id="table-wrapper">
        <div style="display: flex;">
            <div class="backBtn" id="backBtn" onclick="backToTable()" style="margin-right:30px">Kembali</div>
            <div class="addBtn" id="addBtn" onclick="toFormItem()">Tambah Item</div>
        </div>
        <div id="table-scroll">
            <table id="tableData" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%" class="no">No</th>
                        <th width="35%">Nama Item</th>
                        <th width="20%">Jenis</th>
                        <th width="25%">Biaya</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($dataBengkel as $row) {
                        if ($row['jenis_item'] == '1') {
                            $j = 'CD';
                        } else {
                            $j = 'VCD';
                        }
                    ?>
                        <tr>
                            <td style="text-align: center;"><?= $i ?></td>
                            <td style="text-align: center;"><?= $row['nama_item'] ?></td>
                            <td style="text-align: center;"><?= $j ?></td>
                            <td style="text-align: center;"><?= number_format($row['biaya_pinjaman'], 2, '.', ',') ?></td>
                            <td style="text-align: center; display:flex; align-items:center">
                                <div onclick="detailItem('<?= $row['kode_item'] ?>')" style="margin-right: 5px;" class="editBtn">Edit</div>
                                <div onclick="deleteItem('<?= $row['kode_item'] ?>')" class="hapusBtn">Hapus</div>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    getData();

    function getData() {

        var xhr = new XMLHttpRequest();

        var url = 'getAllItem.php';

        xhr.open('GET', url, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                updateTable(response);
                // console.log(response);
            }
        };

        xhr.send();

    }

    function updateTable(data) {
        var tableBody = document.getElementById("tableData").getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';


        for (var i = 0; i < data.length; i++) {
            var row = tableBody.insertRow(i);

            var cellNo = row.insertCell(0);
            var cellItemName = row.insertCell(1);
            var cellJenis = row.insertCell(2);
            var cellBiaya = row.insertCell(3);
            var cellAction = row.insertCell(4);


            cellNo.innerHTML = i + 1;
            cellItemName.innerHTML = data[i]['nama_item'];

            if (data[i]['jenis_item'] == '1') {
                var js = 'CD'
            } else {
                var js = 'VCD'
            }

            cellJenis.innerHTML = js;

            var biaya = data[i]['biaya_pinjaman'];

            const biayaInt = parseInt(biaya);

            biayaIdr = biayaInt.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });

            cellBiaya.innerHTML = biayaIdr;


            cellAction.innerHTML = `
            <div style="text-align: center; display:flex; align-items:center">
            <div onclick="detailItem('${data[i]['kode_item']} ')" style="margin-right: 5px;" class="editBtn">Edit</div>
                                <div onclick="deleteItem('${data[i]['kode_item']}')" class="hapusBtn">Hapus</div>
              </div>
            `;
        }
    }
</script>