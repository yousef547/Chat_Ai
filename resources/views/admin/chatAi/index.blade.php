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
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Chat_Ai</h4>
            </div>
        </div>
        <h1>Welcome to GPT Test</h1>
        <div id="message"></div>
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title">Chat_Ai</h5>
                    <form action="#" style="margin-top: 20px">

                        <div class="input-group">
                            <span class="input-group-text"> <button style="background-color: #06b763;color: white;width: 100%;height: 40px" onclick="generateContent()">Send</button>
                            </span>
                            <textarea class="form-control" aria-label="With textarea" id="text"></textarea>
                        </div>
                    </form>

                </div>
                <div id="result" class="p-5 m-5">
                </div>
            </div>
            <!-- end card -->
        </div>
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



<script>
    function generateContent() {
        let text = document.getElementById("text").value;

        if (text.length < 1) {
            return alert("please enter your text");
        }
        document.getElementById("text").value = "";
        document.getElementById("message").innerHTML = "<strong>Wait we load data now from gpt</strong>";
        document.getElementById("result").innerHTML += '<div class="message-from">' + text + '</div>'
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
            document.getElementById("result").innerHTML += '<div class="message-to">' + par + '</div>';
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