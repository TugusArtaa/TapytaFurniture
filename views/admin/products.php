<?php
// Memasukkan file header.php yang mungkin berisi konfigurasi halaman header
require __DIR__ . '/header.php';

// Memasukkan file db.php yang berisi koneksi ke database
require __DIR__ . '/../db.php';

// Memasukkan file util.php yang mungkin berisi fungsi utilitas
require __DIR__ . '/util.php';

// Mendefinisikan variabel $items, $categories, dan $edit
$items;
$categories;
$edit = false;

// Menangani form submission
if (isset($_POST['submit'])) {
    // Mendapatkan id dari input POST dan membersihkannya menggunakan filter
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Update title jika tidak kosong
    if (!empty($_POST['title'])) {
        $statement = $pdo->prepare("UPDATE products SET title=? WHERE id=?");
        $statement->execute([filter_input(INPUT_POST, 'title'), $id]);
    }

    // Update price jika tidak kosong
    if (!empty($_POST['price'])) {
        $statement = $pdo->prepare("UPDATE products SET price=? WHERE id=?");
        $statement->execute([filter_input(INPUT_POST, 'price'), $id]);
    }

    // Update description jika tidak kosong
    if (!empty($_POST['description'])) {
        $statement = $pdo->prepare("UPDATE products SET description=? WHERE id=?");
        $statement->execute([filter_input(INPUT_POST, 'description'), $id]);
    }

    // Update category jika tidak kosong
    if (!empty($_POST['category'])) {
        $category = filter_input(INPUT_POST, 'category');

        // Check if category exists
        $statement = $pdo->prepare("SELECT * FROM categories WHERE title=?");
        $statement->execute([$category]);

        if (!$statement->rowCount() > 0) {
            // Insert category if not exists
            $statement = $pdo->prepare("INSERT INTO categories(title) VALUES (?)");
            $statement->execute([$category]);
        }

        // Update product with category
        $statement = $pdo->prepare("UPDATE products SET category=? WHERE id=?");
        $statement->execute([$category, $id]);
    }

    // Update images jika ada file yang diunggah
    if (isset($_FILES['files'])) {
        $path = serialize(uploadImages());
        $statement = $pdo->prepare("UPDATE products SET images=? WHERE id=?");
        $statement->execute([$path, $id]);
    }
}

// Menangani request GET untuk edit
if (isset($_GET['id'])) {
    $edit = true;
    $statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $statement->execute(array(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
    if ($statement->rowCount() > 0) {
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    $statement = $pdo->prepare("SELECT * FROM categories");
    $statement->execute();
    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Menangani penghapusan data jika form delete di-submit
    if (isset($_POST['delete'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $statement = $pdo->prepare("DELETE FROM products WHERE id=?");
        $statement->execute(array($id));
    }

    // Mengambil semua produk dari database jika tidak sedang melakukan edit
    $statement = $pdo->prepare("SELECT * FROM products");
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Mengambil semua kategori dari database
$statement = $pdo->prepare("SELECT * FROM categories");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="page-title">
        <h3>Products
            <a href="/admin/products/create" class="btn btn-sm btn-outline-primary float-end"><i
                    class="fas fa-plus"></i> Add</a>
        </h3>
    </div>
    <?php if ($edit): ?>
        <div class="card">
            <div class="card-header">Create Product</div>
            <div class="card-body">
                <div class="col-md-6">
                    <form action="/admin/products" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="<?= $items[0]['title'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" value="<?= $items[0]['price'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description"
                                style="resize:none"><?= $items[0]['description'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="language" class="form-label">Category</label>
                            <div class="input-group mb3">
                                <div class="dropdown input-group-prepend">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        Choose
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <?php foreach ($categories as $category): ?>
                                            <li><a class="dropdown-item"
                                                    href="#"><?= $category['title'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <input id="category" type="text" name="category" class="form-control"
                                    aria-label="Text input with dropdown button"
                                    value="<?= $edit ? $items[0]['category'] : '' ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Images</label>
                            <input class="form-control" name="files[]" type="file" id="formFile1" multiple>
                            <small class="text-muted">Select product images</small>
                        </div>

                        <div class="mb-3 text-end">
                            <input type="text" name="id" value="<?= $edit ? $items[0]['id'] : '' ?>" hidden>
                            <button name="submit" type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="box box-primary">
            <div class="box-body">
                <table width="100%" class="table table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($items)): ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <?= $item['title'] ?>
                                    </td>
                                    <td>Rp
                                        <?= number_format($item['price'], 2) ?>
                                    </td>
                                    <td>
                                        <?= $item['description'] ?>
                                    </td>
                                    <td>
                                        <?= $item['category'] ?>
                                    </td>
                                    <td class="text-end">
                                        <form action="/admin/products" method="post">
                                            <input type="text" name="id" value="<?= $item['id'] ?>" hidden>
                                            <a href="/admin/products?id=<?= $item['id']; ?>"
                                                class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
                                            <button name="delete" type="submit"
                                                class="btn btn-outline-danger btn-rounded"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>
</div>

<?php
// Memasukkan file footer.php yang mungkin berisi konfigurasi halaman footer
require __DIR__ . '/footer.php';
?>
<script>
    // Menambahkan event listener untuk item dropdown yang akan mengubah nilai input kategori
    $('.dropdown-item').click(function () {
        $('#category').val($(this).text())
    })
</script>
