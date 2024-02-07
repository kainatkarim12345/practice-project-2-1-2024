@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                <button onclick="startFCM()"
                    class="btn btn-danger btn-flat">Allow notification
                </button>
                </div>
                <div class="card-body">
                    <form action="{{ route('send.web-notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Message Title</label>
                                @if ($errors->has('title'))
                                    <span class="text-danger">
                                        {{ $errors->get('title')[0] }}
                                    </span>
                                @endif
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Message Body</label>
                                @if ($errors->has('body'))
                                    <span class="text-danger">
                                        {{ $errors->get('body')[0] }}
                                    </span>
                                @endif
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    @if(session('status'))
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
        title: "{{ session('status') }}"
        });
    
    @endif

    var firebaseConfig = {
        apiKey: "AIzaSyClx6QsvU0I5SRYPDPmFWW20cwvnIsS-HQ",
        authDomain: "practice-project-61731.firebaseapp.com",
        projectId: "practice-project-61731",
        storageBucket: "practice-project-61731.appspot.com",
        messagingSenderId: "283454383212",
        appId: "1:283454383212:web:22356fef0bd3dd780d2449",
        measurementId: "G-LXNGMV9BGZ"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("store.token") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token stored.');
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            }).catch(function (error) {
                alert(error);
            });
    }
    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>
@endsection
