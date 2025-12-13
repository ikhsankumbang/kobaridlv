<!doctype html>
<html lang="en">
  <head>
    <title>Barang Edit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <li class="active"><a href="{{ url('/barang') }}">Barang</a></li>
                </ul>
        </div>
      </nav>

      <div id="content" class="p-4 p-md-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
           </nav>
    
        <div class="form">
            
            <form action="{{ url('/barang/update/'.$barang->no_part) }}" method="POST">
                
                @csrf
                @method('PUT') 

                <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH BARANG</label>
                <hr>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">NOMER PART</label>
                    <input type="text" name="no_part" class="form-control" style="display: inline-block; width: calc(100% - 110px);" 
                           value="{{ $barang->no_part }}" readonly>
                </div>
                
                <div class="form-element mt-3">
                    <label class="form-label"style="display: inline-block; width: 100px;">NAMA</label>            
                    <input type="text" name="nama_barang" class="form-control" style="display: inline-block; width: calc(100% - 110px);" 
                           value="{{ $barang->nama_barang }}">
                </div>

                <div class="form-element mt-3">
                    <label class="form-label" style="display: inline-block; width: 100px;">STOK</label>
                    <input type="number" name="qty" class="form-control" style="display: inline-block; width: calc(100% - 110px);" 
                           value="{{ $barang->qty }}">
                </div> 

                <div class="form-element mt-3">
                    <label class="form-label" style="display: inline-block; width: 100px;">HARGA</label>
                    <div style="display: inline-block; width: calc(100% - 110px);">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" name="harga" class="form-control" 
                                   value="{{ $barang->harga }}">
                        </div>
                    </div>
                </div>       
                <br>
                <div class="tombol" style="text-align: right;">
                    <a class="btn btn-danger" href="{{ url('/barang') }}">Batal</a>
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