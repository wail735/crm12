<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiements - Tout</title>
    <!-- Ajoutez Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Ajoutez Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .modal-enter {
            opacity: 0;
            transform: translateY(-10%);
        }

        .modal-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }

        .modal-exit {
            opacity: 1;
            transform: translateY(0);
        }

        .modal-exit-active {
            opacity: 0;
            transform: translateY(-10%);
            transition: opacity 0.3s ease-in, transform 0.3s ease-in;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Paiements - Tout</h2>
        <a class="btn btn-info mr-2 py-1 px-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 mb-4 inline-block"
            href="/CRM/creatcolis.php" role="button">Ajouter un colis</a>
        <div class="overflow-x-auto">

            <!-- 16 boxes avec différents statuts -->

            <!-- Tableau de données -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-blue-200">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Wilaya</th>
                            <th class="px-4 py-2">Utilsateur</th>
                            <th class="px-4 py-2">catégorie</th>
                            <th class="px-4 py-2">Prix</th>
                            <th class="px-4 py-2">Prix de livraison</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Date De Creation</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Données des colis -->
                        <?php
                        // Database credentials
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "fichier";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $database);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Pagination
                        $limit = 10; // Number of records per page
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page number
                        $offset = ($page - 1) * $limit; // Calculate offset

                        // Query to fetch colis data with pagination
                        $sql = "SELECT * FROM Paiement LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);

                        // Display colis data including the seller's name
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='px-4  py-2 text-center'>" . $row["id"] . "</td>";
                                echo "<td class='px-4 py-2 text-center'>" . $row["wilaya"] . "</td>";
                                echo "<td class='px-4 py-2 text-center'>" . $row["utilisateur"] . "</td>";
                                echo "<td class='px-4 py-2 text-center'>" . $row["catégorie"] . "</td>";
                                echo "<td class='px-4 py-2 text-center'>" . $row["Prix"] . "</td>"; // Display the seller's name
                                echo "<td class='px-4 py-2 text-center'>" . $row["Prix_livraison"] . "</td>";
                                echo "<td class='optionColumn px-4 py-2 text-center'>" . $row["status"] . "</td>"; // Placeholder for option column
                                echo "<td class='px-4 py-2 text-center'>" . $row["date_creation"] . "</td>";
                                echo "<td class='px-4 py-2 text-center'>";
                                echo '<div class="flex justify-center">'; // Center the buttons
                                echo '<button class="text-center btn btn-parameter py-1 px-2 rounded-md bg-gray-500 text-white hover:bg-gray-600 parameter-btn" data-id="' . $row["id"] . '"><i class="fas fa-cog"></i></button>'; // Parameter button with icon
                                echo '</div>';
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Aucun paiement trouvé</td></tr>";
                        }

                        // Close connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Next and Previous Buttons -->
            <div class="flex justify-between mt-4">
                <a href="?page=<?php echo $page > 1 ? $page - 1 : 1; ?>" class="btn btn-info py-1 px-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 <?php echo $page <= 1 ? 'hidden' : ''; ?>">Previous</a>
                <a href="?page=<?php echo $page + 1; ?>" class="btn btn-info py-1 px-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 <?php echo $page >= $totalPages ? 'hidden' : ''; ?>">Next</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div id="modalContent" class="bg-white p-8 rounded-lg shadow-lg w-1/3 modal-enter">
            <span class="absolute top-0 right-0 p-2 cursor-pointer" id="closeModal">
                <i class="fas fa-times text-gray-600"></i> <!-- Vous pouvez remplacer "fas fa-times" par l'icône de votre choix -->
            </span>
           
            <h2 class="text-xl font-bold mb-4">Changer le statut du paiement</h2>
            <form id="statusForm" method="POST">
                <input type="hidden" name="paie_id" id="paieId">
                <div class="mb-4">
                    <label for="status" class="block text-gray-700">Nouveau statut:</label>
                    <select name="status" id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="initialisation">initialisation</option>
                        <option value="En attente">En attente</option>
                        <option value="confirmé">confirmé</option>
                        <option value="En attente de retrait">En attente de retrait</option>
                        <option value="Recu">Recu</option>
                    </select>
                </div>
       
                
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
  
            // Modal functionality
            $('.parameter-btn').on('click', function () {
                var id = $(this).data('id');
                $('#paieId').val(id);
                $('#statusModal').removeClass('hidden').addClass('flex');
                $('#modalContent').removeClass('modal-exit modal-exit-active').addClass('modal-enter-active');
            });

            $('#closeModal').on('click', function () {
                close_modal();
            });

            function close_modal() {
                $('#modalContent').removeClass('modal-enter-active').addClass('modal-exit-active');
                setTimeout(function () {
                    $('#statusModal').removeClass('flex').addClass('hidden');
                }, 300);
            }

            // Submit form data via AJAX
            $('#statusForm').submit(function (e) {
                e.preventDefault(); // Prevent form submission
                var formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    type: 'POST',
                    url: 'update_status1.php', // URL to send the data
                    data: formData,
                    success: function (response) {
                        // Update status in the table
                        var newStatus = $('#status').val();
                        var paieId = $('#paieId').val();
                        $('#statusModal').removeClass('flex').addClass('hidden');
                        $('.optionColumn[data-id="' + paieId + '"]').text(newStatus);
                        // Optionally, you can display a message or perform other actions upon success
                        console.log(response);
                        // You may want to reload the page or update the status column in the table here
                    },
                    error: function (xhr, status, error) {
                        // Handle errors here
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>
