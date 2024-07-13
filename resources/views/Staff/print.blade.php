<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Prasarana</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>

<body>
    <h3 class="text-center">Laporan Sarana Prasarana</h3>
    <h1 class="text-center">SMK 2 PASUNDAN</h1>
    <p class="text-center">Jl. Arief Rahman Hakim, Kab. Cianjur 43281</p>
    <br />

    <div class="container-fluid">
    <div>

                    <div>
                        <h3>a.prasarana</h3>
                    <table id="table-data" class="table table-striped table-white">
                    <thead style = "background-color:Aquamarine">
                        <tr class="text-center">
                        <th>NO</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Ruangan</th>
                            <th>Jumlah Ada</th>
                            <th>Kondisi</th>
                            <th>Jumlah Diperlukan</th>
                            <th>Keterangan</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($prasarana as $row)
                        
                            <tr>
                            <td>{{ $no++ }}</td>
                                <td>{{ $row->kode}}</td>
                                <td>{{ $row->tanggal}}</td>
                                <td>{{ $row->ruangan->nama }}</td>
                                <td>{{ $row->jumlah_ada}}</td>
                                <td>{{ $row->kondisi}}</td>
                                <td>{{ $row->jumlah_diperlukan}}</td>
                                <td>{{ $row->keterangan}}</td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
                        <h3>b.sarana</h3>
                    <table id="table-data" class="table table-striped table-white ">
                    <thead style = "background-color:Aquamarine">
                        <tr class="text-center">
                        <th>NO</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Merek</th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($sarana as $sar)
                        
                            <tr>
                            <td>{{ $no++ }}</td>
                                <td>{{ $sar->kode}}</td>
                                <td>{{ $sar->tanggal}}</td>
                                <td>{{ $sar->merek}}</td>
                                <td>{{ $sar->kategori}}</td>
                                <td>{{ $sar->nama_barang}}</td>
                                <td>{{ $sar->harga }}</td>
                                <td>{{ $sar->jumlah }}</td>  
                                </tr>
                        @endforeach
                    </tbody>
                </table>
                
</body>

</html>