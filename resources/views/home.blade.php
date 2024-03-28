<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="500x500" href="{{ asset('template') }}/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('template') }}/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Netwatch</title>
    <!-- PWA  -->
    <meta name="theme-color" content="#ffffff"/>
    <link rel="apple-touch-icon" href="{{ asset('template') }}/img/logo2.png">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>
<body>

    {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">
                <img src="{{ asset('template') }}/img/logo2.png" alt="Netwatch Logo" width="30" height="30" >
                Netwatch
            </a>
        </div>
    </nav> --}}

<div class="container col-md-4">
    <div id="logoAndText" class="text-center mb-5">
        <div class="d-flex align-items-center justify-content-center">
            <img src="{{ asset('template') }}/img/logo.png" alt="Logo" width="75" height="75">
            <h2 class="m-0">Netwatch</h2>
        </div>
        <div id="smallText">
            <p>v.1.0.0</p>
        </div>
    </div>

    <div class="additional-style">
        <ul class="nav nav-tabs nav-justified mb-3" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="saved-tab" data-bs-toggle="tab" href="#saved">Saved</a>
            </li>
        </ul>
    
        <div class="tab-content">
            <div class="content">
                <div class="tab-pane fade show active" id="login">
                    <form id="loginForm" action="/connect" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="host">Address:</label>
                            <input type="text" class="form-control" id="host" name="host" placeholder="192.168.0.1" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="arjuna" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password:</label>
                            <div class="input-group">
                                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => '&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;', 'required']) !!}
                                {{-- <input type="password" class="form-control" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required> --}}
                                <span id="mybutton1" onclick="change()" class="input-group-text">
                                    <!-- icon mata bawaan bootstrap  -->
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path fill-rule="evenodd"
                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="keep_password"
                                    @if(session('keep_password')) checked @endif>
                                <label class="custom-control-label" for="customCheck">Keep password</label>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary save-btn" data-bs-toggle="modal" data-bs-target="#savedModal">Save</button>
                            <button type="submit" class="btn btn-danger connect-btn" id="connectBtn">Connect</button>
                        </div>
                    </form>
                </div>
            </div>
    
            <div class="content">
                <div class="tab-pane fade" id="saved">
                    <div id="savedDataContainer">
                        <div class="row align-items-center savedDataItem">
                            <div id="savedData" class="col">
                                <!-- Data dari IndexedDB akan ditampilkan di sini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    

    <!-- Save Modal -->
    <div class="modal fade" id="savedModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Save Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="savedForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="modalSaveddHost">Address:</label>
                            <input type="text" class="form-control" id="modalSaveddHost" name="modalSaveddHost">
                        </div>
                        <div class="form-group mb-3">
                            <label for="modalSavedUsername">Username:</label>
                            <input type="text" class="form-control" id="modalSavedUsername" name="modalSavedUsername">
                        </div>
                        <div class="form-group mb-3">
                            <label for="modalSavedPassword">Password:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="modalSavedPassword" name="modalSavedPassword">
                                    <span id="mybutton2" onclick="change()" class="input-group-text">
                                        <!-- icon mata bawaan bootstrap  -->
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                            <path fill-rule="evenodd"
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        </svg>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="modalRouterName">Router Name:</label>
                            <input type="text" class="form-control" id="modalRouterName" name="modalRouterName" placeholder="Enter Router Name">
                        </div>
                        <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="saveDataBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                    
                <div class="modal-body">
                    <!-- Your form for editing data goes here -->
                    <form id="editForm" action="/update-data" method="post">
                        @csrf
                        <input type="hidden" id="editDataId" name="data_id" value="">

                        <div class="form-group mb-3">
                            <label for="modalSaveddHostEdit">Address:</label>
                            <input type="text" class="form-control" id="modalSaveddHostEdit" name="modalSaveddHostEdit">
                        </div>
                        <div class="form-group mb-3">
                            <label for="modalSavedUsernameEdit">Username:</label>
                            <input type="text" class="form-control" id="modalSavedUsernameEdit" name="modalSavedUsernameEdit">
                        </div>
                        <div class="form-group mb-3">
                            <label for="modalSavedPasswordEdit">Password:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="modalSavedPasswordEdit" name="modalSavedPasswordEdit">
                                    <span id="mybutton3" onclick="change()" class="input-group-text">
                                        <!-- icon mata bawaan bootstrap  -->
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                            <path fill-rule="evenodd"
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        </svg>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="modalRouterNameEdit">Router Name:</label>
                            <input type="text" class="form-control" id="modalRouterNameEdit" name="modalRouterNameEdit" placeholder="edit router name">
                        </div>
                        <!-- Add other form fields for editing -->
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelButton">Cancel</button>
                            <button type="submit" class="btn btn-danger">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading overlay -->
    <div id="spinnerWrapper" class="spinner-wrapper">
        <div class="spinner-container">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div id="connectingText" class="connecting-text">Connecting...</div>
        </div>
    </div>
    
    
    
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template') }}/js/index.js"></script>

<script>
    function change() {
    // Login Password
    var loginPassword = document.getElementById('password');
    var x = loginPassword.type;

    if (x === 'password') {
        loginPassword.type = 'text';
        document.getElementById('mybutton1').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
                                                            <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                                                            </svg>`;
    } else {
        loginPassword.type = 'password';
        document.getElementById('mybutton1').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                            <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                            </svg>`;
    }

    // Modal Saved Password
    var modalSavedPassword = document.getElementById('modalSavedPassword');
    var y = modalSavedPassword.type;

    if (y === 'password') {
        modalSavedPassword.type = 'text';
        document.getElementById('mybutton2').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
                                                            <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                                                            </svg>`;
    } else {
        modalSavedPassword.type = 'password';
        document.getElementById('mybutton2').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                            <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                            </svg>`;
    }

    // Modal Edit
    var modalSavedPasswordEdit = document.getElementById('modalSavedPasswordEdit');
    var y = modalSavedPasswordEdit.type;

    if (y === 'password') {
        modalSavedPasswordEdit.type = 'text';
        document.getElementById('mybutton3').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
                                                            <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                                                            </svg>`;
    } else {
        modalSavedPasswordEdit.type = 'password';
        document.getElementById('mybutton3').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                            <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                            </svg>`;
    }  }
</script>

<script src="{{ asset('/sw.js') }}"></script>
    <script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
        (registration) => {
            console.log("Service worker registration succeeded:", registration);
        },
        (error) => {
            console.error(`Service worker registration failed: ${error}`);
        },
        );
    } else {
        console.error("Service workers are not supported.");
    }
    </script>
    
    
<script language='javascript' type='text/javascript'>

function DisableBackButton() {

window.history.forward()

}

DisableBackButton();

window.onload = DisableBackButton;

window.onpageshow = function(evt) { if (evt.persisted)

DisableBackButton() }

window.onunload = function() { void (0) }

</script>


</body>
</html>
