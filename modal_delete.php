<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Modal</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        /* Modal styling */
        .modal-dialog {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .modal-content {
            width: 100%;
            max-width: 600px; /* Medium-sized modal */
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: relative; /* For absolute positioning of the close button */
        }
        .modal-header {
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            position: relative;
        }
        .modal-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            text-align: center;
            width: 100%;
        }
        .modal-body {
            padding: 20px;
            text-align: center;
        }
        .modal-footer {
            padding-top: 10px;
            padding-bottom: 10px;
            display: flex;
            justify-content: center; /* Center the buttons */
        }
        /* Button Styling */
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px; /* Smaller button size */
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            margin: 0 10px; /* Add space between buttons */
        }
        .btn-danger {
            background-color: #dc3545; /* Standard Delete button color */
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        /* Close Button Styling */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            color: #333;
            background: none;
            border: none;
            cursor: pointer;
        }
        .close:hover {
            color: #000;
        }
        /* Responsive Styling */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
            }
        }
        /* Flexbox minimization */
        .modal-body p {
            font-size: 16px;
            margin: 0;
        }
        /* Reduce margin and padding */
        .modal-header, .modal-footer {
            padding: 10px 20px;
        }
        .modal-title {
            margin: 0;
        }
        /* Custom link inside the footer */
        #deleteLink {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Modal HTML -->
    <div id="modalMy" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalMyLabel" aria-hidden="true">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header flex-column">
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    <!-- Close button at the top-right corner -->
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p>Do you really want to delete this record? This process cannot be undone.</p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="" id="deleteLink" class="text-white">
                        <button type="button" class="btn btn-danger">Delete</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // JavaScript to handle passing menu_id to delete.php
    document.querySelectorAll('.open-delete-modal').forEach(item => {
        item.addEventListener('click', function() {
            let menuId = this.getAttribute('data-menu-id');
            let deleteLink = document.getElementById('deleteLink');
            deleteLink.setAttribute('href', 'delete.php?c=' + menuId);
        });
    });
</script>
</html>
