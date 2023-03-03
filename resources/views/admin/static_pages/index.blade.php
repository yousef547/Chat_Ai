@extends('layouts.layout')
@section('title')
HomePage
@endsection
@section('styles')
<link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css">
<!-- DataTables -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/intlTelInput.min.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

<style>
    .centers {
        text-align: center;
        padding-top: 30px !important;
    }

    .form-group {
        margin: 15px 0;
    }

    .flexs {
        display: flex;
        justify-content: end;
    }

    .light {
        color: #9ba1a8;
    }

    .fonts {
        font-size: 20px !important;
        font-weight: 600 !important;
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    @include('admin.inc.massage')

    <div class="row">
        <div class="col-md-12">
            <h5 class="card-title">{{$newLang->staticPages}}</h5>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{route('static_pages.save')}}">
                        @csrf
                        <div id="message"></div>
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" placeholder="Subject" name="pageTitle" aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                        <div class="mb-3 ">
                            <label for="example-password-input1" class="form-label">{{$newLang->pageTitle}}</label>
                            <div class="input-group">
                                <span class="input-group-text"> <button type="button" style="background-color: #06b763;color: white;width: 100%;height: 40px" onclick="generateContent()">Generate AI</button>
                                </span>
                                <input class="form-control"  type="text" id="text" placeholder="{{$newLang->pageTitle}}">
                            </div>
                        </div>
                        <div id="result_1" class="p-5">
                        </div>
                        <textarea name="pageContent" id="editor1" rows="10" cols="80"></textarea>
                        <script>
                            // Replace the <textarea id="editor1"> with a CKEditor 4
                            // instance, using default configuration.
                            CKEDITOR.replace('editor1');
                        </script> 
                        <div class="mb-0 row">
                            <label class="col-md-1 my-2 control-label">{{$newLang->Status}}</label>
                            <div class="col-md-9">
                                <div class="radio my-2">
                                    <div class="form-check">
                                        <input type="radio" id="customRadio3" value="1" name="pageActive" class="form-check-input">
                                        <label class="form-check-label" for="customRadio3">{{$newLang->Active}}</label>
                                    </div>
                                </div>
                                <div class="radio my-2">
                                    <div class="form-check">
                                        <input type="radio" id="customRadio4" checked="" value="0" name="pageActive" class="form-check-input">
                                        <label class="form-check-label" for="customRadio4">{{$newLang->Inactive}}</label>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <input type="submit" class="btn btn-info waves-effect waves-light" value="{{$newLang->addPage}}">
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

</div>

@section('script')
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>

<!-- Required datatable js -->
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<!-- <script src="{{asset('assets/js/intlTelInput.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="{{asset('assets/js/intlTelInput-jquery.min.js')}}"></script> -->


<script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>


<!-- Datatable init js -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

<script>
    function generateContent() {
        let text = document.getElementById("text").value;

        if (text.length < 1) {
            return alert("please enter your text");
        }
        // document.getElementById("text").value = "";
        document.getElementById("message").innerHTML = "<strong>Wait we load data now from gpt</strong>";
        // document.getElementById("result").value += '<div class="message-from">' + text + '</div>'
        $("#result").val(text)

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("message").innerHTML = "";
            console.log("response is", this.responseText);
            let data = JSON.parse(this.responseText);
            let par = "";
            data.choices.forEach((textData) => {
                par += textData.text;
            });
            par = par.replace(/\n/g, "<br>");
            console.log(par);
            $("#result").val(par)
            // document.getElementsById("result_1").value += '<div class="message-to">' + par + '</div>';
            $("#result_1").html(par)
        }
        xhttp.open("POST", "https://api.openai.com/v1/completions");
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.setRequestHeader("Authorization", "Bearer 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");
        let sendData = JSON.stringify({
            "model": "text-davinci-003",
            "prompt": text,
            "temperature": 1,
            "max_tokens": 4000
        });
        xhttp.send(sendData);
    }
</script>

@endsection
@endsection