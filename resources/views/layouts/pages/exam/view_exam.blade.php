@extends('home')
@section('content')
    <style>
        .row.result.section {
            margin-top: 10rem;
        }

        /*form styles*/
        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px;
        }

        #msform fieldset .form-card {}

        /*Hide all except first fieldset*/
        #msform fieldset:not(:first-of-type) {
            display: none;
        }

        #msform fieldset .form-card {
            text-align: left;
            color: #9E9E9E;
        }

        #msform input,
        #msform textarea {}

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: none;
            font-weight: bold;
            border-bottom: 2px solid skyblue;
            outline-width: 0;
        }

        /*Blue Buttons*/
        #msform .action-button {
            width: 150px;
            background: #00aaffc2;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 20px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }



        #msform .action-button:hover,
        #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue;
        }

        /*Previous Buttons*/
        #msform .action-button-previous {
            width: 150px;
            background: #e01d1dad;
            font-weight: bold;
            color: rgb(255 255 255);
            border: 0 none;
            border-radius: 20px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
        }

        /*Dropdown List Exp Date*/
        select.list-dt {
            border: none;
            outline: 0;
            border-bottom: 1px solid #ccc;
            padding: 2px 5px 3px 5px;
            margin: 2px;
        }

        select.list-dt:focus {
            border-bottom: 2px solid skyblue;
        }


        /*FieldSet headings*/
        .fs-title {
            font-size: 25px;
            color: #c2c5c9;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: left;
        }

        /*progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey;

        }

        #progressbar .active {
            color: #000000;
        }

        #progressbar li {
            list-style-type: none;
            font-size: 10px;
            width: 10%;
            float: left;
            position: relative;
        }

        /*Icons in the ProgressBar*/
        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f023";
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007";
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f09d";
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c";
        }

        /*ProgressBar before any progress*/
        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 18px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px;
        }

        /*ProgressBar connectors*/
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1;
        }

        /*Color number of the step and the connector before it*/
        #progressbar li.active:before,
        #progressbar li.active:after {
            background: skyblue;
        }


        .inputform {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: right .;
            flex-direction: column;
        }

        .inputform p {
            color: #51987d;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .inputform label {
            position: relative;
        }

        .inputform label input {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
        }

        .inputform label .fas {
            position: relative;
            width: 40px;
            height: 40px;
            background: #091921;
            line-height: 40px;
            text-align: center;
            margin: 0 4px;
            color: #ffffff;
            font-size: 16px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: -1px -1px 3px rgba(255, 255, 255, 0.1),
                2px 2px 6px rgba(0, 0, 0, 0.8);
            display: inline-block;
        }


        li.mt-2 {
            color: #000;
        }

        .container label .fas:hover {
            box-shadow: -1px -1px 3px rgba(255, 255, 255, 0.1),
                2px 2px 6px rgba(0, 0, 0, 0.8),
                inset -2px -2px 10px rgba(255, 255, 255, 0.05),
                inset 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        input:checked~.fas {
            color: #08FACB;
            box-shadow: inset -1px -1px 3px rgba(255, 255, 255, 0.1),
                inset 2px 2px 6px rgba(0, 0, 0, 1);
            text-shadow: 0 0 5px #08FACB,
                0 0 20px #08FACB;
        }


        .imground {
            border-radius: 20%;
            width: 80%;
            margin-top: 10%;
        }

        #conic {
            position: relative;
            z-index: 0;
            width: 400px;
            height: 300px;
            margin: 20px;
            border-radius: 10px;
            overflow: hidden;
            padding: 2rem;
        }

        #conic::before {
            content: '';
            position: absolute;
            z-index: -2;
            left: -50%;
            top: -50%;
            width: 200%;
            height: 200%;
            background-color: #1a232a;
            background-repeat: no-repeat;
            background-position: 0 0;
            background-image: conic-gradient(transparent, rgba(168, 239, 255, 1), transparent 30%);
            animation: rotate 4s linear infinite;
        }

        #conic::after {
            content: '';
            position: absolute;
            z-index: -1;
            left: 6px;
            top: 6px;
            width: calc(100% - 12px);
            height: calc(100% - 12px);
            background: #000;
            border-radius: 5px;
        }


        #conic::before,
        #conic::after {
            box-sizing: border-box;
        }

        @keyframes rotate {
            100% {
                transform: rotate(1turn);
            }
        }

        @keyframes opacityChange {
            50% {
                opacity: .5;
            }

            100% {
                opacity: 1;
            }
        }

        .progress {
            display: flex;
            height: 1rem;
            overflow: hidden;
            font-size: .75rem;
            background-color: #1a1d20;
            border-radius: .25rem;
            margin: 0px 20px 20px;
        }

        .progress-bar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            color: #161616;
            text-align: center;
            white-space: nowrap;
            background-color: #90c7ff;
            transition: width 1s ease;
        }

        em#other {
            font-size: 16px;
            font-family: monospace;
        }

        .box h2 {
            display: block;
            text-align: center;
            color: #00dcff75;
            font-size: 35px;
            font-weight: 900;
        }

        .box {}

        .box .chart {
            margin: auto;
            width: 50%;
        }



        .box canvas {}

        canvas {
            width: 120px !important;
            height: 120px !important;
            margin-bottom: 40px;
        }

        /* span.percentage {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            position: relative;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            left: 20px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } */

        .information {
            margin-bottom: 7px;
        }

        .resultable {
            border: none !important
        }

        button.btn.btn-large.btn-primary {
            display: block;
            width: 100%;
            border-radius: 6px;
        }

        button.leader {
            display: block;
            width: 100%;
            border-radius: 6px;
        }

        .buttonsection .table td,
        .table th {
            font-size: 14px;
            border-top-width: 0;
            border-bottom: 1px solid;
            border-color: #ebedf2 !important;
            padding: 0 10px !important;
            height: 35px;
            vertical-align: middle !important;
        }

        /* .mark-percentage {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        position: absolute;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        top: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */

        .mark-percentage {
            position: absolute;
            top: 47px;
            right: 56%;
            /* left: 50%; */
            transform: translateX(43px);
        }
    </style>
    {{-- @inject('dashboard','App\Models\Dashboard\Dashboard') --}}
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Participation of exam</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i>Exit Exam</a>
    </div>
    <!-- Content Row -->

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exam Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="panel-table-area">
                        <div class="panel-table border--base">
                            <div class="panel-card-body table-responsive">
                                <table class="table  table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Exam Name</th>
                                            <td>{{ $exam_name }}</td>
                                        </tr>

                                        <tr>
                                            <th>Exam Subject</th>
                                            <td>{{ $subject }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Question</th>
                                            <td>{{ $count }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Mark</th>
                                            <td>{{ $count }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pass Mark</th>
                                            <td>{{ round($count / 3) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pass Mark Percentage</th>
                                            <td>{{ round($count / 3) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Negative Marking</th>
                                            <td>No</td>
                                        </tr>
                                        <tr>
                                            <th>Total Time</th>
                                            <td>{{ $quiz_time }} Minutes</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <!-- DataTales Example -->
            <div class="card shadow mb-4" id="passcodearea">
                <input type="hidden" id="passcode" value="{{ $code }}">
                <input type="hidden" id="type" value="{{ $type }}">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Passcode</h6>
                </div>
                <div class="card-body">
                    <div class="quiz-container" id="quiz">
                        <div class="quiz-header">
                            <h2>Please Enter Passcode To Start</h2>
                        </div>
                        <div class="form-group m-3">
                            <input type="number" class="form-control" id="user_code" aria-describedby="emailHelp"
                                placeholder="e.g 123456">
                        </div>


                    </div>
                </div>
            </div>
            <div class="card shadow mb-4" id="hiddenpart">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exam</h6>
                </div>
                <div class="card-body">
                    <div class="quiz-container" id="quiz">
                        <div class="quiz-header">
                            <form id="msform" method="POST" action="{{ url('/exam/quiz-post') }}">
                                @csrf
                                <input type="hidden" id="otherVafeefal" name="countquiztime" value="70">
                                @foreach ($questions as $question)
                                    <fieldset id="field_{{ $question->quiz_id }}">
                                        <div class="form-card">
                                            <h2 class="fs-title text-danger pt-3">
                                                <span>{{ $loop->index + 1 }}. </span>
                                                {{ $question->quiz_question }}


                                            </h2>

                                            {{-- (<span>{{ $bnNumber->bnNum($loop->index + 1) }}/{{ $bnNumber->bnNum($question_count) }}</span>) --}}
                                            {{-- (<span>{{ $loop->index + 1 }}/{{ $question_count }}</span>) --}}
                                            <div class="inputform">

                                                <ul class="ullist text-white" style="list-style: none">
                                                    <li class="mt-2">
                                                        <label>
                                                            <input class="" type="radio"
                                                                name="quiz_{{ $question->quiz_id }}" id="exampleRadios1"
                                                                value="{{ $question->quiz_option_1 }}"><i
                                                                class="fas fa-check"></i>

                                                            {{ $question->quiz_option_1 }}</label>
                                                    </li>

                                                    <li class="mt-2">
                                                        <label>
                                                            <input class="" type="radio"
                                                                name="quiz_{{ $question->quiz_id }}" id="exampleRadios1"
                                                                value="{{ $question->quiz_option_2 }}"><i
                                                                class="fas fa-check"></i>

                                                            {{ $question->quiz_option_2 }}</label>

                                                    </li>

                                                    <li class="mt-2">
                                                        <label>
                                                            <input class="" type="radio"
                                                                name="quiz_{{ $question->quiz_id }}" id="exampleRadios1"
                                                                value="{{ $question->quiz_option_3 }}"><i
                                                                class="fas fa-check"></i>

                                                            {{ $question->quiz_option_3 }}</label>

                                                    </li>
                                                    <li class="mt-2">
                                                        <label>
                                                            <input class="" type="radio"
                                                                name="quiz_{{ $question->quiz_id }}" id="exampleRadios1"
                                                                value="{{ $question->quiz_option_4 }}"><i
                                                                class="fas fa-check"></i>

                                                            {{ $question->quiz_option_4 }}</label>

                                                    </li>

                                                </ul>


                                                <input type="hidden" name="get_subjective_id"
                                                    value="{{ request()->route('id') }}">
                                                {{-- <input type="hidden" name="quiz_result_hour"
                                                                         value="{{ $quiz_result_hour }}"> --}}

                                            </div>

                                        </div>
                                        @if ($question_first->quiz_id != $question->quiz_id)
                                            <input type="button" name="previous" class="previous action-button-previous"
                                                value="Previous" />
                                        @endif

                                        @if ($question_last->quiz_id == $question->quiz_id)
                                            <input type="submit" class="action-button" id="confirm"
                                                value="Submit Quiz" />
                                        @else
                                            <input type="button" name="next" id="nextid_{{ $question->quiz_id }}"
                                                class="next action-button" value="Next Question" />
                                        @endif
                                    </fieldset>
                                @endforeach
                                <input type="hidden" name="get_subjective_id" value="{{ $subjective_quiz_id }}">



                                <input type="text" name="time_count" id="time_count" value="70">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exam Instruction
                    </h6>
                </div>
                <div class="card-body">
                    <p>1. Don't reload the Page, <br>
                        2. Don't open the new tab,<br>
                        3. Don't minimize the browser,<br>
                        4. Submit within the time,<br>
                        5. While the time is finished exam will automatically submit</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="passcode" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Enter Private Passcode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="panel-table-area">
                            <div class="panel-table border--base">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Please Enter Passcode</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="e.g 123456">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        // $('div.rest').hide();
        // var getDate = $('#quiz_result_hour').val();
        // var d = new Date(getDate);
        // var d1 = new Date();
        // var timelimit = (d.getTime() - d1.getTime());
        // if (timelimit > 0) {
        //     setTimeout(function() {
        //         $('div.rest').show();
        //     }, timelimit);
        // }

        // var current_fs, next_fs, previous_fs; //fieldsets
        // var opacity;



        // if ($('#type').val() == 'public') {

        // } else {
        //     $('#hiddenpart').hide();
        // }

        if ($('#type').val() == 'public') {
            $('#passcodearea').hide();
            $('#hiddenpart').show();
        } else {
            $('#passcodearea').show();
            $('#hiddenpart').hide();
        }






        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function() {
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });

        $("#confirm").click(function() {
            // return false;

            let giventime = $('#timeid').val();
            let londiya = $('#other').text();
            let qurta = $("#other").text($("#other").text().replace("minutes", ",")).text();
            let lungi = $("#other").text($("#other").text().replace("seconds", " ")).text();
            let x = lungi;
            let a = x.split(',');
            let b = parseFloat(a[0]);
            let c = parseFloat(a[1]);
            let mins = b *= 60;
            // let sec = c * 60;
            let total = mins += c;
            let takingtime = giventime *= 60;



            //alert();



            //alert(takingtime);
            // $('#otherVal').val(takingtime -= total);
            $('#otherVal').val(giventime -= total);


        });


        $(function() {

            $('#user_code').blur(function(e) {
                e.preventDefault();
                let user_code = $(this).val();
                let passcode = $('#passcode').val();
                let type = $('#type').val();



                if (user_code == passcode) {
                    $('#hiddenpart').show();
                    $('#passcodearea').hide();
                } else {
                    alert('wrong passcode');
                }


            });
            $('#nextid').on('click', function(e) {
                e.preventDefault();

                var current_progress = 0;
                var interval = setInterval(function() {
                    current_progress += 20;
                    $("#dynamic")
                        .css("width", current_progress + "%")
                        .attr("aria-valuenow", current_progress)
                        .text(current_progress + "% Complete");
                    if (current_progress >= 100)
                        clearInterval(interval);
                }, 1000);

            });




        });
        (function($) {
            $.fn.countdown = function(milliseconds, callback) {
                var $el = this;
                var buffer = 200;
                var end, timer;

                // Defaults
                milliseconds = milliseconds || 5 * 60 * 1000; // 5 minutes
                end = new Date(Date.now() + milliseconds + buffer);

                // Start the counter
                tick();

                function formatTime(time) {
                    minutes = time.getMinutes();
                    seconds = time.getSeconds();
                    return minutes + " minutes " + seconds + " seconds";
                }

                function tick() {
                    var remaining = new Date(end - Date.now());

                    if (remaining > 0) {
                        $el.html(formatTime(remaining));
                        timer = setTimeout(tick, 1000);
                    } else {
                        clearInterval(timer);
                        if (callback) callback.apply($el);
                    }
                };
            };

            let timeid = $('#timeid').val();

            let submittime = timeid * 60 * 1000;

            // $('#timer').countdown(5 * 60 * 1000);
            $('#other').countdown(timeid * 60 * 1000, function() {
                this.html("Time's up!");
            });

            $('#time_count').countdown(timeid * 60 * 1000, function() {
                this.html("Time's up!");
            });



            $('#test').click(function(event) {
                event.preventDefault();


                // alert(takingtime);




            });

            // alert($('#other').text());







            // setTimeout(function() {
            //     $('#msform').submit();
            // }, submittime);

        })(jQuery);
    </script>
@endsection
