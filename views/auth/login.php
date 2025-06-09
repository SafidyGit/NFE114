<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Connexion</title>
</head>
<body>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white card-login">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-4 mt-md-4">
                            <?php if (isset($error)): ?>
                                <?php echo $error; ?>
                                <div class="alert alert-warning alert-dismissible fade show alert-login" role="alert">
                                <p class="error"><?php echo $error; ?></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <h2 class="fw-bold mb-4 text-uppercase" style="color:#dcc171">ACCES</h2>
                            <form method="post" action="index.php?action=login">
                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input type="email"  name="email"  class="form-control form-control-lg " required />
                                    <label class="form-label" for="typeEmailX">Adresse Email</label>
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input type="password"  name="password" class="form-control form-control-lg" required />
                                    <label class="form-label" for="typePasswordX">Mot de passe</label>
                                </div>
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-warning btn-lg px-5" type="submit">Se connecter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>
