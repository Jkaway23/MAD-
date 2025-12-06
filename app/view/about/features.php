<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">✨ <?= $data['title'] ?></h1>
            
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Framework Features:</h3>
                    
                    <ul class="list-group list-group-flush">
                        <?php foreach($data['features'] as $feature): ?>
                            <li class="list-group-item">✅ <?= $feature ?></li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="mt-4">
                        <a href="<?= BASEURL ?>about" class="btn btn-secondary">Back to About</a>
                        <a href="<?= BASEURL ?>home" class="btn btn-primary">Go to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
