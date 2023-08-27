@extends('home')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0"> Create Question For </h6>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop"
                    onclick="createProject()">
                    Create Question
                </button>
            </div>
            <div class="card-body">
                <div id="alert-div"></div>
                <table class="table table-bordered" id="projects_table">
                    <thead>
                        <tr>
                            <th scope="col">Question No</th>
                            <th scope="col">Question Name</th>
                            <th scope="col">Option 1</th>
                            <th scope="col">Option 2</th>
                            <th scope="col">Option 3</th>
                            <th scope="col">Option 4</th>
                            <th scope="col">Correct Ans</th>
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
                                <input type="text" class="form-control form-control-lg" id="quiz_question"
                                    placeholder="Question" name="quiz_question">

                                <input type="hidden" class="form-control form-control-lg" id="quiz_question_id"
                                    placeholder="Question" name="subjective_quiz_id"
                                    value="{{ $quiz_info->subjective_quiz_id }}">

                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="quiz_option_1"
                                    placeholder="Option 1" name="quiz_option_1">
                                <input type="text" class="form-control form-control-lg" id="quiz_info"
                                    placeholder="Option 1" name="quiz_info">

                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="quiz_option_2"
                                    placeholder="Option 2" name="quiz_option_2">
                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="quiz_option_3"
                                    placeholder="Option 2" name="quiz_option_3">
                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="quiz_option_4"
                                    placeholder="Option 4" name="quiz_option_4">
                            </span>
                        </div>
                        <div class="col-12 p-2 mt-2">
                            <span class="float-label">
                                <input type="text" class="form-control form-control-lg" id="quiz_answer"
                                    placeholder="Correct Answer" name="quiz_answer">
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
        let quiz_question_id = $('#quiz_question_id').val();

        $(function() {
            let url = "{{ url('create-subjective-question') }}" + '/' + quiz_question_id;
            // create a datatable
            $('#projects_table').DataTable({
                processing: true,
                ajax: url,
                "order": [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'quiz_question'
                    },
                    {
                        data: 'quiz_option_1'
                    },
                    {
                        data: 'quiz_option_2'
                    },
                    {
                        data: 'quiz_option_3'
                    },
                    {
                        data: 'quiz_option_4'
                    },
                    {
                        data: 'quiz_answer'
                    },
                    {
                        data: 'action'
                    }
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
                quiz_question_id: $("#quiz_question_id").val(),
                quiz_question: $("#quiz_question").val(),
                quiz_option_1: $("#quiz_option_1").val(),
                quiz_option_2: $("#quiz_option_2").val(),
                quiz_option_3: $("#quiz_option_3").val(),
                quiz_option_4: $("#quiz_option_4").val(),
                quiz_answer: $("#quiz_answer").val(),
            };
            $('.wrapper').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('create-subjective-question-post') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    $('.wrapper').hide();
                    let successHtml =
                        '<div class="alert alert-success" role="alert"><b>Question Created Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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
            let url = $('meta[name=app-url]').attr("content") + "/create-subjective-question/" + id + "/edit";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let project = response.project;
                    $("#alert-div").html("");
                    $("#error-div").html("");
                    $("#update_id").val(project.quiz_id);
                    $("#quiz_question").val(project.quiz_question);
                    $("#quiz_option_1").val(project.quiz_option_1);
                    $("#quiz_option_2").val(project.quiz_option_2);
                    $("#quiz_option_3").val(project.quiz_option_3);
                    $("#quiz_option_4").val(project.quiz_option_4);
                    $("#quiz_answer").val(project.quiz_answer);
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
                quiz_question: $("#quiz_question").val(),
                quiz_option_1: $("#quiz_option_1").val(),
                quiz_option_2: $("#quiz_option_2").val(),
                quiz_option_3: $("#quiz_option_3").val(),
                quiz_option_4: $("#quiz_option_4").val(),
                quiz_answer: $("#quiz_answer").val(),
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
                        '<div class="alert alert-danger" role="alert"><b>Question Deleted Successfully</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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
