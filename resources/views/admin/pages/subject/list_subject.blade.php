@extends('home')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">All subject</h6>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#form-modal">
                    Create New Subject
                </button>
            </div>
            <div class="card-body">
                <div id="alert-div"></div>
                <table class="table table-bordered" id="projects_table">
                    <thead>
                        <tr>
                            <th scope="col">subject Name</th>
                            <th scope="col">Division</th>
                            <th scope="col">Subject Code</th>
                            <th scope="col">Subject Description</th>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Create subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="mainform">
                    <div id="error-div">
                    </div>
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="modal-body">
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="college_subject_name"
                                    placeholder="Subject Name" name="college_subject_name">

                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <div class="form-group">
                                <select class="form-control" name="college_subject_div" id="college_subject_div">
                                    <option disabled selected>Select Division</option>
                                    @foreach ($college_division as $college_division)
                                        <option value="{{ $college_division->college_div_id }}">
                                            {{ $college_division->college_division }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="college_subject_desc"
                                    placeholder="subject Description" name="college_subject_desc">
                            </span>
                        </div>

                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="college_subject_code"
                                    placeholder="Subject code" name="college_subject_code" readonly>
                            </span>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-project-btn">Save subject</button>
                    </div>

                </form>



            </div>
        </div>
    </div>

    <!-- https://thenounproject.com/search/?q=plane&i=687055 -->

    {{-- <x-preloader /> --}}

    <script type="text/javascript"></script>
    {{-- <script>
        $('.wrapper').hide();
        $(function() {
            let url = "{{ url('college-subject') }}";
            // create a datatable
            $('#projects_table').DataTable({
                processing: true,
                ajax: url,
                "order": [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'college_subject_name'
                    },
                    {
                        data: 'college_division'
                    },
                    {
                        data: 'college_subject_desc'
                    },
                    {
                        data: 'college_subject_code'
                    },
                    {
                        data: 'action'
                    },
                ],

            });
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
            $("#college_subject").val("");
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

        //unique number generator
        function generateUniqueNumber() {
            var randomNumber = Math.floor(100000 + Math.random() * 900000); // Generate a random 6-digit number
            return randomNumber.toString().substring(0, 6); // Extract the first 6 digits
        }

        // Example usage:


        $('#college_subject_name').keyup(function(e) {
            e.preventDefault();
            $('#college_subject_code').val(generateUniqueNumber());


        });

        function storeProject() {
            $("#save-project-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/projects";
            let data = {
                college_subject_name: $("#college_subject_name").val(),
                college_subject_div: $("#college_subject_div").val(),
                college_subject_desc: $("#college_subject_desc").val(),
                college_subject_code: $("#college_subject_code").val(),
            };
            $('.wrapper').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('college-subject') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    $('.wrapper').hide();

                    let successHtml =
                        '<div class="alert alert-success" role="alert"><b>subject Created Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $("#alert-div").html(successHtml);
                    $("#college_subject").val("");
                    $("#subject_unique_code").val("");
                    reloadTable();
                    $("#form-modal").modal('hide');
                    $("#mainform")[0].reset();

                },
                error: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        let errors = response.responseJSON.errors;
                        let college_subjectValidation = "";
                        if (typeof errors.college_subject !== 'undefined') {
                            college_subjectValidation = '<li>' + errors.college_subject[0] + '</li>';
                        }
                        let subject_unique_codeValidation = "";
                        if (typeof errors.subject_unique_code !== 'undefined') {
                            subject_unique_codeValidation = '<li>' + errors.subject_unique_code[0] + '</li>';
                        }

                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            '<ul>' + college_subjectValidation + subject_unique_codeValidation + '</ul>' +
                            '</div>';
                        $("#error-div").html(errorHtml);
                    }
                }
            });
        }


        //edit
        function editProject(id) {
            let url = $('meta[name=app-url]').attr("content") + "/college-subject/" + id + "/edit";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let project = response.project;
                    $("#alert-div").html("");
                    $("#error-div").html("");
                    $("#update_id").val(project.college_sub_id);
                    $("#college_subject_name").val(project.college_subject_name);
                    $("#college_subject_desc").val(project.college_subject_desc);
                    $("#college_subject_code").val(project.college_subject_code);
                    $("#subject_unique_code").val(project.subject_unique_code);
                    $("#college_subject_div").val(project.college_subject_div);
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
            let url = $('meta[name=app-url]').attr("content") + "/college-subject/" + $("#update_id").val();
            let data = {
                id: $("#update_id").val(),
                college_subject_name: $("#college_subject_name").val(),
                college_subject_desc: $("#college_subject_desc").val(),
                college_subject_code: $("#college_subject_code").val(),
                subject_unique_code: $("#subject_unique_code").val(),
                college_subject_div: $("#college_subject_div").val(),
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
                        '<div class="alert alert-success" role="alert"><b>subject Updated Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $("#alert-div").html(successHtml);
                    $("#college_subject_name").val("");
                    $("#college_subject_desc").val("");
                    $("#college_subject_code").val("");
                    $("#subject_unique_code").val("");
                    $("#college_subject_div").val("");
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
            let url = $('meta[name=app-url]').attr("content") + "/college-subject/" + id;
            let data = {
                college_subject_name: $("#college_subject_name").val(),
                college_subject_desc: $("#college_subject_desc").val(),
                college_subject_code: $("#college_subject_code").val(),
                subject_unique_code: $("#subject_unique_code").val(),
                college_subject_div: $("#college_subject_div").val(),
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
                        '<div class="alert alert-danger" role="alert"><b>subject Deleted Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $("#alert-div").html(successHtml);
                    reloadTable();
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }
    </script> --}}
@endsection
