$(document).ready(function(){
    $("#add_category").click(function(e){
        e.preventDefault();
        Swal.fire({
            title: "Category",
            input: "text",
            inputLabel: "Add Category",
            inputPlaceholder: "Enter category",
            showCancelButton: true,
            cancelButtonText: "Cancel",
            confirmButtonText: "Submit",
            preConfirm: (category) => {
                if (!category || category.trim() === "") {
                    Swal.showValidationMessage("Category cannot be empty");
                } else if (category.length > 10) {
                    Swal.showValidationMessage("Category name is too long (max 10 characters)");
                } else {
                    return category;
                }
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const category = result.value;
           
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: "/addcategory",
                    data: {category:category},
                    
                    success: function(response){

                        if (response.categories.length > 0) {
                            // Create the select box HTML
                            var selectBox = '<select class="form-control" id="category" name="category">';
                            selectBox += '<option value="">Select Category</option>';
                
                            $.each(response.categories, function(index, category) {
                                selectBox += '<option value="' + category.id + '">' + category.category + '</option>';
                            });
                
                            selectBox += '</select>';
                
                            $('#category-container').html(selectBox);
                        } else {
                            console.log("No categories found");
                        }

                    
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                              toast.onmouseenter = Swal.stopTimer;
                              toast.onmouseleave = Swal.resumeTimer;
                            }
                          });
                          Toast.fire({
                            icon: "success",
                            title: response.message
                          });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown);
                        console.log("Status Code:", jqXHR.status);
                        console.log(jqXHR.responseText);
                    }
                    
                
                  });
            }
        });
        
    });
});




