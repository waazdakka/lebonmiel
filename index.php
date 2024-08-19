<?php
require('databaseConfig.php');
try {
  $sql_calcul_stock = "SELECT stock.id, stock.recolte , stock.nombre_pots as `stock_initial`, (stock.nombre_pots -  SUM(vente.nb_pots)) as  `pots_restants`,  SUM(vente.nb_pots) as `pots_vendus` FROM stock LEFT JOIN vente ON vente.stock_id = stock.id GROUP BY stock.id";

  $stmt = $pdo->query($sql_calcul_stock);
  $contentStock = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $potsDisponibles = 0;
  foreach ($contentStock as $key => $row) {
      if (!is_null($row['pots_restants'])) {
      $potsDisponibles = $potsDisponibles + $row['pots_restants'];
    } else {
      $potsDisponibles = $potsDisponibles + $row['stock_initial'];
    }
  }
    } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    }

try {
  $sql_ventes = "SELECT * , vente.created_at as `date_vente` FROM vente LEFT JOIN stock ON vente.stock_id = stock.id ORDER BY vente.created_at DESC";
  $liste_ventes = $pdo->query($sql_ventes);
  $contentVentes = $liste_ventes->fetchAll(PDO::FETCH_ASSOC);

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
        <a class="nav-link" href="index.php">
          <i class="bi bi-graph-up"></i>
          <span>Tableau de Bord</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="admin.php">
          <i class="bi bi-gear"></i>
          <span>Admin</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Tableau de bord</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Total pots disponibles</h5>

                  <div class="d-flex align-items-center">
                    <img src="assets/img/logo.png" alt="">
                    <div class="ps-3">
                      <h6><?php echo $potsDisponibles; ?></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            </div><!-- End Vente -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Vente de miel</h5>
                    <form action="vente_miel.php" method="post">
                      <div class="row mb-3">
                        <label for="stock_id" class="col-sm-2 col-form-label">Récolte</label>
                        <div class="col-sm-6">
                          <select id="stock_id" name="stock_id" class="form-select" required>
                            <?php
                              foreach ($contentStock as $key => $row) {
                                echo '<option value="' . $row['id'] . '">' . ($row['recolte']) . '</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="type_vente" class="col-sm-2 col-form-label">Type de vente</label>
                        <div class="col-sm-6">
                          <select class="form-select" aria-label="Default select example" name="type_vente" id="type_vente" required>
                            <option selected="normale">Normale</option>
                            <option value="famille">Famille</option>
                            <option value="cadeau">Cadeau</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="nombre_pots" class="col-sm-2 col-form-label">Nombre de pots</label> 
                        <div class="col-sm-6">
                          <input id="nombre_pots" name="nombre_pots" type="number" min="1" class="form-control" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="nombre_pots" class="col-sm-2 col-form-label">Vendeur</label> 
                        <div class="col-sm-6">
                          <select id="vendeur" name="vendeur" class="form-select" required>
                              <option>Benoît</option>
                              <option>Félix</option>
                              <option>Maman</option>
                              <option>Papa</option>
                              <option>Raphaël</option>
                          <!-- <input id="vendeur" name="vendeur" type="text" class="form-control" required> -->
                        </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="nombre_pots" class="col-sm-2 col-form-label">Acheteur</label> 
                        <div class="col-sm-6">
                          <input id="acheteur" name="acheteur" type="text" class="form-control" required>
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="submit" value="Soumettre" class="btn btn-primary">Valider</button>
                      </div>
                    </form>
                </div>
              </div>
            </div><!-- End Vente -->

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
                        <th scope="col">Stock Initial</th>
                        <th scope="col">Pots vendus</th>
                        <th scope="col">Pots restants</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($contentStock as $key => $row) {
                          echo "<tr>";
                          echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['recolte']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['stock_initial']) . "</td>";
                          if (is_null($row['pots_vendus'])) {
                            echo "<td>0</td>";
                          } else {
                            echo "<td>" . htmlspecialchars($row['pots_vendus']) . "</td>";  
                          }
                          if (is_null($row['pots_restants'])) {
                            echo "<td>" . htmlspecialchars($row['stock_initial']) . "</td>";
                          } else {
                            echo "<td>" . htmlspecialchars($row['pots_restants']) . "</td>";  
                          }
                          echo "</tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- End Stock -->

            <!-- Ventes -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Ventes</h5>
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Récolte</th>
                        <th scope="col">Nombre de pots</th>
                        <th scope="col">Acheteur</th>
                        <th scope="col">Vendeur</th>
                        <th scope="col">Type de vente</th>
                        <th scope="col">Date de vente</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($contentVentes as $vente) {
                          echo "<tr>";
                          echo "<td>" . htmlspecialchars($vente['id']) . "</td>";
                          echo "<td>" . htmlspecialchars($vente['recolte']) . "</td>";
                          echo "<td>" . htmlspecialchars($vente['nb_pots']) . "</td>";  
                          echo "<td>" . htmlspecialchars($vente['acheteur']) . "</td>";  
                          echo "<td>" . htmlspecialchars($vente['vendeur']) . "</td>";  
                          echo "<td>" . htmlspecialchars($vente['type_vente']) . "</td>";  
                          echo "<td>" . htmlspecialchars($vente['date_vente']) . "</td>";  
                          echo "</tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- Ventes -->
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