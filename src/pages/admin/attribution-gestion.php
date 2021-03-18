<?php
require '../../layout/head.php';
require '../../../config/local-server.php';
require '../../../config/config.php';
require '../../controller/admin-function.php';
$users = readUsers();
$computers = readComputers();
$attributions = readAttributionJointure();
// var_dump($attributions);
//  $userAttributions = readUserAtt($attribution_id);
// var_dump($userAttributions);
?>
<title>attribution</title>
</head>

<body>

    <header class="container">
        <?php require '../../layout/navbar.php'; ?>
    </header>

    <div class="container d-flex justify-content-center">

        <div>
            <h1 class="shadow-lg p-3 mb-5 border border-dark rounded ">GESTIONS DES POSTES</h1>
        </div>
    </div>
    <section>
        <div class="container d-flex flex-column align-items-center justify-content-center ">
            <!-- FORMULAIRE -->
            <div class="mb-5   col-lg-8 col-md-8 col-12">

                <h4 class="text-center mb-4"> <?php if (isset($userAttributions)) { echo 'ATTRIBUER  ' . $userAttributions; }
                else { ?> FAIRE UNE ATTRIBUTION   <?php }
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
                    <!-- required
                        pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" 
                        minlength="4"
                        maxlength="30" 
                        size="30" 
                         value="" -->
                    <!-- ATTRIBUTION D UN ADMIN ID EN CHAMPS HIDDEN SUT ON UPDATE UN PROFIL -->
                    <?php if ($update === true) : ?>
                        <input type="hidden" name="attribution_id" value="<?php echo $attribution_id; ?>">
                    <?php endif; ?>

                    <!-- Choix d un utilisateur-->
                    <div class="mb-3">
                        <label class="text-dark mb-0" for="mot de passe1">Choisir un utilisateur </label>
                        <select class="custom-select" id="inputGroupSelect03" aria-label="Example select with button addon" name="user-select">
                            <option selected>Liste utilisateur disponible</option>
                            <?php foreach ($users as $key => $user) : ?>
                                <option value="<?php echo $user['id'];  ?>"><?php echo $user['first_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Choix du post-->
                    <div class="mb-3">
                        <label class="text-dark mb-0" for="mot de passe1">Choisir le poste informatique </label>
                        <select class="custom-select" id="inputGroupSelect03" aria-label="Example select with button addon" name="computer-select">
                            <option selected>Liste ordinateur disponible</option>
                            <?php foreach ($computers as $key => $computer) : ?>
                                <option value="<?php
                                                echo $computer['id']; ?>"> <?php echo $computer['numbers'];
                                                                            ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- choix date -->
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label text-dark mb-0">Date de réservation</label>
                        <input type="date" class="form-control" id="date-select" name="date-select" title="Veuillez selectionner un jour" required value="<?php if (isset($date_select)) {
                                                                                                                                                                echo $date_select;
                                                                                                                                                            } ?>">
                        </input>
                    </div>

                    <!-- BOUTONS CREATE OR UPDATE -->
                    <!-- si on modifie l'utilisateur , on affiche le bouton de mise à jour au lieu du bouton de création -->
                    <?php if ($update === true) : ?>
                        <div class="d-flex justify-content-center m-5">
                            <button type="submit" name="update-attribution" class="btn btn-dark shadow-lg ">Modifier l' attribution</button>
                        </div>
                    <?php else : ?>
                        <div class="d-flex justify-content-center m-5">
                            <button type="submit" name="register-attribution" class="btn btn-dark shadow-lg ">Valider l'attribution</button>
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
            <?php if (empty($attributions)) : ?>
                <h4 class="text-center mb-4">AUCUNNE ATTRIBUTION EN COURS</h4>
            <?php else : ?>
                <h4 class="text-center mb-4">LISTES DES ATTRIBUTIONS</h4>
                <table class="table table-bordered  text-center">

                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Utilisateur</th>
                            <th scope="col">Ordinateur</th>
                            <th scope="col">Crénaux</th>
                            <th scope="col">ID attribution</th>
                            <th colspan="2">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attributions as $key => $attribution) : ?>
                            <div class="user">
                                <tr>
                                    <th scope="row"><?php echo $key + 1; ?></th>
                                    <td class="align-middle "><?php echo $attribution['first_name']; ?></td>
                                    <td class="align-middle "><?php echo $attribution['numbers']; ?></td>
                                    <td class="align-middle " style="font-size:2vh;"><?php echo $attribution['crenaux']; ?></td>
                                    <td class="align-middle " style="font-size:2vh;"><?php echo $attribution['user_id']; ?></td>
                                    <td class="align-middle">
                                        <a class="" href="attribution-gestion.php?edit-attribution=<?php echo $attribution['id']; ?>" role="button">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <a class="text-danger" href="attribution-gestion.php?delete-attribution=<?php echo $attribution['id']; ?>" role="button">
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