@extends('home')
@section('content')
    {{-- @inject('dashboard','App\Models\Dashboard\Dashboard') --}}
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Exam List</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i>View Exam</a>
    </div>
    <!-- Content Row -->

    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Register User List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead style="background-color: #7367f0; color: #fff;">
                                <tr>
                                    <th>Titfeafefele</th>
                                    <th>Subject</th>
                                    <th>Quiz Creator</th>
                                    <th>Payment Type</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot style="background-color: #7367f0; color: #fff;">
                                <tr>
                                    <th>Title</th>
                                    <th>Subject</th>
                                    <th>Type</th>
                                    <th>Created By</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <div id="secured">
                                    @foreach ($quiz_list as $quiz_list)
                                        <tr>
                                            <td>{{ $quiz_list->subjective_quiz_name }}</td>
                                            <td>{{ $quiz_list->college_subject_name }}</td>
                                            <td style="color: {{ $quiz_list->quiz_type }}"></td>
                                            <td style="color: {{ $quiz_list->quiz_type === 'private' ? 'red' : 'black' }}">
                                                {{ $quiz_list->quiz_type }}</td>
                                            <td><a href="#" class="btn btn-info btn-icon-split" data-toggle="modal"
                                                    data-target="#staticBackdrop">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                    {{-- <span class="text">Details</span> --}}
                                                </a></td>
                                            <td><a href="{{ url('/exam/' . $quiz_list->subjective_quiz_id) }}"
                                                    class="btn btn-success">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Attend Exam</span>
                                                </a></td>
                                        </tr>
                                    @endforeach

                                </div>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="panel-table-area">
                            <div class="panel-table border--base">
                                <div class="panel-card-body table-responsive">
                                    <table class="table  table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Exam Name</th>
                                                <td>General Knowledge</td>
                                            </tr>
                                            <tr>
                                                <th>Exam Category</th>
                                                <td>Logic</td>
                                            </tr>
                                            <tr>
                                                <th>Exam Subject</th>
                                                <td>Quiz</td>
                                            </tr>
                                            <tr>
                                                <th>Total Question</th>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <th>Total Mark</th>
                                                <td>4</td>
                                            </tr>
                                            <tr>
                                                <th>Pass Mark</th>
                                                <td>2.2</td>
                                            </tr>
                                            <tr>
                                                <th>Pass Mark Percentage</th>
                                                <td>55%</td>
                                            </tr>
                                            <tr>
                                                <th>Negative Marking</th>
                                                <td>Yes</td>
                                            </tr>
                                            <tr>
                                                <th>Total Time</th>
                                                <td>120 Minutes</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('/exam/1') }}" class="btn btn-success">
                        {{-- <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span> --}}
                        <span class="text">Attend Exam</span>
                    </a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
