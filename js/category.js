function hapusData(id){
    $.ajax({
        url: alamat + "landing/hapus",
        type: "POST",
        data: {
            id: id,
        },
        success: function(data){
            reload_table(table);
        }
    })
}
function editData(id){
    $.ajax({
        url: alamat + "Landing/ambilDataById",
        type: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        success: function (data){
            $("#id_product").val(data.id);
            $("#nama_category").val(data.nama_category);
            $("#nama_product").val(data.nama_product);
            $("#harga").val(data.harga);
            $("#stok").val(data.stok);
            $("#deskripsi").val(data.deskripsi);

            let buttonUpdate = `
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="btnUpdate" class="btn btn-primary">Update</button>
            `;
            $("#button_").html(buttonUpdate);

            $("#btnUpdate").click(function(event){
                event.preventDefault();
        
                // var isi_form = $("#fromAdd")[0];
                var dataadd = new FormData();
        
                $('#formAdd').serializeArray();

                dataadd.append('image', $('#image')[0].files[0])
                
                $.ajax({
                    url: alamat + "Landing/updateData",
                    type: "POST",
                    enctype: "multipart/from-add",
                    processData: false,
                    contentType: false,
                    cache: false, 
                    data:  dataadd,
                    dataType: "json",
                    success: function(data){
                        
                        $("#nama_product").val();
                        $("#harga").val();
                        $("#stok").val();
                        $("#image").val();
                        $("#deskripsi").val();
                        $("#exampleModal").modal("hide");
                        reload_table(table);
                       
                    }
                })
            })
        }
    })
}

function  reload_table(table){
    table.ajax.reload();
}

$(document).ready(function() {
    $("#btnSubmit").click(function(event){
        event.preventDefault();

        // var isi_form = $("#fromAdd")[0];
        var dataadd = new FormData();

        $('#formAdd').serializeArray().forEach(i => {
            dataadd.append(i.name, i.value)
        });
        dataadd.append('image', $('#image')[0].files[0])
        
        $.ajax({
            url: alamat + "Landing/addData",
            type: "POST",
            enctype: "multipart/from-add",
            processData: false,
            contentType: false,
            cache: false,
            data:  dataadd,
            dataType: "json",
            success: function(data){
                $("#nama_product").val();
                $("#harga").val();
                $("#stok").val();
                $("#image").val();
                $("#deskripsi").val();
                $("#exampleModal").modal("hide");
                reload_table(table);
               
            }
        })
    })

    table = $("#table").DataTable({
        ajax:{
            type: "GET",
            url: alamat + "Landing/getData",
            dataSrc: "",
            datatype: "json",
        },

        columns: [ {

            render:function(full,type,data,meta){
                return data.nama_category;
            }
        },
        {
            render:function(full,type,data,meta){
                return data.nama_product;
            }
        },
        {
            render:function(full,type,data,meta){
                return data.harga;
            }
        },
        {
            render:function(full,type,data,meta){
                return data.stok;
            }
        },
        {
            render:function(full,type,data,meta){
                return data.deskripsi;
            }
        },
        {
            render:function(full,type,data,meta){
                return `<button onclick='editData(${data.id})' data-toggle="modal" data-target="#exampleModal" class="btn btn-info">Edit</button>
                <button  onclick='hapusData(${data.id})' class="btn btn-danger">hapus</button>`;
            }
        }
    ]
    });

   
} );