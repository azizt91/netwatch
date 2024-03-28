<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"  type="image/png" sizes="500x500" href="{{ asset('template') }}/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('template') }}/css/style.css" rel="stylesheet">
    <title>Netwatch</title>  
</head>
<body>

    {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">
                <img src="{{ asset('template') }}/img/logo2.png" alt="Netwatch Logo" width="30" height="30" >
                {{ $model }}
            </a>
            <div>
                Online: <span class="badge text-bg-success">{{ $statusUpCount }}</span><br>
                Offline: <span class="badge text-bg-danger">{{ $statusDownCount }}</span>
            </div>
        </div>
    </nav> --}}

<div class="content-netwatch mt-3">
<div class="container col-md-8">

    <div class="mb-3">
        Online: <span class="badge text-bg-success">{{ $statusUpCount }}</span>
        Offline: <span class="badge text-bg-danger">{{ $statusDownCount }}</span>
    </div>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search By Name or Status">
    </div>
    <div class="table-responsive">
        <table id="netwatchTable" class="table table-sm table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Host') }}</th>
                    <th scope="col">{{ __('Since') }}</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($netwatchData) && count($netwatchData) > 0)
                    @foreach ($netwatchData as $data)
                        <tr>
                            <td class="small">{{ $loop->iteration }}</td>
                            <td class="small">{{ $data['comment'] ?? 'N/A' }}</td>
                            <td>
                                @if ($data['status'] == 'up')
                                    <div class="online-indicator">
                                        <span class="blink"></span>
                                    </div>
                                @else
                                    <div class="offline-indicator">
                                        <span class="blink"></span>
                                    </div>
                                @endif
                                <span class="small">{{ $data['status'] ?? 'N/A' }}</span>
                            </td>
                            <td class="small">{{ $data['host'] ?? 'N/A' }}</td>
                            <td class="small">{{ $data['since'] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            <p>Tidak ada data netwatch.</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>    
</div>
</div>

<div class="disconnect-wrapper">
    <div class="form-group">
        <form action="/disconnect" method="get">
            @csrf
            <a href="#" class="disconnect-btn" onclick="showDisconnectModal()">
                <i class="fa fa-power-off" aria-hidden="true"></i>
            </a>
        </form>
    </div>
</div>

    <!-- Modal Disconnet -->
    <div class="modal fade" id="disconnectModal" tabindex="-1" role="dialog" aria-labelledby="disconnectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disconnectModalLabel">Disconnect</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to disconnect?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <a href="/disconnect" class="btn btn-danger">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#searchInput').on('input', function () {
                var searchInput = $(this).val().toLowerCase();
    
                $('#netwatchTable tbody tr').each(function () {
                    var rowText = $(this).text().toLowerCase();
    
                    if (rowText.includes(searchInput)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
    
    
    <script>
        function showDisconnectModal() {
            $('#disconnectModal').modal('show');
        }
    </script>
    

<script>
    function updateNetwatchData() {
        $.ajax({
            url: '/netwatch',
            method: 'GET',
            success: function(response) {
                // Update data pada view
                $('#netwatchContainer').html(response.netwatchData);
            },
            error: function(error) {
                console.error('Error fetching netwatch data:', error);
            }
        });
    }

    // Panggil fungsi pertama kali
    updateNetwatchData();

    // Set interval agar fungsi dipanggil secara berkala
    setInterval(updateNetwatchData, 3000); // Ganti 5000 dengan interval yang diinginkan (dalam milidetik)
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