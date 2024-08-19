<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
<main class="container mx-auto p-4">
    
    <!-- Layout Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Forms -->
        <div>
            <!-- Add Category Form -->
            <form action="/product-category" method="POST" class="mb-6">
                <input type="hidden" name="_method" value="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Add Category</button>
            </form>

            <!-- Update Category Form -->
            <form action="/product-category" method="POST" class="mb-6" id="updateCategoryForm">
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-4">
                    <label for="updateId" class="block text-sm font-medium text-gray-700">Category ID</label>
                    <input type="text" name="id" id="updateId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="updateName" class="block text-sm font-medium text-gray-700">New Category Name</label>
                    <input type="text" name="name" id="updateName" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Category</button>
            </form>

            <!-- Delete Category Form -->
            <form action="/product-category" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <div class="mb-4">
                    <label for="deleteId" class="block text-sm font-medium text-gray-700">Category ID</label>
                    <input type="text" name="id" id="deleteId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete Category</button>
            </form>
        </div>

        <!-- Display Categories Table -->
        <div>
            <h2 class="text-xl font-semibold mt-8 mb-4">Categories</h2>
            <div class="bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        if (isset($categories)) {
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    echo "<tr>";
                                    echo "<td class='px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900'>{$category['id']}</td>";
                                    echo "<td class='px-4 py-3 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($category['name']) . "</td>";
                                    echo "<td class='px-4 py-3 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($category['created_at']) . "</td>";
                                    echo "<td class='px-4 py-3 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($category['updated_at']) . "</td>";
                                    echo "<td class='px-4 py-3 whitespace-nowrap text-sm font-medium'>";
                                    echo "<button type='button' class='px-2 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-xs' onclick='editCategory({$category['id']}, \"" . htmlspecialchars($category['name']) . "\")'><i class='fas fa-edit'></i></button>";
                                    echo "<form action='/product-category' method='POST' class='inline ml-2'>";
                                    echo "<input type='hidden' name='_method' value='DELETE'>";
                                    echo "<input type='hidden' name='id' value='{$category['id']}'>";
                                    echo "<button type='submit' class='inline-flex items-center px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs'><i class='fas fa-trash'></i></button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='px-4 py-3 text-center text-gray-500'>No categories found.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='px-4 py-3 text-center text-gray-500'>Error: Categories not defined.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script>
    function editCategory(id, name) {
        document.getElementById('updateId').value = id;
        document.getElementById('updateName').value = name;
        document.getElementById('updateCategoryForm').scrollIntoView();
    }
</script>
</body>
</html>
