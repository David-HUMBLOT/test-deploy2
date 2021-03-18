<?php
require '../../layout/head.php';
require '../../../config/local-server.php';
require '../../../config/config.php';
require '../../controller/admin-function.php';
$computers = readComputers();


?>
<title>attribution</title>
</head>

<body>

    <header class="container">
        <?php require '../../layout/navbar.php'; ?>
    </header>

    <div class="container d-flex justify-content-center">
        <!-- LOGO -->
        <div class="m-0">
            <h1 class="shadow-lg p-3 mb-5 border border-dark  rounded ">ORDINATEUR</h1>
        </div>
    </div>
    <section>
        <div class="container d-flex flex-column align-items-center justify-content-center ">
    
            <!-- FORMULAIRE -->
            <div class="mb-5   col-lg-8 col-md-8 col-12">
            <h4 class="text-center mb-4"> <?php if(isset($number)){echo ' MODIFIER LE PC '. $number;}
            else { ?> AJOUTER UN ORDINATEUR <?php }
            ?></h4>

                <form class="col px-3 py-4 shadow-lg " method="POST">

                    <!-- MESSAGE D ERREUR -->
                    <?php if (count($errors) > 0) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($errors as $error) : ?>
                                <p><?php echo $error ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif ?>

                    <!-- MESSAGE SUCCESS -->
                    <?php if (count($success) > 0) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php foreach ($success as $successs) : ?>
                                <p><?php echo ($successs); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- ATTRIBUTION D UN ADMIN ID EN CHAMPS HIDDEN SUT ON UPDATE UN PROFIL -->
                    <?php if ($update === true) : ?>
                        <input type="hidden" name="computer_id" value="<?php echo $computer_id; ?>">
                    <?php endif ?>

                    <!-- Post informatique-->
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label text-dark mb-5">Numéro du poste informatique <br><i>(les posts sont desactivé par défaut)</i></label>
                        <input type="number" class="form-control" id="number" name="number" placeholder="Numéro du Post" title="Veuillez saisir le numéro du poste"  value="<?php if(isset($number)){echo $number;} ?>">
                        </input>
                    </div>

           

                    <?php if ($update === true) : ?>
                        <div class="d-flex justify-content-center m-5 ">
                        <button type="submit" name="update-computer" class="btn btn-dark shadow-lg ">Modifier cet ordinateur</button>
                    </div>
                    <?php else : ?>
                        <div class="d-flex justify-content-center m-5 ">
                        <button type="submit" name="register-computer" class="btn btn-dark shadow-lg ">Ajouter un ordinateur</button>
                    </div>
                    <?php endif; ?>


                    <!-- BOUTON AJOUTER ORDINATEUR -->
                    <!-- <div class="d-flex justify-content-center m-5 ">
                        <button type="submit" name="register-computer" class="btn btn-dark shadow-lg ">Ajouter un ordinateur</button>
                    </div> -->

                </form>
            </div>
        </div>
    </section>

    <section class="container col-10 mb-5">
        <div>
            <?php if (empty($computers)) : ?>
                <h4 class="text-center mb-4">AUCUN ORDINATEUR</h4>
            <?php else : ?>
                <h4 class="text-center mb-4">LISTE DES ORDINATEURS</h4>
                <table class="table table-bordered  text-center">

                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Numéro ordinateur</th>
                            <th scope="col">id</th>
                            <th scope="col">Etat</th>
                            <th colspan="2">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($computers as $key => $computer) : ?>
                            <div class="user">
                                <tr>

                                    <th scope="row"><?php echo $key + 1; ?></th>
                                    <td class="align-middle "><?php echo $computer['numbers']; ?></td>
                                    <td class="align-middle " style="font-size:2vh;"><?php echo $computer['id']; ?></td>
                                    <td class="align-middle " style="font-size:2vh;"><?php echo $computer['etat']; ?></td>
                                    <td class="align-middle">
                                        <a class="" href="computer-gestion.php?edit-computer=<?php echo $computer['id']; ?>" role="button">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="align-middle">

                                        <a class="text-danger" href="computer-gestion.php?delete-computer=<?php echo $computer['id']; ?>" role="button">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16" disabled>
                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </section>

    <div class="container  d-flex justify-content-center">
        <?php require '../../layout/footer.php'; ?>
    </div>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>


</html>