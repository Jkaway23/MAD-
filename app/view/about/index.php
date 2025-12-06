<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">📚 <?= $data['title'] ?></h1>
            
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?= $data['framework_name'] ?></h3>
                    <p class="card-text"><strong>Version:</strong> <?= $data['version'] ?></p>
                    <p class="card-text"><?= $data['description'] ?></p>
                    
                    <hr>
                    
                    <h4>🔧 How It Works:</h4>
                    <ol>
                        <li><strong>URL Request:</strong> User mengakses URL (misal: /about)</li>
                        <li><strong>.htaccess:</strong> Mengubah URL menjadi index.php?url=about</li>
                        <li><strong>App.php (Router):</strong> Memparse URL dan load Controller "About"</li>
                        <li><strong>Controller:</strong> Menjalankan method index() dan load data</li>
                        <li><strong>View:</strong> Menampilkan halaman HTML dengan data</li>
                    </ol>
                    
                    <hr>
                    
                    <h4>📁 Struktur MVC:</h4>
                    <ul>
                        <li><strong>Model:</strong> app/model/ - Berinteraksi dengan database</li>
                        <li><strong>View:</strong> app/view/ - Template HTML</li>
                        <li><strong>Controller:</strong> app/controller/ - Business logic</li>
                        <li><strong>Core:</strong> app/core/ - Framework engine (App, Controller, Database)</li>
                    </ul>
                    
                    <div class="mt-4">
                        <a href="<?= BASEURL ?>about/features" class="btn btn-primary">View Features</a>
                        <a href="<?= BASEURL ?>home" class="btn btn-secondary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
