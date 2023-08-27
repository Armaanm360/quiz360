@extends('home')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">All Division</h6>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop"
                    onclick="createProject()">
                    Create New Division
                </button>
            </div>
            <div class="card-body">
                <div id="alert-div"></div>
                <table class="table table-bordered" id="projects_table">
                    <thead>
                        <tr>
                            <th scope="col">Division Name</th>
                            <th scope="col">Division Unique Code</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="projects-table-body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade" id="form-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div id="error-div">
                    </div>
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="modal-body">
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="college_division"
                                    placeholder="Division Name" name="college_division">
                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="division_unique_code"
                                    placeholder="Division Unique Code" name="division_unique_code" readonly>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-project-btn">Save Division</button>
                    </div>

                </form>



            </div>
        </div>
    </div>

    <script>
        $(function() {
            let url = "{{ url('college-division') }}";
            // create a datatable
            $('#projects_table').DataTable({
                processing: true,
                ajax: url,
                "order": [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'college_division'
                    },
                    {
                        data: 'division_unique_code'
                    },
                    {
                        data: 'action'
                    },
                ],

            });
        });


        //unique number generator
        function generateUniqueNumber() {
            var randomNumber = Math.floor(100000 + Math.random() * 900000); // Generate a random 6-digit number
            return randomNumber.toString().substring(0, 6); // Extract the first 6 digits
        }

        // Example usage:


        $('#college_division').keyup(function(e) {
            e.preventDefault();
            $('#division_unique_code').val(generateUniqueNumber());


        });

        function reloadTable() {
            /*
                reload the data on the datatable
            */
            $('#projects_table').DataTable().ajax.reload();
        }

        function createProject() {
            $("#alert-div").html("");
            $("#error-div").html("");
            $("#update_id").val("");
            $("#college_division").val("");
            $("#description").val("");
            $("#form-modal").modal('show');
        }



        /*
            check if form submitted is for creating or updating
        */
        $("#save-project-btn").click(function(event) {
            event.preventDefault();
            if ($("#update_id").val() == null || $("#update_id").val() == "") {
                storeProject();
            } else {
                updateProject();
            }
        })

        function storeProject() {
            $("#save-project-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/projects";
            let data = {
                college_division: $("#college_division").val(),
                division_unique_code: $("#division_unique_code").val(),
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('college-division') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    let successHtml =
                        '<div class="alert alert-success" role="alert"><b>Division Created Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $("#alert-div").html(successHtml);
                    $("#college_division").val("");
                    $("#division_unique_code").val("");
                    reloadTable();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        let errors = response.responseJSON.errors;
                        let college_divisionValidation = "";
                        if (typeof errors.college_division !== 'undefined') {
                            college_divisionValidation = '<li>' + errors.college_division[0] + '</li>';
                        }
                        let division_unique_codeValidation = "";
                        if (typeof errors.division_unique_code !== 'undefined') {
                            division_unique_codeValidation = '<li>' + errors.division_unique_code[0] + '</li>';
                        }

                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            '<ul>' + college_divisionValidation + division_unique_codeValidation + '</ul>' +
                            '</div>';
                        $("#error-div").html(errorHtml);
                    }
                }
            });
        }


        //edit
        function editProject(id) {
            let url = $('meta[name=app-url]').attr("content") + "/college-division/" + id + "/edit";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let project = response.project;
                    $("#alert-div").html("");
                    $("#error-div").html("");
                    $("#update_id").val(project.college_div_id);
                    $("#college_division").val(project.college_division);
                    $("#division_unique_code").val(project.division_unique_code);
                    $("#form-modal").modal('show');
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }

        //update 

        function updateProject() {
            $("#save-project-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/college-division/" + $("#update_id").val();
            let data = {
                id: $("#update_id").val(),
                college_division: $("#college_division").val(),
                division_unique_code: $("#division_unique_code").val(),
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: data,
                success: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    let successHtml =
                        '<div class="alert alert-success" role="alert"><b>Division Updated Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $("#alert-div").html(successHtml);
                    $("#college_division").val("");
                    $("#division_unique_code").val("");
                    reloadTable();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        let errors = response.responseJSON.errors;
                        let descriptionValidation = "";
                        if (typeof errors.description !== 'undefined') {
                            descriptionValidation = '<li>' + errors.description[0] + '</li>';
                        }
                        let nameValidation = "";
                        if (typeof errors.name !== 'undefined') {
                            nameValidation = '<li>' + errors.name[0] + '</li>';
                        }

                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            '<ul>' + nameValidation + descriptionValidation + '</ul>' +
                            '</div>';
                        $("#error-div").html(errorHtml);
                    }
                }
            });
        }


        //destroy

        function destroyProject(id) {
            let url = $('meta[name=app-url]').attr("content") + "/college-division/" + id;
            let data = {
                college_division: $("#college_division").val(),
                division_unique_code: $("#division_unique_code").val(),
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "DELETE",
                data: data,
                success: function(response) {
                    let successHtml =
                        '<div class="alert alert-danger" role="alert"><b>Division Deleted Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $("#alert-div").html(successHtml);
                    reloadTable();
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }
    </script>
@endsection
