<?php
require '../../layout/head.php';
require '../../../config/local-server.php';
require '../../../config/config.php';
require '../../controller/admin-function.php';
$users = readUsers();
?>
<title>utilisateur</title>
</head>

<body>

    <header class="container">
        <?php require '../../layout/navbar.php'; ?>
    </header>

    <div class="container d-flex justify-content-center">
        <div>
            <h1 class="shadow-lg p-3 mb-5 border border-dark rounded ">UTILISATEUR</h1>
        </div>
    </div>

    <section>
        <div class="container d-flex flex-column align-items-center justify-content-center ">
    
            <!-- FORMULAIRE -->
            <div class="mb-5   col-lg-8 col-md-8 col-12">
            <h4 class="text-center mb-4">  <?php if(isset($last_name)){echo 'MODIFICATION '.$last_name;} 
            else {
                ?> AJOUTER UN UTILISATEUR <?php
            }
            ?></h4>


                <form class="col px-3 py-4 shadow-lg " method="POST" enctype="multipart/form-data">
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

                    <!-- NE PAS AFFACER SERVIRA POUR EXPLIQUER LA SECURIT2 FORMULAIRE DU COT2 DE PHP (double securisation) -->
                    <!-- required
                        pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" 
                        minlength="4"
                        maxlength="30" 
                        size="30" 
                         value="" -->


                    <!-- ATTRIBUTION D UN ADMIN ID EN CHAMPS HIDDEN SUT ON UPDATE UN PROFIL -->
                    <?php if ($update === true) : ?>
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <?php endif ?>


                    <!-- ATTENTION nom et prénom sur la meme ligne ! -->

                    <div class="mb-3 d-flex flex-column flex-md-row justify-content-between">
                        <!-- NOM DATA TYPE VARCHAR-->
                        <div class=" col-md-6 col-12 px-0 mb-3 mb-md-0 pr-md-1">

                            <label for="exampleFormControlInput1" class="form-label text-dark mb-0">Nom*</label>
                            <input type="text" class="form-control" id="nom" name="last_name" placeholder="HUMBLOT" title="Veuillez inscrire votre Nom" required pattern="([A-z0-9À-ž\s]){2,}" minlength="4" maxlength="50" size="50" value="<?php if(isset($last_name)){echo $last_name;}  ?>">
                            </input>
                        </div>

                        <!-- PRENOM DATA TYPE VARCHAR-->
                        <div class="col-md-6 col-12 px-0 pl-md-1">
                            <label for="exampleFormControlInput1" class="form-label text-dark mb-0">Prénom*</label>
                            <input type="text" class="form-control" id="prenom" name="first_name" placeholder="André" title="Veuillez inscrire votre prénom" required pattern="([A-z0-9À-ž\s]){2,}" minlength="4" maxlength="50" size="50" value="<?php if(isset($first_name)){echo $first_name;}  ?>">
                            </input>
                        </div>
                    </div>

                    <!-- EMAIL DATA TYPE SQL VARCHAR -->
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label text-dark mb-0">Email* </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" title="Veuillez inscrire votre email" size="60" minlength="3" maxlength="60" required value="<?php if(isset($email)){echo $email;}  ?>">
                        </input>
                    </div>

                    <!-- MOT DE PASSE DATA TYPE VARCHAR 100 CAR LE MOTE DE PASSE SERA HASHER-->
                    <div class="mb-3 ">
                        <label class="text-dark mb-0" for="mot de passe1">Mot de passe* </label>
                        <input type="password" class="form-control" id="password_1" name="password_1" required pattern="?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Saisir un mot de passe" minlength="1" maxlength="20" size="20" value="">
                        </input>
                    </div>

                    <!-- CONFIRMATION MOT DE PASSE PAS NECESSAIRE A L INSERTION EN BDD MAIS UTILSE POUR CONFIRMER LE PASSWORD-->
                    <div class="mb-3 ">
                        <label class="text-dark mb-0" for="mot de passe2">Confirmation* </label>
                        <input type="password" class="form-control" id="password_2" name="password_2" required pattern="?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Confirmation mot de passe" minlength="1" maxlength="20" size="20" value="">
                        </input>
                    </div>

                    <!-- TELEPHONE -->
                    <div class="mb-3 text-start">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="0692010203" title="Inscrire votre numéro de téléphone (format 00 00 00 00 00)" required pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" value="<?php if(isset($phone)){echo $phone;} ?>">
                    </div>


                    <!-- BOUTONS CREATE OR UPDATE -->
                    <!-- si on modifie l'utilisateur , on affiche le bouton de mise à jour au lieu du bouton de création -->
                    <?php if ($update === true) : ?>
                    <div class="d-flex justify-content-center m-5">
                        <button type="submit" name="update-user" class="btn btn-dark shadow-lg ">Mettre à jour un utilistateur</button>
                        </div>
                    <?php else : ?>
                        <div class="d-flex justify-content-center m-5"> 
                        <button type="submit" name="register-user" class="btn btn-dark shadow-lg ">Ajouter un utilisateur</button>
                        </div>
                    <?php endif; ?>
                    <!-- BOUTON AJOUTER -->
                    <!-- <div class="d-flex justify-content-center m-5 ">
                        <button type="submit" name="register-user" class="btn btn-dark shadow-lg ">Ajouter un utilisateur</button>
                    </div> -->
                    <div class="mt-3 d-flex justify-content-center"> <i>(* Champs obligatoires)</i></div>
                </form>
            </div>
        </div>
    </section>

    <section class="container col-10 mb-5">
        <div>
            <?php if (empty($users)) : ?>
                <h4 class="text-center mb-4">AUCUN UTILISATEUR</h4>
            <?php else : ?>
                <h4 class="text-center mb-4">LISTES DES UTILISATEURS</h4>
             

                <table class="table table-bordered  text-center">

                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">nom d'utilisateur</th>
                            <th scope="col">email</th>
                            <th scope="col">Téléphone</th>
                            <th colspan="2">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $key => $user) : ?>
                            <div class="user">
                                <tr>

                                    <th scope="row"><?php echo $key + 1; ?></th>
                                    <td class="align-middle "><?php echo $user['last_name']; ?></td>
                                    <td class="align-middle " style="font-size:2vh;"><?php echo $user['email']; ?></td>
                                    <td class="align-middle " style="font-size:2vh;"><?php echo $user['phone']; ?></td>
                                    <td class="align-middle">
                                        <a class="" href="user-gestion.php?edit-user=<?php echo $user['id']; ?>" role="button">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="align-middle">

                                        <a class="text-danger" href="user-gestion.php?delete-user=<?php echo $user['id']; ?>" role="button">
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


    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>


<div class="container  d-flex justify-content-center">
    <?php require '../../layout/footer.php'; ?>
</div>

</html>