<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pawoon Test</title>

        <!-- Fonts -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-theme.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="" method="POST" role="form">
                        <legend>Form User</legend>
                    
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama">
                        </div>

                        <div class="form-group">
                            <label for="inputAlamat">Alamat</label>
                            <textarea name="alamat" id="inputAlamat" class="form-control" rows="3" placeholder="Masukkan Alamat"></textarea>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>UUID</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script>
        function get_data() {
            $("table tbody").empty();
            $.get('api/user', function(data) {
                $.each(data.data, function(index, val) {
                     $("table tbody").append('<tr>'+
                                            '<td>'+val.uuid+'</td>'+
                                            '<td>'+val.nama+'</td>'+
                                            '<td>'+val.alamat+'</td>'+
                                        '</tr>');
                });
                
            });
        }
        $(function(){
            get_data();
            $("form").submit(function(e){
                e.preventDefault();
                var t = $(this);
                $(".alert").remove();
                $.post('api/user', $(this).serialize(), function(data, textStatus, xhr) {
                    get_data();
                    t[0].reset();
                    $('<div class="alert alert-success" role="alert">'+data.message+'</div>').insertBefore(t);
                }).fail(function(data) {
                    data = data.responseJSON;
                    $('<div class="alert alert-danger" role="alert">'+data.message+'</div>').insertBefore(t);
                    $.each(data.errors, function(index, val) {
                         var inpt = $("[name="+index+"]");
                         inpt.next('.alert').remove();
                         $('<div class="alert alert-warning" role="alert">'+val+'</div>').insertAfter(inpt);
                    });
                })
            });
        });
    </script>
</html>
