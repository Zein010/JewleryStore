<?= view('admin/layout/header') ?>
<?= view('admin/layout/sidebar') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Product</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('product/' . $product['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info me-2">
            <i class="bi bi-eye"></i> View on Website
        </a>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $product['name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="<?= old('slug', $product['slug']) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= old('category_id', $product['category_id']) == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= old('price', $product['price']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $product['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Existing Images</label>
                <div class="row">
                    <?php if(empty($images)): ?>
                        <div class="col-12"><p class="text-muted">No images found.</p></div>
                    <?php else: ?>
                        <?php foreach($images as $img): ?>
                            <div class="col-6 col-md-3 mb-3 text-center">
                                <img src="<?= base_url('uploads/products/' . $img['image']) ?>" class="img-thumbnail mb-2" style="height: 100px; object-fit: cover;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input me-2" type="radio" name="main_image" value="<?= $img['id'] ?>" <?= $img['is_main'] ? 'checked' : '' ?>>
                                    <label class="form-check-label">Main</label>
                                </div>
                                <a href="<?= base_url('admin/products/delete-image/' . $img['id']) ?>" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Delete this image?')">Delete</a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Add New Images</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Details (Key-Value Pairs)</label>
                <div id="details-container">
                    <?php 
                    $details = json_decode($product['details'] ?? '[]', true);
                    if (!empty($details)): 
                        foreach ($details as $key => $value):
                    ?>
                        <div class="input-group mb-2 detail-row">
                            <input type="text" class="form-control" name="details_keys[]" value="<?= esc($key) ?>" placeholder="Key (e.g., Material)">
                            <input type="text" class="form-control" name="details_values[]" value="<?= esc($value) ?>" placeholder="Value (e.g., 18K Gold)">
                            <button type="button" class="btn btn-outline-danger remove-detail">X</button>
                        </div>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <div class="input-group mb-2 detail-row">
                            <input type="text" class="form-control" name="details_keys[]" placeholder="Key (e.g., Material)">
                            <input type="text" class="form-control" name="details_values[]" placeholder="Value (e.g., 18K Gold)">
                            <button type="button" class="btn btn-outline-danger remove-detail">X</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-sm btn-secondary" id="add-detail">Add Detail</button>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1" <?= old('featured', $product['featured']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="featured">Featured Product</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
    });

    document.getElementById('name').addEventListener('input', function() {
        let slug = this.value.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
        document.getElementById('slug').value = slug;
    });

    document.getElementById('add-detail').addEventListener('click', function() {
        const container = document.getElementById('details-container');
        const row = document.createElement('div');
        row.className = 'input-group mb-2 detail-row';
        row.innerHTML = `
            <input type="text" class="form-control" name="details_keys[]" placeholder="Key">
            <input type="text" class="form-control" name="details_values[]" placeholder="Value">
            <button type="button" class="btn btn-outline-danger remove-detail">X</button>
        `;
        container.appendChild(row);
    });

    document.getElementById('details-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-detail')) {
            e.target.closest('.detail-row').remove();
        }
    });
</script>

<?= view('admin/layout/footer') ?>
