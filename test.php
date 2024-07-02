<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
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
    </style>
</head>
<body class="bg-white">

<div class="container mt-1">
    <div class="row row-cards">
        <div class="col-md-6">
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
        <div class="col-md-6">
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
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="candidateDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Candidate Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="frmCandidateDetails">
                <div class="modal-body" id="candidateDetails">
                    <div class="row">
                        <div class="col border-right">
                            <!-- Data from server will be displayed here -->
                            <div class="form-group">
                                <label for='name'>Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="">
                            </div>
                            <div class="form-group">
                                <label for='email'>Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="">
                            </div>
                            <div class="form-group">
                                <label for='mobile'>Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="">
                            </div>
                            <div class="form-group">
                                <label for='skill'>Skill</label>
                                <textarea class = "form-control" id='skills' name="skills" style="min-width: 100%"></textarea>
                            </div>
                            <div class="form-group">
                                <label for='carrier'>Carrier</label>
                                <input type="text" class="form-control" id="carrier" name="carrier" value="">
                            </div>
                        </div>
                        <div class="col">
                            <!-- Add an iframe to display the PDF -->
                            <iframe id="pdfViewer" width="100%" height="500" frameborder="0"></iframe>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control" id="data" name="data" value="">
                    <input type="hidden" class="form-control" id="file" name="file" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </form>
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

    $(document).ready(function() {
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

                // Display progress bar
                this.on("uploadprogress", function(file, progress, bytesSent) {
                    // Update the progress bar during the upload
                    var progressBar = document.getElementById("progress-bar");
                    progressBar.style.width = progress + "%";
                    progressBar.setAttribute("aria-valuenow", progress);
                });

                // Show progress bar container when uploading starts
                this.on("sending", function(file, xhr, formData) {
                    document.getElementById("progress-container").style.display = "block";
                });

                // Hide progress bar container when all files are processed
                this.on("queuecomplete", function() {
                    document.getElementById("progress-container").style.display = "none";
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

                // Display progress bar
                this.on("uploadprogress", function(file, progress, bytesSent) {
                    // Update the progress bar during the upload
                    var progressBar = document.getElementById("progress-bar");
                    progressBar.style.width = progress + "%";
                    progressBar.setAttribute("aria-valuenow", progress);
                });

                // Show progress bar container when uploading starts
                this.on("sending", function(file, xhr, formData) {
                    document.getElementById("progress-container").style.display = "block";
                });

                // Hide progress bar container when all files are processed
                this.on("queuecomplete", function() {
                    document.getElementById("progress-container").style.display = "none";
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

        function showModal(data) {
            try {
                var res = JSON.parse(data);
                // Display data in the modal
                $('#name').val(res.name);
                $('#email').val(res.email);
                $('#mobile').val(res.mobile);
                $('#skills').val(res.skills);
                $('#carrier').val(res.carrier);
                $('#data').val(res.data);
                $('#file').val(res.pdf);
                // var pdfViewverPath = "https://view.officeapps.live.com/op/embed.aspx?src=https://rcsale.wtshub.com/file-sample_100kB.doc";
                // var pdfViewverPath = "https://view.officeapps.live.com/op/embed.aspx?src=http://localhost/readpdf/upload/read_resume_20240207093125_1707294685_Notice_Board_Updated.docx"+res.pdf;
                $("#pdfViewer").attr("src", res.pdf);
                // Show the modal
                $("#candidateDetailModal").modal("show");
            } catch (error) {
                toastr.error("Error parsing JSON response:", error);
            }          
            
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
    });
</script>

</body>
</html>
