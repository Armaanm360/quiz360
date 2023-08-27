@extends('home')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">All Quiz</h6>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop"
                    onclick="createProject()">
                    Create New Quiz
                </button>
            </div>
            <div class="card-body">
                <div id="alert-div"></div>
                <table class="table table-bordered" id="projects_table">
                    <thead>
                        <tr>
                            <th scope="col">Quiz Name</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Quiz Code</th>
                            <th scope="col">Quiz Marks</th>
                            <th scope="col">Quiz Type</th>
                            <th scope="col">Quiz Time</th>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Create Quiz</h5>
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
                                <input type="text" class="form-control form-control-lg" id="subjective_quiz_name"
                                    placeholder="Quiz Name" name="subjective_quiz_name">

                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="quiz_code"
                                    placeholder="Quiz Code" name="quiz_code" readonly>

                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <div class="form-group">
                                <select class="form-control" name="subjective_sub_id" id="subjective_sub_id">
                                    <option disabled selected>Select Subject</option>
                                    @foreach ($college_subject as $college_subject)
                                        <option value="{{ $college_subject->college_sub_id }}">
                                            {{ $college_subject->college_subject_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <div class="form-group">
                                <select class="form-control" name="quiz_type" id="quiz_type">
                                    <option disabled selected>Select Quiz Type</option>
                                    <option value="private">Private</option>
                                    <option value="public">Public</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="number" class="form-control form-control-lg" id="quiz_number"
                                    placeholder="Number Of Quizes" name="quiz_number">
                            </span>
                        </div>

                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="quiz_marks"
                                    placeholder="Quiz Marks" name="quiz_mark" readonly>
                            </span>
                        </div>

                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="quiz_time"
                                    placeholder="Quiz Time" name="quiz_time">
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

    <x-preloader />
    {{-- 
    subjective_quiz_name: $("#subjective_quiz_name").val(),
    subjective_sub_id: $("#subjective_sub_id").val(),
    quiz_code: $("#quiz_code").val(),
    quiz_number: $("#quiz_number").val(),
    quiz_time: $("#quiz_time").val(), --}}
    <script>
        $('.wrapper').hide();
        $(function() {
            let url = "{{ url('college-quiz') }}";
            // create a datatable
            $('#projects_table').DataTable({
                processing: true,
                ajax: url,
                "order": [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'subjective_quiz_name'
                    },
                    {
                        data: 'college_subject_name'
                    },
                    {
                        data: 'quiz_code'
                    },
                    {
                        data: 'quiz_number'
                    },
                    {
                        data: 'quiz_type'
                    },
                    {
                        data: 'quiz_time'
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


        $('#subjective_quiz_name').keyup(function(e) {
            e.preventDefault();
            $('#quiz_code').val(generateUniqueNumber());


        });



        $('#quiz_number').keyup(function(e) {
            e.preventDefault();

            let quiz_number = $('#quiz_number').val();

            let finale = '1 *' + quiz_number + ' = ' + 1 * quiz_number;


            $('#quiz_marks').val(finale);


        });

        function storeProject() {
            $("#save-project-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/projects";
            let data = {
                subjective_quiz_name: $("#subjective_quiz_name").val(),
                subjective_sub_id: $("#subjective_sub_id").val(),
                quiz_code: $("#quiz_code").val(),
                quiz_number: $("#quiz_number").val(),
                quiz_time: $("#quiz_time").val(),
                quiz_type: $("#quiz_type").val(),
            };
            $('.wrapper').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('college-quiz') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    $('.wrapper').hide();
                    let successHtml =
                        '<div class="alert alert-success" role="alert"><b>Quiz Created Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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
            let url = $('meta[name=app-url]').attr("content") + "/college-quiz/" + id + "/edit";
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
            let url = $('meta[name=app-url]').attr("content") + "/college-quiz/" + $("#update_id").val();
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
            let url = $('meta[name=app-url]').attr("content") + "/college-quiz/" + id;
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
    </script>
@endsection
