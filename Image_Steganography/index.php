<?php
    include('db.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>      
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steganography Web App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.0/p5.js"
        integrity="sha512-2r+xZ/Dm8+HI0I8dsj1Jlfchv4O3DGfWbqRalmSGtgdbVQrZyGRqHp9ek8GKk1x8w01JsmDZRrJZ4DzgXkAU+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">

        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Steganography Web App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>

                    </div>
                </div>
            </div>
        </nav>



        <div class="row">

            <div class="col-md-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">Encode</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                            aria-selected="false">Decode</button>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                        tabindex="0">

                        <div class="my-3">

                            <div class="mb-3">
                                <label for="encodeimage1" class="form-label">Original image</label>

                                <input type="file" class="form-control" id="encodeimage1">
                            </div>
                            <div class="my-3">
                                <div class="mb-3">
                                    <label for="secretKeyInput" class="form-label">Secret Key</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="secretKeyInput" readonly>
                                        <button id="generateKeyBtn" type="button" class="btn btn-outline-secondary">Generate Key</button>
                                    </div>
                                </div>
                            </div>


                            <button id="encodebtn" type="button" class="btn btn-primary">Encode</button>

                        </div>



                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                        tabindex="0">

                        <div class="my-3">

                            <div class="mb-3">
                                <label for="decodeimage1" class="form-label">Original image</label>

                                <input type="file" class="form-control" id="decodeimage1">
                            </div>
                            
                            <div class="mb-3">
                                <label for="decodeimage2" class="form-label">Encoded image</label>

                                <input type="file" class="form-control" id="decodeimage2">
                            </div>
                            <div class="my-3">
                                <div class="mb-3">
                                    <label for="secretKeyInput" class="form-label">Secret Key</label>
                                    <input type="text" class="form-control" id="secretKeyInput" placeholder="Enter your secret key">
                                </div>
                            </div>


                            <button id="decodebtn" type="button" class="btn btn-primary">Decode</button>

                        </div>
                        
                    </div>

                </div>

            </div>
            <div class="col-md-8">



                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="secretText" class="form-label">Secret text</label>
                            <textarea class="form-control" id="secretText" rows="3"></textarea>
                        </div>
                    </div>
                </div>



                    <a href="login.php">Logout</a>
                <div id="canvasbox">

                </div>



            </div>

        </div>
    </div>


    <script defer src="./script.js">
        <a href="login.php">Logout</a>


    </script>
</body>

</html>