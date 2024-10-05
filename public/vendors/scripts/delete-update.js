$(document).ready(function () {
    $(".toggle-status").change(function () {
        var checkbox = $(this);
        var id = checkbox.data("id");
        var status = checkbox.prop("checked");

        $.ajax({
            url: "/update-status/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: status,
            },
            success: function (response) {
                console.log(response);
                Toast.fire({
                    icon: "success",
                    title: "Status updated successfully",
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    });
});

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    },
});

function confirmDelete(productId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                position: "center",
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
            });
            document.getElementById("delete-form-" + productId).submit();
        }
    });
}
