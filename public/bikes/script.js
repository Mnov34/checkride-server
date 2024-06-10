$(document).ready(function() {
    let table = new DataTable("#motorcycleTable");

    function fetchData() {
        $.ajax({
            url: "server.php",
            type: "POST",
            data: { action: 'fetchMotorcycles' },
            dataType: "json",
            success: function(response) {
                table.clear();
                response.data.forEach(function(value) {
                    table.row.add([
                        value.Id_motorcycle,
                        value.brand,
                        value.model,
                        value.cylinder,
                        value.prod_year.slice(0, 4),
                        value.plate,
                        value.acquisition_date.slice(0, 10),
                        '<button type="button" class="btn btn-primary editBtn" data-id="' + value.Id_motorcycle + '">Edit</button>',
                        '<button type="button" class="btn btn-danger deleteBtn" data-id="' + value.Id_motorcycle + '">Delete</button>'
                    ]).draw(false);
                });
            },
            error: function(xhr, status, error) {
                alert("Failed to fetch data: " + xhr.responseText);
            }
        });
    }

    fetchData();

    $("#insertMotorcycleForm").on("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'insertMotorcycle');
        $.ajax({
            url: "server.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#insertMotorcycleModal").modal("hide");
                fetchData();
            },
            error: function(xhr) {
                alert("Error adding motorcycle: " + xhr.responseText);
            }
        });
    });

    $("#motorcycleTable").on("click", ".editBtn", function() {
        const id = $(this).data("id");
        $.ajax({
            url: "server.php",
            type: "POST",
            data: { id: id, action: 'getMotorcycleDetails' },
            dataType: "json",
            success: function(response) {
                var data = response.data;
                $('#editId').val(data.Id_motorcycle);
                $('#editBrand').val(data.brand);
                $('#editModel').val(data.model);
                $('#editCylinder').val(data.cylinder);
                $('#editProdYear').val(data.prod_year);
                $('#editPlate').val(data.plate);
                $('#editAcquisitionDate').val(data.acquisition_date);
                $("#editMotorcycleModal").modal("show");
            },
            error: function(xhr) {
                alert("Error fetching details: " + xhr.responseText);
            }
        });
    });

    $("#editMotorcycleForm").on("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'updateMotorcycle');
        $.ajax({
            url: "server.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#editMotorcycleModal").modal("hide");
                fetchData();
            },
            error: function(xhr) {
                alert("Error updating motorcycle: " + xhr.responseText);
            }
        });
    });

    $("#motorcycleTable").on("click", ".deleteBtn", function() {
        const id = $(this).data("id");
        if (confirm("Are you sure you want to delete this motorcycle?")) {
            $.ajax({
                url: "server.php",
                type: "POST",
                data: { id: id, action: 'deleteMotorcycle' },
                success: function(response) {
                    fetchData();
                },
                error: function(xhr) {
                    alert("Error deleting motorcycle: " + xhr.responseText);
                }
            });
        }
    });
});
