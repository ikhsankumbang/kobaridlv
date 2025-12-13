<!doctype html>
<html lang="en">
  <head>
    <title>Customer Edit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
  
  <body>
    <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="p-4 pt-5">
            <a href="#" class="img logo rounded-circle mb-5" style="background-image: url({{ asset('images/bengkel.png') }});"></a>
            <ul class="list-unstyled components mb-5">
                <li><a href="{{ url('/home') }}">Home</a></li>
                <li class="active"><a href="{{ url('/customer') }}">Customer</a></li>
                <li><a href="{{ url('/barang') }}">Barang</a></li>
                <li><a href="{{ url('/pegawai') }}">Pegawai</a></li>
                <li><a href="{{ url('/purchase_order') }}">Purchase Order</a></li>
                <li><a href="{{ url('/surat_jalan') }}">Surat Jalan</a></li>
                <li><a href="{{ url('/invoice') }}">Invoice</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>
      </nav>

      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
           </nav>
    
        <div class="form">
            
            <form action="{{ url('/customer/update/'.$customer->id_customer) }}" method="POST">
                
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="editCustomer" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">EDIT CUSTOMER</label>
                <hr>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">ID CUSTOMER</label>
                    <input type="text" class="form-control" style="display: inline-block; width: calc(100% - 160px);" value="{{ $customer->id_customer }}" disabled>
                </div>

                <div class="form-element mt-3">
                    <label class="form-label" style="display: inline-block; width: 150px;">NAMA CUSTOMER</label>
                    <input type="text" name="nama_customer" class="form-control" style="display: inline-block; width: calc(100% - 160px);" placeholder="Nama Customer" value="{{ old('nama_customer', $customer->nama_customer) }}">
                </div>
                
                <div class="form-element mt-3">
                    <label class="form-label" style="display: inline-block; width: 150px;">ALAMAT</label>            
                    <textarea name="alamat" class="form-control" style="display: inline-block; width: calc(100% - 160px);" placeholder="Alamat lengkap customer" rows="3">{{ old('alamat', $customer->alamat) }}</textarea>
                </div>

                <div class="form-element mt-3">
                    <label class="form-label" style="display: inline-block; width: 150px;">KONTAK</label>
                    <input type="text" name="kontak" class="form-control" style="display: inline-block; width: calc(100% - 160px);" placeholder="No. Telepon / HP" value="{{ old('kontak', $customer->kontak) }}">
                </div> 
      
                <br>
                <div class="tombol" style="text-align: right;">
                    <a class="btn btn-danger" href="{{ url('/customer') }}">Batal</a>
                    <button type="submit" class="btn btn-success">Update</button> 
                </div>

            </form>
            </div>
      </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
  </body>
</html>
