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
    <h3 class="text-center">Laporan Pertanggung Jawaban Sarana Dan Prasarana</h3>
    <h2 class="text-center">SMK PGRI 2 Cianjur</h2>
    <p class="text-center">Jl. KH Abdullah Bin Nuh No.103, Kab. Cianjur 43281</p>
    <br />

    <div class="container-fluid">
    <div>

                    <div>
                        <p><b>Pengadaan</b></p>
                    <table id="table-data" class="table table-striped table-white">
                    <thead style = "background-color:Aquamarine">
                        <tr class="text-center">
                        <th>NO</th>
                            <th>Kode Pengadaan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Ruangan</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($pengadaan as $row)
                            <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->kode}}</td>
                                <td>{{ $row->tanggal_pengadaan}}</td>
                                <td>{{ $row->ruangan->nama_ruangan }}</td>
                                <td>{{ $row->harga }}</td>
                                <td>{{ $row->keterangan }}</td>
                                </tr>
                        @endforeach
                    </tbody>
</table>
<p><b>Rincian Pengadaan</b></p>
                    <table id="table-data" class="table table-striped table-white">
                    <thead style = "background-color:Aquamarine">
                        <tr class="text-center">
                        <th>NO</th>
                            <th>Barang</th>
                            <th>Merk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($pengadaandetail as $row1)
                            <tr>
                            <td>{{ $no++ }}</td>
                                <td>{{ $row1->barang->nama_barang}}</td>
                                <td>{{ $row1->merk}}</td>
                                <td>{{ $row1->qty }}</td>
                                <td>{{ $row1->harga }}</td>
                                <td>{{ $row1->total }}</td>
                                </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td colspan="1"></td>
                            <td>Rp.{{$total}}</td>
                            <td>Sisa</td>
                            <td colspan="1"></td>
                            <td>Rp.{{$sisa}}</td>
                        </tr>
                    </tfoot>
</table>
<table>
    <td> 
        @foreach($profile as $row)
 <p>Mengetahui,</p> <p>Kepala SMK PGRI 2 Cianjur</p>
    <p></p>
    <p></p>
    <p></p>
       <p>{{$row->name}}</p>
       <p>NUPTK.{{$row->id_status}}</p>

        
        @endforeach</td>
        <div style="margin-left:350px"></div>
<td>
        @foreach($profile1 as $row)
      
 <p>Cianjur. {{$tanggal->format('d-m-Y')}}</p><p>Wks Bid Sarana</p>
 <p></p>
    <p></p>
    <p></p>
       <p>{{$row->name}}</p>
       <p>NUPTK.{{$row->id_status}}</p>
    
        
        @endforeach
</td>
</table>
                   
                
</body>

</html>