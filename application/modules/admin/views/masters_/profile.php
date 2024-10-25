<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertical Pills</title>
    <!-- Add your CSS links here -->
</head>
<body>
    <div class="row"> 
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Vertical Pills</h4>
                    <p class="card-description">Add class <code>.nav-pills-vertical</code> to <code>.nav</code> and <code>.tab-content-vertical</code> to <code>.tab-content</code></p>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <ul class="nav nav-pills nav-pills-vertical nav-pills-info" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <li class="nav-item">
                                    <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true" onclick="openTab('v-pills-home')">
                                        <i class="mdi mdi-home-outline"></i> Home 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false" onclick="openTab('v-pills-profile')">
                                        <i class="mdi mdi-account-outline"></i> Profile 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false" onclick="openTab('v-pills-messages')">
                                        <i class="mdi mdi-email-open-outline"></i> Messages 
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-8">
                            <div class="tab-content tab-content-vertical" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body mt-4 mt-sm-0">
                                            <h5 class="mt-0">home</h5>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body mt-4 mt-sm-0">
                                        <h5 class="mt-0">profile</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    <div class="media d-block d-sm-flex">
                                        <img class="me-3 w-25 rounded" src="../../../assets/images/samples/300x300/14.jpg" alt="sample image">
                                        <div class="media-body mt-4 mt-sm-0">
                                            <p> I'm really more an apartment person. This man is a knight in shining armor. Oh I beg to differ, I think we have a lot to discuss. After all, you are a client. You all right, Dexter? </p>
                                            <p> I'm generally confused most of the time. Cops, another community I'm not part of. You're a killer. I catch killers. Hello, Dexter Morgan. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add your JavaScript code here -->
    <script>
        function openTab(tabId) {
            var tab = document.getElementById(tabId);
            var tabLink = document.getElementById(tabId + '-tab');
            var tabs = document.querySelectorAll('.nav-link');
            var tabContents = document.querySelectorAll('.tab-pane');

            // Remove 'active' class from all tabs and tab contents
            tabs.forEach(function(el) {
                el.classList.remove('active');
            });

            tabContents.forEach(function(el) {
                el.classList.remove('show', 'active');
            });

            // Add 'active' class to the clicked tab and tab content
            tab.classList.add('show', 'active');
            tabLink.classList.add('active');
        }
    </script>
</body>
</html>
