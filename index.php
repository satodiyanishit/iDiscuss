
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>iDiscuss - Coding Forums</title>

    <style>

    .carousel-inner>.carousel-item>img {
        width: 1000px;
        height: 600px;
    }


        
    .card {
    border-radius: 9px;
    /* background: #3c3c3c; */
    box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
    transition: 1s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
    /* padding: 14px 80px 18px 36px; */
    /* cursor: pointer; */
    background-color: white;
    border-style: solid;
    border-color: white;
    }
    
    #ques{
        min-height: 400px;
    }


    .card:hover {
        transform: scale(1.1);
        /* box-shadow: 0 20px 20px rgba(1, 1, 1, .12), 0 4px 8px rgba(0, 0, 0, .06); */
        /* background-color: #AAA; */
        /* border: 1px solid; */
        /* padding: 10px; */
        box-shadow: 10px 15px 20px black;
    }
    
    </style>

    
  </head>
  <body>
    <?php include 'partials/_header.php'; ?> 
    <?php include 'partials/_dbconnect.php'; ?> 

<!-- slider start here -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1">
                <span></span></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2">
                <span></span></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3">
                <span></span></button>
        </div>
        <div class="carousel-inner ">
            <div class="carousel-item active">
                <img src="photos/display-2.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="photos/display-1.jpeg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="photos/display-4.png" class="d-block w-100" alt="...">
            </div>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- carousel ends here -->
    <!-- category container starts here -->
    <div class="container my-4" id="ques">
        <h2 class="text-center my-3">iDiscuss - Browse Categories</h1>
        <div class="row">
        <!-- Fetch all the categories -->
        <!-- Use a for loop to iterate through categories -->
        <?php 
            $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                // echo $row['category_id'];

                $id = $row['category_id'];
                $cat = $row['category_name'];
                $desc = $row['category_description'];

                // Cards
                echo '<div class="col-md-4 my-4">
                        <div class="card" style="width: 18rem;">
                            <img src="https://source.unsplash.com/500x400/?coding' . $cat . ',programming" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '">' . $cat . '</a></h5>
                                <p class="card-text">' . substr($desc, 0, 90) . '...</p>
                                <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                            </div>
                        </div>
                    </div>';
            }
        ?>
        </div>
    </div>


    <?php include 'partials/_footer.php'; ?> 



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <script>
    const myCarousel = document.getElementById("carouselExampleIndicators");
    const carouselIndicators = myCarousel.querySelectorAll(
        ".carousel-indicators button span"
    );
    let intervalID;

    const carousel = new bootstrap.Carousel(myCarousel);

    window.addEventListener("load", function() {
        fillCarouselIndicator(1);
    });

    myCarousel.addEventListener("slide.bs.carousel", function(e) {
        let index = e.to;
        fillCarouselIndicator(++index);
    });

    function fillCarouselIndicator(index) {
        let i = 0;
        for (const carouselIndicator of carouselIndicators) {
            carouselIndicator.style.width = 0;
        }
        clearInterval(intervalID);
        carousel.pause();

        intervalID = setInterval(function() {
            i++;

            myCarousel.querySelector(".carousel-indicators .active span").style.width =
                i + "%";

            if (i >= 100) {
                // i = 0; -> just in case
                carousel.next();
            }
        }, 50);
    }
    </script>

    
</body>
</html>