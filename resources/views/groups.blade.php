<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CUEP | Groupes</title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="icon" href="{{ asset('logo_cuep.ico') }}" type="image/x-icon">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

    <link href="/css/side-bar.css" rel="stylesheet">

    <link href="/css/table.css" rel="stylesheet">

    <link href="/css/modal.css" rel="stylesheet">

    <link href="/css/add-type-or-category-or-group.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/pagination.css">

    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    @livewireStyles

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.side-bar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.top-bar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 class="h3 mb-0 text-gray-800">Groupe de lecteurs</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/groups">Prêteur</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Groupes</li>
                            </ol>
                          </nav>
                    </div>

                    @if (Auth::user()->role=="Bibliothécaire")
                        <p class="mb-4">Le tableau présente les détails des groupes, avec des options d'action pour les modifier, les supprimer ou visualiser les membres.</p>
                    @else
                        <p class="mb-4">Gérez les groupes enregistrés. Le tableau présente les détails des groupes, avec une option d'action pour visualiser les membres.</p>
                    @endif

                    @livewire('group');
                <!-- /.container-fluid -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
        })
    </script>

    @livewireScripts

    <script type="text/javascript">
        window.livewire.on('closeModal', () => {
            $('#staticBackdrop').modal('hide');
        });
    </script>
</body>

</html>
