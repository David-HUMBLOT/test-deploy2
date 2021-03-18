<?php 
require '../../../config/local-server.php';
require '../../../config/config.php';
require '../../controller/admin-function.php';
require '../../layout/head.php';

?>
<title>Loggin</title>
</head>

<body>
<header>
        <div  class=" container d-flex justify-content-center mt-5 pt-2">
            <div class="m-3">
                <h1  class=" shadow-lg p-3 mb-5 border border-dark  rounded vw-75">CONNECTION</h1>
            </div>
        </div>
    </header>

    


    <section>
        <div class="container d-flex flex-column align-items-center justify-content-center ">
            <div class="mb-5   col-lg-8 col-md-8 col-12">
                <form class="col px-3 py-4 shadow-lg " method="POST" enctype="multipart/form-data">

                    <!-- MESSAGE D ERREUR -->
                    <?php if (count($errors) > 0) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($errors as $error) : ?>
                                <p><?php echo $error ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif ?>


                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label text-dark mb-0">Email* </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" title="Veuillez inscrire votre email" size="60" minlength="3" maxlength="60"  required>
                        </input>
                    </div>

                    <div class="mb-3 ">
                        <label class="text-dark mb-0" for="mot de passe1">Mot de passe* </label>
                        <input type="password" class="form-control" id="password_1" name="password" required pattern="?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Saisir un mot de passe" minlength="1" maxlength="20" size="20" value="">
                        </input>
                    </div>


                    <div class="d-flex justify-content-center m-5 ">
                <button name="connect-admin" type="submit" class="btn btn-dark btn-lg">CONNECTION</button>
            </div>

                 

                </form>
            </div>
        </div>
    </section>


    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>