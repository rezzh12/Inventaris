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
    <h3 class="text-center">Laporan Inventaris Sarana Dan Prasarana</h3>
    <h2 class="text-center">SMK PGRI 2 Cianjur</h2>
    <p class="text-center">Jl. KH Abdullah Bin Nuh No.103, Kab. Cianjur 43281</p>
    <p class="text-center">Dengan Kondisi {{$kondisi}}</p>
    <br />

    <div class="container-fluid">
    <div>

                    <div>
                    <table id="table-data" class="table table-striped table-white">
                    <thead style = "background-color:Aquamarine">
                        <tr class="text-center">
                        <th>NO</th>
                            <th>Kode Inventaris</th>
                            <th>Kode Pemeliharaan</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($inventaris as $row)
                            <tr>
                            <td>{{ $no++ }}</td>
                                <td>{{ $row->inventaris->kode }}</td>
                                <td>{{ $row->kode}}</td>
                                <td>{{ $row->created_at->format('Y-m-d')}}</td>
                                <td>{{ $row->barang->nama_barang }}</td>
                                <td>{{ $row->jumlah}}</td>
                                <td>{{ $row->keterangan }}</td>
                                </tr>
                        @endforeach
                    </tbody>
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