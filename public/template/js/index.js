// Fungsi untuk memperbarui formulir save sebelum modal ditampilkan
$('#savedModal').on('show.bs.modal', function () {
    updateSaveForm();
});

// Fungsi untuk memperbarui formulir save dengan nilai formulir login
function updateSaveForm() {
    var loginHost = document.getElementById('host').value;
    var loginUsername = document.getElementById('username').value;
    var loginPassword = document.getElementById('password').value;

    // Isi nilai formulir save dengan nilai formulir login
    document.getElementById('modalSaveddHost').value = loginHost;
    document.getElementById('modalSavedUsername').value = loginUsername;
    document.getElementById('modalSavedPassword').value = loginPassword;
}


$(document).ready(function() {
    $('#saved-tab').on('click', function() {
        $('#logoAndText').hide();
    });

    $('#login-tab').on('click', function() {
        $('#logoAndText').show();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var connectBtn = document.getElementById('connectBtn');
    var spinnerWrapper = document.getElementById('spinnerWrapper');
    var connectingText = document.getElementById('connectingText');

    if (connectBtn) {
        connectBtn.addEventListener('click', function () {
            // Validate the form before showing the spinner
            if (validateForm()) {
                // Tampilkan spinner saat tombol connect diklik
                spinnerWrapper.style.display = 'flex';

                // Simulasikan pengambilan data dari Netwatch (gantilah dengan logika sesuai aplikasi Anda)
                setTimeout(function () {
                    // Ambil data dari Netwatch (contoh: data berhasil diambil)
                    var netwatchData = true;

                    // Sembunyikan spinner hanya jika data dari Netwatch tampil
                    if (netwatchData) {
                        spinnerWrapper.style.display = 'none';
                    }
                    // Jika data tidak tampil, biarkan spinner terbuka
                }, 60000); // Gantilah dengan waktu yang sesuai dengan kebutuhan Anda
            }
        });
    }

    // Example of a form validation function
    function validateForm() {
        var host = document.getElementById('host').value.trim();
        var username = document.getElementById('username').value.trim();

        if (host === '' || username === '') {
            // Display an alert or handle the validation error as needed
            alert('Please fill in all the required fields.');
            return false;
        }

        // Check if the username is an email
        if (isEmail(username)) {
            alert('Username cannot be an email address.');
            return false;
        }

        // Additional validation logic can be added here

        return true; // Return true if the form is valid
    }

    // Function to check if a string is an email address
    function isEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});

// Tambahkan event handler untuk tab "Saved"
$('#saved-tab').on('shown.bs.tab', function (e) {
    // Sembunyikan elemen terkait dengan tab "Login"
    $('#login').hide();
});

// Tambahkan event handler untuk tab "Login"
$('#login-tab').on('shown.bs.tab', function (e) {
    // Tampilkan kembali elemen terkait dengan tab "Login" jika diperlukan
    $('#login').show();
});



$(document).ready(function () {
    const request = window.indexedDB.open("myDatabase", 1);
    let savedDataContainer;

    request.onerror = function (event) {
        console.log("IndexedDB error:", event.target.errorCode);
    };

    request.onupgradeneeded = function (event) {
        const db = event.target.result;

        // Create an object store
        const objectStore = db.createObjectStore("data", { keyPath: "id", autoIncrement: true });

        // Define object store structure
        objectStore.createIndex("host", "host", { unique: false });
        objectStore.createIndex("username", "username", { unique: false });
        objectStore.createIndex("password", "password", { unique: false });
        objectStore.createIndex("routerName", "routerName", { unique: false });
    };

    function saveDataToIndexedDB() {
        const host = $("#modalSaveddHost").val();
        const username = $("#modalSavedUsername").val();
        const password = $("#modalSavedPassword").val();
        const routerName = $("#modalRouterName").val();

        const transaction = request.result.transaction(["data"], "readwrite");
        const objectStore = transaction.objectStore("data");

        const addRequest = objectStore.add({ host, username, password, routerName });

        addRequest.onsuccess = function () {
            console.log("Data saved successfully");
            $("#savedModal").modal("hide");
            
            updateDisplayedData();
        };

        addRequest.onerror = function (error) {
            console.error("Error saving data:", error);
        };
    }

    $("#savedForm").submit(function (event) {
        event.preventDefault();
        saveDataToIndexedDB();
    });

    function displayDataFromIndexedDB() {
        const transaction = request.result.transaction(["data"], "readonly");
        const objectStore = transaction.objectStore("data");

        const cursorRequest = objectStore.openCursor();

        savedDataContainer = $("#savedData");

        cursorRequest.onsuccess = function (event) {
            const cursor = event.target.result;

            if (cursor) {
                const newEntry = $("<div class='row align-items-center savedDataItem'></div>");

                newEntry.html(`
                    <div class="col">
                        <span>
                            <i class="fa-solid fa-server"></i> <span class="small">${cursor.value.host}</span><br>
                            <i class="fa-solid fa-user"></i> <span class="small">${cursor.value.username}</span><br> 
                            <i class="fa-solid fa-note-sticky"></i> <span class="small">${cursor.value.routerName}</span>
                            <p></p>
                        </span>
                    </div>
                    <div class="col-auto">
                        <div class="dropdown">
                            <button class="btn btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item editButton" href="#" data-id="${cursor.value.id}">Edit</a></li>
                                <li><a class="dropdown-item deleteButton" href="#" data-id="${cursor.value.id}">Delete</a></li>
                                <li><a class="dropdown-item useButton" href="#" data-id="${cursor.value.id}">Use</a></li>
                            </ul>
                        </div>
                    </div>
                `);

                savedDataContainer.append(newEntry);

                cursor.continue();
            }
        };

        cursorRequest.onerror = function (error) {
            console.error("Error reading data:", error);
        };
    }

    function displayInitialData() {
        request.onsuccess = function () {
            if (request.result.objectStoreNames.contains("data")) {
                displayDataFromIndexedDB();
            }
        };
    }

    displayInitialData();

    function fillEditForm(dataId) {
        const transaction = request.result.transaction(['data'], 'readonly');
        const objectStore = transaction.objectStore('data');
        const getRequest = objectStore.get(dataId);

        getRequest.onsuccess = function (event) {
            const data = event.target.result;

            $('#editDataId').val(data.id);
            $('#modalSaveddHostEdit').val(data.host);
            $('#modalSavedUsernameEdit').val(data.username);
            $('#modalSavedPasswordEdit').val(data.password);
            $('#modalRouterNameEdit').val(data.routerName);

            $('#editModal').modal('show');
        };

        getRequest.onerror = function (error) {
            console.error('Error getting data for edit:', error);
        };
    }

    $("#savedData").on('click', '.editButton', function () {
        const dataId = $(this).data('id');
        fillEditForm(dataId);
    });

    $("#editForm").submit(function (event) {
        event.preventDefault();
        updateDataInIndexedDB();
    });

    function updateDataInIndexedDB() {
        const dataId = $('#editDataId').val();
        const host = $('#modalSaveddHostEdit').val();
        const username = $('#modalSavedUsernameEdit').val();
        const password = $('#modalSavedPasswordEdit').val();
        const routerName = $('#modalRouterNameEdit').val();

        const transaction = request.result.transaction(['data'], 'readwrite');
        const objectStore = transaction.objectStore('data');

        const updateRequest = objectStore.put({ id: Number(dataId), host, username, password, routerName });

        updateRequest.onsuccess = function () {
            console.log('Data updated successfully');
            $('#editModal').modal('hide');
            updateDisplayedData();
        };

        updateRequest.onerror = function (error) {
            console.error('Error updating data:', error);
        };
    }

    function updateDisplayedData() {
        savedDataContainer.empty();
        displayDataFromIndexedDB();
    }


    $("#savedData").on('click', '.useButton', function () {
        const dataId = $(this).data('id');
        useDataFromIndexedDB(dataId);
    });
    
    function useDataFromIndexedDB(dataId) {
        const transaction = request.result.transaction(['data'], 'readonly');
        const objectStore = transaction.objectStore('data');
        const getRequest = objectStore.get(dataId);
    
        getRequest.onsuccess = function (event) {
            const data = event.target.result;
    
            // Mengisi nilai formulir login dengan data yang sesuai
            $('#host').val(data.host);
            $('#username').val(data.username);
            $('#password').val(data.password);
    
            $('#logoAndText').show();
            // Menutup modal saved jika perlu
            $('#myTabs a[href="#login"]').tab('show');
        };
    
        getRequest.onerror = function (error) {
            console.error('Error getting data for use:', error);
        };
    }
    

    $("#savedData").on('click', '.deleteButton', function () {
        const dataId = $(this).data('id');
        deleteDataFromIndexedDB(dataId);
    });

    function deleteDataFromIndexedDB(dataId) {
        const transaction = request.result.transaction(['data'], 'readwrite');
        const objectStore = transaction.objectStore('data');
        const deleteRequest = objectStore.delete(dataId);

        deleteRequest.onsuccess = function () {
            console.log('Data deleted successfully');
            updateDisplayedData();
        };

        deleteRequest.onerror = function (error) {
            console.error('Error deleting data:', error);
        };
    }
});

















