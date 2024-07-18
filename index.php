<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">        
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    
    <title>Resume Upload</title>
    <style>
        table thead th{
            font-size:14px!important;
        }
        table tbody td{
            font-size:12px!important;
        }
        .form-select:focus, .page-link:focus{
            box-shadow:none;
        }
        .fa-file-pdf-o {
            font-size: 16px; /* Adjust the size as needed */
            color: #e74c3c; /* Color for edit icon */
        }
        .fa-pencil-square-o {
            font-size: 16px; /* Adjust the size as needed */
            /* color: #2ecc71; /* Color for edit icon */
        }
        .fa-trash-o {
            font-size: 16px; /* Adjust the size as needed */
            color: #e74c3c; /* Color for delete icon */
        }
        .action-icons {
            display: flex;
            justify-content: space-between; /* Equal space between icons */
            align-items: center; /* Center icons vertically */
        }
        .action-icons a {
            margin: 0 5px; /* Optional: add margin between icons */
        }
        /* Hide table content during drag */
        #dataTable.dragging tbody {
            visibility: hidden;
        }

        /* Style the table box during drag-over */
        #dataTable.dragging {
            border: 2px dashed #00aaff;
            background-color: rgba(0, 170, 255, 0.1);
            position: relative; /* Ensure positioning context for drop-message */
        }
        /* Drop message styling */
        .drop-message {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
            color: #00aaff;
            font-size: 20px;
            font-weight: bold;
            z-index: 10;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.5); /* Light transparent background */
            border-radius: 5px;
            pointer-events: none; /* Ensure the message does not capture mouse events */
        }
    </style>
</head>
<body class="bg-white">

<div class="page">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container mt-1">
                <div class="row row-cards">
                    <div class="col-12 col-sm-6">
                        <div class="card bg-success-lt border rounded-4 border-success">
                            <div class="card-header">
                                <h5 class="card-title text-success">Upload and Verify Resume</h5>
                            </div>
                            <div class="card-body">
                                <!-- Add progress bar container -->
                                <div id="progress-container" class="progress mt-3" style="display:none;">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div>
                                </div>
                                <form action="upload.php" class="dropzone" id="myDropzoneModal">
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="card bg-red-lt border rounded-4 border-red">
                            <div class="card-header">
                                <h5 class="card-title text-danger">Upload Your Resume</h5>
                            </div>
                            <div class="card-body">
                                <!-- Add progress bar container -->
                                <div id="progress-container" class="progress mt-3" style="display:none;">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div>
                                </div>
                                <form action="upload.php" class="dropzone" id="myDropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <!-- <div class="table-responsive"> -->
                    <div id="dropMessage" class="drop-message">Drop to upload File</div>
                    <table id="dataTable" class="table table-striped1 table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Skills</th>
                                <th>Carrier</th>
                                <th>Created at</th>
                                <th>Actions</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="candidateDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Candidate Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="frmCandidateDetails">
                <div class="modal-body" id="candidateDetails">
                    <div class="row">
                        <div class="col border-right">
                            <!-- Data from server will be displayed here -->
                            <div class="form-group mb-2">
                                <label for='name'>Name</label>
                                <input type="text" class="form-control mt-2" id="name" name="name" value="">
                            </div>
                            <div class="form-group mb-2">
                                <label for='email'>Email</label>
                                <input type="text" class="form-control mt-2" id="email" name="email" value="">
                            </div>
                            <div class="form-group mb-2">
                                <label for='mobile'>Mobile</label>
                                <input type="text" class="form-control mt-2" id="mobile" name="mobile" value="">
                            </div>
                            <div class="form-group mb-2">
                                <label for='skill'>Skill</label>
                                <textarea class = "form-control mt-2" id='skills' name="skills" style="min-width: 100%"></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for='carrier'>Carrier</label>
                                <input type="text" class="form-control mt-2" id="carrier" name="carrier" value="">
                            </div>
                        </div>
                        <div class="col">
                            <!-- Add an iframe to display the PDF -->
                            <iframe id="pdfViewer" width="100%" height="500" frameborder="0"></iframe>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control" id="id" name="id" value="">
                    <input type="hidden" class="form-control" id="type" name="type" value="">
                    <input type="hidden" class="form-control" id="data" name="data" value="">
                    <input type="hidden" class="form-control" id="file" name="file" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Modal HTML -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

<script>
    Dropzone.autoDiscover = false;
    var recordIdToDelete = null;

    $(document).ready(function() {        
        showModal('0');
        // Initial DataTable setup
        var dataTable = $('#dataTable').DataTable({
            "ajax": {
                "url": "get-resume.php", // Path to your server-side script
                "type": "POST", // Use POST method for server-side script
                "dataSrc": "" // Empty dataSrc to indicate that data is in a flat JSON array
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "mobile" },
                { "data": "skills" },
                { "data": "carrier" },
                { "data": "created_at" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return  '<div class="action-icons">' + 
                                '<a href="' + row.file + '" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>' + 
                                '<a href="javascript:void(0);" onclick="editFunction(' + row.id + ')" class="edit" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>' + '<a href="javascript:void(0);" onclick="deleteFunction(' + row.id + ')" class="delete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>' +
                                '</div>';
                    },
                    "orderable": false,
                    "searchable": false
                },
                // Add more columns as needed
            ],
            "paging": true, // Enable pagination
            "searching": true, // Enable searching
            "responsive": true, // Enable responsive design
            "order": [[0, 'DESC']], // Default sorting by the first column
            "language": {
                "loadingRecords": "Loading...",
                "zeroRecords": "No records found"
            },
            "initComplete": function(settings, json) {
                // Adjust column classes
                var lengthDiv = $('#dataTable_length').parent();
                var filterDiv = $('#dataTable_filter').parent();

                lengthDiv.removeClass('col-md-6').addClass('col-md-3 kan');
                filterDiv.removeClass('col-md-6').addClass('col-md-3');

                // Add buttons container
                var buttonsHtml = '<div class="col-md-6 text-center">' +
                                    '<button class="btn btn-primary mx-1">All</button>' +
                                    '<button class="btn btn-secondary mx-1">Open</button>' +
                                    '<button class="btn btn-success mx-1">Selected</button>' +
                                    '<button class="btn btn-danger mx-1">Rejected</button>' +
                                    '<button class="btn btn-warning mx-1">Deferred</button>' +
                                  '</div>';
                $(buttonsHtml).insertAfter(lengthDiv);

                // Initialize Dropzone on table rows
                var myDropzone = new Dropzone("#dataTable", {
                    url: "read_data_from_pdf.php",
                    paramName: "file",
                    maxFilesize: 50, // MB
                    maxFiles: 1,
                    acceptedFiles: ".pdf, .doc, .docx",
                    addRemoveLinks: true,
                    clickable: false, // Disable clickable file input
                    init: function() {
                        var dropMessage = $("#dropMessage");

                        this.on("dragenter", function(event) {
                            if ($(event.target).closest('#dataTable').length) {
                                $("#dataTable").addClass("dragging");
                                dropMessage.show();
                            }
                        });

                        this.on("dragleave", function(event) {
                            if (!$(event.target).closest('#dataTable').length) {
                                $("#dataTable").removeClass("dragging");
                                dropMessage.hide();
                            }
                        });

                        this.on("drop", function(event) {
                            $("#dataTable").removeClass("dragging");
                            dropMessage.hide();
                        });

                        this.on("dragover", function(event) {
                            event.preventDefault();
                        });

                        this.on("success", function(file, response) {
                            myDropzone.removeAllFiles(true);
                            showModal(response);
                        });

                        this.on("error", function(file, errorMessage, xhr) {
                            var response = xhr ? xhr.responseText : errorMessage;
                            handleResponse(response, "error");
                            myDropzone.removeFile(file);
                        });
                    }
                });

                // Handle the case when the drag leaves the window
                $(document).on('dragleave', function(event) {
                    if (event.originalEvent.screenX === 0 && event.originalEvent.screenY === 0) {
                        $("#dataTable").removeClass("dragging");
                        $("#dropMessage").hide();
                    }
                });

                // Handle the case when the drag enters or leaves the document
                $(document).on('dragenter', function(event) {
                    if (!$(event.target).closest('#dataTable').length) {
                        $("#dataTable").removeClass("dragging");
                        $("#dropMessage").hide();
                    }
                });

                $(document).on('drop', function(event) {
                    if (!$(event.target).closest('#dataTable').length) {
                        $("#dataTable").removeClass("dragging");
                        $("#dropMessage").hide();
                    }
                });
            }
        });

        $('#dataTable_wrapper').find('.row:nth-child(1), .row:nth-child(3)').addClass('row-cards dvs');
        $('#dataTable_wrapper').find('.row:nth-child(2)').find('.col-sm-12').addClass('table-responsive');

        // Initialize Bootstrap tooltips
        $('body').tooltip({
            selector: '[title]'
        });

        // Initialize Toastr.js
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000
        };

        // Initialize Dropzone
        var myDropzoneModal = new Dropzone("#myDropzoneModal", {
            url: "read_data_from_pdf.php", // Specify the upload URL
            paramName: "file", // Name of the uploaded file parameter
            maxFilesize: 50, // MB
            maxFiles: 1, // Max number of files allowed
            acceptedFiles: ".pdf, .doc, .docx", // Allowed file types
            addRemoveLinks: true, // Add remove links to preview images

            init: function() {
                this.on("success", function(file, response) {
                    // Handle the success event
                    // handleResponse(response, "success");
                    myDropzoneModal.removeAllFiles(true); // Clear Dropzone after success
                    // Display modal with additional data
                    showModal(response);
                });

                this.on("error", function(file, errorMessage, xhr) {
                    // Handle the error event
                    var response = xhr ? xhr.responseText : errorMessage;
                    handleResponse(response, "error");
                    myDropzoneModal.removeFile(file); // Remove the file from Dropzone on error
                });
            }
        });

        var myDropzone = new Dropzone("#myDropzone", {
            url: "upload.php", // Specify the upload URL
            paramName: "file", // Name of the uploaded file parameter
            maxFilesize: 50, // MB
            maxFiles: 1, // Max number of files allowed
            acceptedFiles: ".pdf, .doc, .docx", // Allowed file types
            addRemoveLinks: true, // Add remove links to preview images

            init: function() {
                this.on("success", function(file, response) {
                    // Handle the success event
                    handleResponse(response, "success");
                    myDropzone.removeAllFiles(true); // Clear Dropzone after success
                });

                this.on("error", function(file, errorMessage, xhr) {
                    // Handle the error event
                    var response = xhr ? xhr.responseText : errorMessage;
                    handleResponse(response, "error");
                    myDropzone.removeFile(file); // Remove the file from Dropzone on error
                });
            }
        });

        function handleResponse(response, type) {
            var message = response;
            var toastrType = "error";

            try {
                var json = typeof response === 'object' ? response : JSON.parse(response);

                if (json.status === "success") {
                    message = "File uploaded successfully!";
                    toastrType = "success";
                } else if (json.status === "error") {
                    message = json.message || "Upload failed";
                }
            } catch (e) {
                console.error("Error parsing JSON response:", e);
            }

            toastr[toastrType](message);
            dataTable.ajax.reload(null, false);
        }

        // Submit button click event
        $("#frmCandidateDetails").submit(function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: "POST", // or "GET" depending on your form method
                url: "save.php", // replace with your server endpoint
                data: formData,
                success: function(response) {
                    var res = JSON.parse(response);
                    // Handle the success response from the server
                    if (res.status == 'error') {
                        toastr.error(res.message);
                    } else {
                        dataTable.ajax.reload(null, false);
                        $("#candidateDetailModal").modal("hide");
                        toastr.success(res.message);
                    }
                },
                error: function(error) {                    
                    // Handle the error response from the server
                    toastr.error('Error submitting form!', error);
                    console.error("Error submitting form:", error);
                }
            });
        });

        $('#confirmDelete').click(function() {
            $.ajax({
                url: 'delete.php', // Server-side script to handle the delete request
                type: 'POST',
                data: { id: recordIdToDelete },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status == 'success') {
                        toastr.success("Record deleted successfully");
                        // Refresh the DataTable or remove the row
                        $('#dataTable').DataTable().ajax.reload();
                        // Hide the modal after successful deletion
                        $('#deleteModal').modal('hide');
                    } else {
                        toastr.error("Error: " + res.error);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("An error occurred while trying to delete the record: " + error);
                }
            });
        });
    });

    function showModal(data) {
        if (data == null || data == '') {
            toastr.error("Sorry... PDF format is not supported.");
        } else if (data == '0') {
        } else {
            try {
                var res = JSON.parse(data);

                // Display data in the modal
                if (res.id != null) {
                    $('#id').val(res.id);
                }
                $('#name').val(res.name);
                $('#email').val(res.email);
                $('#mobile').val(res.mobile);
                $('#skills').val(res.skills);
                $('#carrier').val(res.carrier);
                $('#data').val(res.data);
                $('#file').val(res.pdf);
                $('#type').val(res.type);

                // var pdfViewverPath = "https://view.officeapps.live.com/op/embed.aspx?src=https://rcsale.wtshub.com/file-sample_100kB.doc";
                // var pdfViewverPath = "https://view.officeapps.live.com/op/embed.aspx?src=http://localhost/readpdf/upload/read_resume_20240207093125_1707294685_Notice_Board_Updated.docx"+res.pdf;
                $("#pdfViewer").attr("src", res.pdf);
                // Show the modal
                $("#candidateDetailModal").modal("show");
            } catch (error) {
                console.log("error",error);
                toastr.error("Error parsing JSON response:", error);
            }
        }
    }

    function editFunction(id) {
        $.ajax({
            url: 'edit.php', // Server-side script to handle the request
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                // Handle the response here
                var data = JSON.stringify(response);
                showModal(data);
                // $('#editModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error('Error:', error);
            }
        });
    }

    function deleteFunction(id) {
        recordIdToDelete = id;
        $('#deleteModal').modal('show');
    }
</script>