<?php
require('databaseConfig.php');
try {
        $sql = "SELECT * FROM `stock` order by `id` DESC";
        $stmt = $pdo->query($sql);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tableau de Bord - Le Bon Miel des Ruches de Nicolas</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Le Bon Miel</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-graph-up"></i>
          <span>Tableau de Bord</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="admin.php">
          <i class="bi bi-gear"></i>
          <span>Admin</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Administration</h1>
    </div>

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Stock -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <h5 class="card-title">Stock</h5>

                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Récolte</th>
                        <th scope="col">Nombre de pots</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while ($row = $stmt->fetch()) {
                          echo "<tr>";
                          echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['recolte']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['nombre_pots']) . "</td>";
                          echo "</tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- End Stock -->
            </div><!-- End Vente -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Ajouter une récolte</h5>
                    <form action="ajout_recolte.php" method="post">
                      <div class="row mb-3">
                        <label for="recolte" class="col-sm-2 col-form-label">Intitulé de la récolte</label>
                        <div class="col-sm-6">
                          <input id="recolte" name="recolte" type="text" class="form-control">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="nombre_pots" class="col-sm-2 col-form-label">Nombre de pots</label>
                        <div class="col-sm-6">
                          <input id="nombre_pots" name="nombre_pots" type="number" min="1" class="form-control">
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="submit" value="Soumettre" class="btn btn-primary">Valider</button>
                      </div>
                    </form>
                </div>
              </div>
            </div><!-- End Vente -->
          </div>
        </div><!-- End Left side columns -->
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="credits">
      Le Bon Miel des Ruches de Nicolas
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/main.js"></script>

</body>

</html>