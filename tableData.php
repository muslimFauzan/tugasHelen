<div class="container">
    <div style="text-align: center;">
        <h2>Daftar Transaksi Pinjaman</h2>
    </div>
    <div id="table-wrapper">
        <div style="display: flex;">
            <div class="addBtn" id="addBtn" onclick="toForm()" style="margin-right:30px">Pinjam</div>
            <div class="addItem" id="addItem" onclick="toTableItem()">Item</div>
        </div>
        <div id="table-scroll">
            <table id="tableData" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%" class="no">No</th>
                        <th width="10%">Kode</th>
                        <th width="15%">Nama</th>
                        <th width="15%">Item</th>
                        <th width="20%">Tanggal Pinjam</th>
                        <th width="20%">Tanggal Kembali</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    getData();

    function getData() {

        var xhr = new XMLHttpRequest();

        var url = 'getAllData.php';

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
            var cellKode = row.insertCell(1);
            var cellNama = row.insertCell(2);
            var cellItem = row.insertCell(3);
            var cellPinjam = row.insertCell(4);
            var cellKembali = row.insertCell(5);
            var cellAction = row.insertCell(6);


            cellNo.innerHTML = i + 1;
            cellKode.innerHTML = data[i]['kode_transaksi'];

            cellNama.innerHTML = data[i]['nama_peminjam'];
            cellItem.innerHTML = data[i]['nama_item'];

            cellPinjam.innerHTML = data[i]['tanggal_pinjam'];
            cellKembali.innerHTML = data[i]['tanggal_kembali'];


            cellAction.innerHTML = `
            <div style="text-align: center; display:flex; align-items:center">
            <div onclick="detailPinjam('${data[i]['kode_transaksi']}')" style="margin-right: 5px;" class="editBtn">Edit</div>
                                <div onclick="deletePinjam('${data[i]['kode_transaksi']}')" class="hapusBtn">Hapus</div>
              </div>
            `;
        }
    }
</script>