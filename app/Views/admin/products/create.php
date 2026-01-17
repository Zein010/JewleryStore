<?= view('admin/layout/header') ?>
<?= view('admin/layout/sidebar') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add Product</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="<?= old('slug') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= old('price') ?>" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= old('description') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Images (First image will be main)</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Details (Key-Value Pairs)</label>
                <div id="details-container">
                    <div class="input-group mb-2 detail-row">
                        <input type="text" class="form-control" name="details_keys[]" placeholder="Key (e.g., Material)">
                        <input type="text" class="form-control" name="details_values[]" placeholder="Value (e.g., 18K Gold)">
                        <button type="button" class="btn btn-outline-danger remove-detail">X</button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-secondary" id="add-detail">Add Detail</button>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1" <?= old('featured') ? 'checked' : '' ?>>
                <label class="form-check-label" for="featured">Featured Product</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Product</button>
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
            .replace(/[^\w\s-]/g, '') // Remove non-word chars
            .replace(/\s+/g, '-')     // Replace spaces with -
            .replace(/^-+/, '')       // Remove leading -
            .replace(/-+$/, '');      // Remove trailing -
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
