<?php
// Memasukkan file header, file database (db.php), dan file util.php
require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';
require __DIR__ . '/util.php';

// Memeriksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    $title = filter_input(INPUT_POST, 'title');
    $description = filter_input(INPUT_POST, 'description');
    $price = filter_input(INPUT_POST, 'price');
    $category = filter_input(INPUT_POST, 'category');

    // Memeriksa apakah kategori sudah ada di database
    $statement = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE title=?");
    $statement->execute([$category]);
    
    // Jika kategori belum ada, tambahkan kategori baru
    if ($statement->fetchColumn() === 0) {
        $statement = $pdo->prepare("INSERT INTO categories(title) VALUES (?)");
        $statement->execute([$category]);
    }

    // Mendapatkan paths dari gambar yang diupload
    $paths = serialize(uploadImages());

    // Menyimpan data produk ke database
    $statement = $pdo->prepare("INSERT INTO products(title, price, description, category, images) VALUES (?, ?, ?, ?, ?)");
    $statement->execute([$title, $price, $description, $category, $paths]);
    header('Location: /admin/products');
}

// Mengambil data kategori dari database
$statement = $pdo->prepare("SELECT * FROM categories");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-header">Create Product</div>
            <div class="card-body">
                <div class="col-md-6">
                    <form action="/admin/products/create" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" min=0 step=0.01 required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" style="resize:none" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="language" class="form-label">Category</label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="category">
                                    <option value="" selected>Pilih Kategori</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['title'] ?>">
                                            <?= $category['title'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Images</label>
                            <input class="form-control" name="files[]" type="file" id="formFile1" multiple required>
                            <small class="text-muted">Select product images</small>
                        </div>

                        <div class="mb-3 text-end">
                            <button name="submit" type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
<script>
    // Mengubah nilai input #category saat pilihan di dropdown berubah
    $('select[name="category"]').change(function () {
        $('#category').val($(this).val());
    });
</script>
