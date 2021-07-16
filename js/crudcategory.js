$(document).ready(function() {
    $("#tableCategory").DataTable( {
        ajax:{
            type: "GET",
            url: alamat + "Category/getData",
            dataSrc: "",
            dataType: "json",
        },
        columns: [ {

            render:function(full,type,data,meta){
                return data.nama;
            }
        },
        {
            render:function(full,type,data,meta){
                return data.deskripsi;
            }
      },
        {
            render:function(full,type,data,meta){
                return `<button  data-toggle="modal" data-target="#exampleModal" class="btn btn-info">Edit</button>
                <button class="btn btn-danger">hapus</button>`;
            }
        }
    ]
    } );
} );