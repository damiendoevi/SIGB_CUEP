<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CUEP | Bibliothécaire</title>

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

    <link href="/css/add-librarian.css" rel="stylesheet">

    <link href="/css/modal.css" rel="stylesheet">
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
                        <h1 class="h3 mb-0 text-gray-800">{{ isset($librarian) ? 'Modification d\'un' : 'Ajout d\'un nouvel' }}  bibliothécaire</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/librarians">Bibliothécaires</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{ isset($librarian) ? 'Modifier' : 'Ajouter' }} Bibliothécaire</li>
                            </ol>
                          </nav>
                    </div>
                    <p class="mb-4">Remplissez les informations ci-dessous pour {{ isset($librarian) ? 'modifier un' : 'ajouter un nouvel' }} bibliothécaire.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold" id="main-title">Formulaire {{ isset($librarian) ? 'de modification' : 'd\'ajout' }}  de bibliothécaire</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($librarian) ? '/librarians/'.$librarian->id : '/librarians' }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($librarian))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-12 mb-lg-0 mb-3 me-md-0 me-3 py-3" id="photo-bloc">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-12 text-center mb-1">
                                                <img src="{{ (isset($librarian) && $librarian->photo!=null) ? '/storage/profiles/'.$librarian->photo : '/img/dafault_photo.png' }}" class="img-thumbnail" alt="" id="ImagePreview">
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <label class="input-group-text" for="ImageInput">Photo</label>
                                                    <input type="file" class="form-control" id="ImageInput" name="photo">
                                                </div>
                                                @error('photo')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-12">
                                        <div class="row mb-lg-3">
                                            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon1">NIP<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son NIP" autofocus required name="npi" value="{{ isset($librarian) ? $librarian->npi : old('npi') }}"> <br>
                                                    </div>
                                                    @error('npi')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon1">Nom<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son nom" required name="lastname" value="{{ isset($librarian) ? $librarian->lastname : old('lastname') }}">
                                                    </div>
                                                    @error('lastname')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon2">Prénoms<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez ses prénoms" required name="firstname" value="{{ isset($librarian) ? $librarian->firstname : old('firstname') }}">
                                                    </div>
                                                    @error('firstname')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon3">+229<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son téléphone" required name="phone_number" value="{{ isset($librarian) ? $librarian->phone_number : old('phone_number') }}">
                                                    </div>
                                                    @error('phone_number')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon4">Email<span class="text-danger fw-bold">*</span></span>
                                                        <input type="email" class="form-control" placeholder="Entrez son email" required name="email" value="{{ isset($librarian) ? $librarian->email : old('email') }}">
                                                    </div>
                                                    @error('email')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon5">Adresse</span>
                                                        <input type="text" class="form-control" placeholder="Entrez son adresse" name="address" value="{{ isset($librarian) ? $librarian->address : old('address') }}">
                                                    </div>
                                                    @error('address')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn" id="submit-btn">{{ isset($librarian) ? 'Modifier' : 'Ajouter' }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <div>
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
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/chart-area-demo.js"></script>
    <script src="/js/demo/chart-pie-demo.js"></script>

    <script src="/js/image-preview.js"></script>

</body>

</html>
