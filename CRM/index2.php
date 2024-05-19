<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Ajoutez Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6 text-center">LISTE DES ADMINS</h2>
        <a class="btn btn-info mr-2 py-1 px-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 mb-4 inline-block" href="/CRM/creat1.php" role="button">Ajouter un admin</a>        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-blue-200">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Prénom</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Téléphone</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Données des clients -->
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

                    // Query to fetch clients data
                    $sql = "SELECT * FROM admin";
                    $result = $conn->query($sql);

                    // Display clients data
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='px-4 py-2 text-center'>" . $row["id"] . "</td>";
                            echo "<td class='px-4 py-2 text-center'>" . $row["nom"] . "</td>";
                            echo "<td class='px-4 py-2 text-center'>" . $row["prenom"] . "</td>";
                            echo "<td class='px-4 py-2 text-center'>" . $row["email"] . "</td>";
                            echo "<td class='px-4 py-2 text-center'>" . $row["telephone"] . "</td>";
                            echo "<td class='px-4 py-2 text-center'>";
                            echo '<div class="flex justify-center">'; // Centrer les boutons
                            echo '<a class="btn btn-info mr-2 py-1 px-2 rounded-md bg-blue-500 text-white hover:bg-blue-600" href="/CRM/edit1.php?id=' . $row["id"] . '">Modifier</a>';
                            echo '<a class="btn btn-danger py-1 px-2 rounded-md bg-red-500 text-white hover:bg-red-600" href="/CRM/delete1.php?id=' . $row["id"] . '">Supprimer</a>';
                            echo '</div>';
                            echo "</td>";
                            echo "</tr>";
                            
                        }
                    } else {
                        echo "<tr><td colspan='6'>Aucun admin trouvé</td></tr>";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
