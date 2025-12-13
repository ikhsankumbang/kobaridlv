
<!doctype html>
<html lang="en">

<head>
    <title>Barang Lihat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url({{ asset('images/bengkel.png') }});"></a>
                
                <ul class="list-unstyled components mb-5">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    <li><a href="{{ url('/customer') }}">Customer</a></li>
                    <li class="active"><a href="{{ url('/barang') }}"><a href="{{ url('/barang') }}">Barang</a></li>
                    <li><a href="{{ url('/pegawai') }}">Pegawai</a></li>
                    <li><a href="{{ url('/purchase_order') }}">Purchase Order</a></li>
                    <li><a href="{{ url('/surat_jalan') }}">Surat Jalan</a></li>
                    <li><a href="{{ url('/invoice') }}">Invoice</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
        </nav>

        <div id="content" class="p-4 p-md-5">
            <div style="text-align: end; margin-top:-25px;">
                <a href="{{ url('barang/create') }}" class="btn btn-warning" type="button">+ TAMBAHKAN</a>
            </div>

            <div class="rectangle" style="width: 100%; margin-top: 5px;">
                <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
                    <thead class="table-primary">
                        <tr>
                            <th>NO PART</th>
                            <th>NAMA BARANG</th>
                            <th>STOK</th>
                            <th>HARGA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data_barang as $item)
                        <tr>
                            <td>{{ $item->no_part }}</td>
                            <td style="text-align: start;">{{ $item->nama_barang }}</td>
                            <td>{{ number_format($item->qty, 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <a class="btn btn-success" href="{{ url('barang/edit/'.$item->no_part) }}">Ubah</a> |
                                <form action="{{ url('barang/delete/'.$item->no_part) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    
    <script src="{{ asset('js/main.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>
</html>